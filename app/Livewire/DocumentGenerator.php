<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LoanRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DocumentGenerator extends Component
{
    public $loanRequest;
    public $documentType = 'loan_application'; // loan_application, approval_letter, collection_receipt
    public $showPreview = false;
    public $isGenerating = false;
    
    public $documentTypes = [
        'loan_application' => [
            'title' => 'Borang Permohonan Pinjaman Peralatan ICT',
            'title_en' => 'ICT Equipment Loan Application Form',
            'description' => 'Dokumen rasmi permohonan pinjaman peralatan ICT',
            'template' => 'documents.loan-application',
            'filename' => 'Permohonan_Pinjaman_ICT'
        ],
        'approval_letter' => [
            'title' => 'Surat Kelulusan Pinjaman',
            'title_en' => 'Loan Approval Letter',
            'description' => 'Surat rasmi kelulusan permohonan pinjaman',
            'template' => 'documents.approval-letter',
            'filename' => 'Surat_Kelulusan'
        ],
        'collection_receipt' => [
            'title' => 'Resit Pengambilan Peralatan',
            'title_en' => 'Equipment Collection Receipt',
            'description' => 'Resit pengambilan peralatan yang diluluskan',
            'template' => 'documents.collection-receipt',
            'filename' => 'Resit_Pengambilan'
        ],
        'return_receipt' => [
            'title' => 'Resit Pemulangan Peralatan',
            'title_en' => 'Equipment Return Receipt',
            'description' => 'Resit pemulangan peralatan yang dipinjam',
            'template' => 'documents.return-receipt',
            'filename' => 'Resit_Pemulangan'
        ]
    ];

    public function mount($loanRequestId = null)
    {
        if ($loanRequestId) {
            $this->loanRequest = LoanRequest::with([
                'user', 
                'equipmentItems', 
                'approvals.approver'
            ])->findOrFail($loanRequestId);
        }
    }

    public function setDocumentType($type)
    {
        if (array_key_exists($type, $this->documentTypes)) {
            $this->documentType = $type;
            $this->showPreview = false;
        }
    }

    public function generatePreview()
    {
        if (!$this->loanRequest) {
            session()->flash('error', 'Tiada permohonan dipilih untuk dijana.');
            return;
        }

        $this->showPreview = true;
    }

    public function generatePDF()
    {
        if (!$this->loanRequest) {
            session()->flash('error', 'Tiada permohonan dipilih untuk dijana.');
            return;
        }

        $this->isGenerating = true;

        try {
            $documentConfig = $this->documentTypes[$this->documentType];
            
            // Prepare data for the document
            $data = $this->prepareDocumentData();
            
            // Generate PDF
            $pdf = Pdf::loadView($documentConfig['template'], $data);
            $pdf->setPaper('A4', 'portrait');
            
            // Generate filename with timestamp
            $timestamp = Carbon::now()->format('YmdHis');
            $referenceNumber = $this->loanRequest->reference_number ?? 'UNKNOWN';
            $filename = "{$documentConfig['filename']}_{$referenceNumber}_{$timestamp}.pdf";
            
            // Store the document
            $pdfContent = $pdf->output();
            $filePath = "documents/{$this->loanRequest->id}/{$filename}";
            Storage::disk('public')->put($filePath, $pdfContent);
            
            // Update loan request with document path if it's the main application
            if ($this->documentType === 'loan_application' && !$this->loanRequest->document_path) {
                $this->loanRequest->update(['document_path' => $filePath]);
            }
            
            session()->flash('message', 'Dokumen telah berjaya dijana dan disimpan.');
            
            // Download the file
            return response()->download(
                Storage::disk('public')->path($filePath),
                $filename,
                ['Content-Type' => 'application/pdf']
            );
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat ralat semasa menjana dokumen: ' . $e->getMessage());
        } finally {
            $this->isGenerating = false;
        }
    }

    public function downloadExisting($documentPath)
    {
        if (!Storage::disk('public')->exists($documentPath)) {
            session()->flash('error', 'Dokumen tidak dijumpai.');
            return;
        }

        $filename = basename($documentPath);
        return response()->download(
            Storage::disk('public')->path($documentPath),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    private function prepareDocumentData()
    {
        $baseData = [
            'loanRequest' => $this->loanRequest,
            'user' => $this->loanRequest->user,
            'equipmentItems' => $this->loanRequest->equipmentItems,
            'generatedAt' => Carbon::now(),
            'generatedBy' => Auth::user(),
        ];

        // Add document-specific data
        switch ($this->documentType) {
            case 'loan_application':
                return array_merge($baseData, [
                    'title' => 'BORANG PERMOHONAN PINJAMAN PERALATAN ICT',
                    'ministry' => 'KEMENTERIAN PELANCONGAN, SENI DAN BUDAYA MALAYSIA',
                    'department' => 'BAHAGIAN PENGURUSAN MAKLUMAT'
                ]);

            case 'approval_letter':
                $latestApproval = $this->loanRequest->approvals()
                    ->where('status', 'approve')
                    ->latest()
                    ->first();
                    
                return array_merge($baseData, [
                    'title' => 'SURAT KELULUSAN PERMOHONAN PINJAMAN PERALATAN ICT',
                    'approval' => $latestApproval,
                    'approver' => $latestApproval?->approver,
                    'letterNumber' => $this->generateLetterNumber(),
                ]);

            case 'collection_receipt':
                return array_merge($baseData, [
                    'title' => 'RESIT PENGAMBILAN PERALATAN ICT',
                    'collectionDate' => $this->loanRequest->collected_at ?? Carbon::now(),
                    'receiptNumber' => $this->generateReceiptNumber('COL'),
                ]);

            case 'return_receipt':
                return array_merge($baseData, [
                    'title' => 'RESIT PEMULANGAN PERALATAN ICT',
                    'returnDate' => Carbon::now(),
                    'receiptNumber' => $this->generateReceiptNumber('RET'),
                ]);

            default:
                return $baseData;
        }
    }

    private function generateLetterNumber()
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->format('m');
        $sequence = str_pad($this->loanRequest->id, 4, '0', STR_PAD_LEFT);
        
        return "MOTAC/BPM/ICT/{$sequence}/{$month}/{$year}";
    }

    private function generateReceiptNumber($prefix)
    {
        $year = Carbon::now()->year;
        $sequence = str_pad($this->loanRequest->id, 4, '0', STR_PAD_LEFT);
        
        return "{$prefix}/{$sequence}/{$year}";
    }

    public function getAvailableDocuments()
    {
        if (!$this->loanRequest) return collect();

        $documents = collect();
        
        // Check for existing documents in storage
        $documentsPath = "documents/{$this->loanRequest->id}";
        if (Storage::disk('public')->exists($documentsPath)) {
            $files = Storage::disk('public')->files($documentsPath);
            foreach ($files as $file) {
                $documents->push([
                    'name' => basename($file),
                    'path' => $file,
                    'size' => Storage::disk('public')->size($file),
                    'created' => Carbon::createFromTimestamp(Storage::disk('public')->lastModified($file))
                ]);
            }
        }

        return $documents->sortByDesc('created');
    }

    public function canGenerateDocument($type)
    {
        if (!$this->loanRequest) return false;

        switch ($type) {
            case 'loan_application':
                return true; // Can always generate application form
                
            case 'approval_letter':
                return $this->loanRequest->status === 'approved';
                
            case 'collection_receipt':
                return in_array($this->loanRequest->status, ['ready_for_collection', 'collected']);
                
            case 'return_receipt':
                return $this->loanRequest->status === 'collected';
                
            default:
                return false;
        }
    }

    public function render()
    {
        return view('livewire.document-generator', [
            'availableDocuments' => $this->getAvailableDocuments()
        ]);
    }
}
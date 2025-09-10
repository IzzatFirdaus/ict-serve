<?php

declare(strict_types=1);

namespace App\Livewire\Helpdesk;

use App\Models\HelpdeskTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.iserve')]
class AttachmentManager extends Component
{
    use WithFileUploads;

    public HelpdeskTicket $ticket;

    #[Validate(['files.*' => 'required|file|max:5120'])] // 5MB max per file
    public array $files = [];

    public string $attachmentDescription = '';

    // Current attachments
    public array $attachments = [];

    protected array $rules = [
        'files.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,xlsx,xls,txt,zip|max:5120',
        'attachmentDescription' => 'nullable|string|max:500',
    ];

    protected array $messages = [
        'files.*.required' => 'Sila pilih fail untuk dimuat naik / Please select a file to upload',
        'files.*.file' => 'Item yang dipilih mestilah fail / Selected item must be a file',
        'files.*.mimes' => 'Jenis fail tidak disokong / File type not supported',
        'files.*.max' => 'Saiz fail tidak boleh melebihi 5MB / File size cannot exceed 5MB',
        'attachmentDescription.max' => 'Keterangan tidak boleh melebihi 500 aksara / Description cannot exceed 500 characters',
    ];

    public function mount(HelpdeskTicket $ticket): void
    {
        $this->ticket = $ticket;
        $this->loadAttachments();
    }

    public function loadAttachments(): void
    {
        $this->attachments = $this->ticket->file_attachments ?? [];
    }

    public function uploadFiles(): void
    {
        $this->validate();

        if (empty($this->files)) {
            session()->flash('error', 'Sila pilih sekurang-kurangnya satu fail / Please select at least one file');

            return;
        }

        try {
            $uploadedFiles = [];
            $currentAttachments = $this->ticket->file_attachments ?? [];

            foreach ($this->files as $file) {
                // Generate unique filename
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = time().'_'.uniqid().'.'.$extension;

                // Store file in helpdesk directory
                $path = $file->storeAs('helpdesk/attachments', $filename, 'public');

                if ($path) {
                    $uploadedFiles[] = [
                        'id' => uniqid(),
                        'filename' => $filename,
                        'original_name' => $originalName,
                        'path' => $path,
                        'url' => Storage::url($path),
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'uploaded_by' => Auth::id(),
                        'uploaded_by_name' => Auth::user()->name,
                        'uploaded_at' => now()->toISOString(),
                        'description' => $this->attachmentDescription ?: null,
                    ];
                }
            }

            // Merge with existing attachments
            $allAttachments = array_merge($currentAttachments, $uploadedFiles);

            // Add activity log entry using attribute access to avoid modifying a readonly/magic property
            $currentActivityLog = $this->ticket->getAttribute('activity_log') ?? [];
            $newLogEntry = [
                'action' => 'files_uploaded',
                'user_id' => (int) Auth::id(),
                'user_name' => Auth::user()->name,
                'timestamp' => now()->toISOString(),
                'details' => [
                    'files_count' => count($uploadedFiles),
                    'files' => array_map(fn ($file) => $file['original_name'], $uploadedFiles),
                    'description' => $this->attachmentDescription ?: null,
                ],
            ];

            $this->ticket->setAttribute('activity_log', array_merge($currentActivityLog, [$newLogEntry]));
            $this->ticket->save();

            session()->flash('success',
                count($uploadedFiles).' fail berjaya dimuat naik / '.
                count($uploadedFiles).' files successfully uploaded'
            );

            // Reset form
            $this->files = [];
            $this->attachmentDescription = '';
            $this->loadAttachments();

        } catch (\Exception $e) {
            logger('File upload error: '.$e->getMessage());
            session()->flash('error', 'Ralat memuat naik fail / Error uploading files');
        }
    }

    public function downloadFile(string $attachmentId)
    {
        try {
            $attachment = collect($this->attachments)->firstWhere('id', $attachmentId);

            if (! $attachment) {
                abort(404, 'Fail tidak dijumpai / File not found');
            }

            $filePath = storage_path('app/public/'.$attachment['path']);

            if (! file_exists($filePath)) {
                session()->flash('error', 'Fail tidak wujud / File does not exist');

                return redirect()->back();
            }

            return response()->download($filePath, $attachment['original_name']);

        } catch (\Exception $e) {
            logger('File download error: '.$e->getMessage());
            session()->flash('error', 'Ralat memuat turun fail / Error downloading file');

            return redirect()->back();
        }
    }

    public function deleteFile(string $attachmentId): void
    {
        try {
            $attachment = collect($this->attachments)->firstWhere('id', $attachmentId);

            if (! $attachment) {
                session()->flash('error', 'Fail tidak dijumpai / File not found');

                return;
            }

            // Check permissions
            $user = Auth::user();
            $canDelete = $user->id === ($attachment['uploaded_by'] ?? 0) ||
                        in_array($user->role, ['ict_admin', 'supervisor']) ||
                        $user->id === ($this->ticket->user_id ?? 0);

            if (! $canDelete) {
                session()->flash('error', 'Tiada kebenaran untuk memadam fail / No permission to delete file');

                return;
            }

            // Delete physical file
            $filePath = storage_path('app/public/'.$attachment['path']);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Remove from attachments array
            $updatedAttachments = collect($this->attachments)
                ->reject(fn ($item) => $item['id'] === $attachmentId)
                ->values()
                ->toArray();

            // Add activity log entry using attribute access to avoid modifying a readonly/magic property
            $currentActivityLog = $this->ticket->getAttribute('activity_log') ?? [];
            $newLogEntry = [
                'action' => 'file_deleted',
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'timestamp' => now()->toISOString(),
                'details' => [
                    'filename' => $attachment['original_name'],
                ],
            ];

            $this->ticket->setAttribute('activity_log', array_merge($currentActivityLog, [$newLogEntry]));
            $this->ticket->save();

            session()->flash('success', 'Fail berjaya dipadam / File successfully deleted');
            $this->loadAttachments();

        } catch (\Exception $e) {
            logger('File deletion error: '.$e->getMessage());
            session()->flash('error', 'Ralat memadam fail / Error deleting file');
        }
    }

    public function getFileIcon(string $mimeType): string
    {
        return match (true) {
            str_contains($mimeType, 'pdf') => 'document-text',
            str_contains($mimeType, 'image') => 'photograph',
            str_contains($mimeType, 'word') || str_contains($mimeType, 'document') => 'document-text',
            str_contains($mimeType, 'excel') || str_contains($mimeType, 'spreadsheet') => 'table',
            str_contains($mimeType, 'zip') || str_contains($mimeType, 'compressed') => 'archive',
            default => 'document'
        };
    }

    public function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, 2).' '.$units[$pow];
    }

    public function render()
    {
        // Check if user can upload files
        $user = Auth::user();
        $canUpload = $user->id === $this->ticket->user_id ||
                    $user->id === $this->ticket->getOriginal('assigned_to') ||
                    in_array($user->role, ['ict_admin', 'supervisor']);

        return view('livewire.helpdesk.attachment-manager', compact('canUpload'));
    }
}

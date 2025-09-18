<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference_number' => $this->reference_number,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'division' => $this->user->division,
            ],
            'purpose' => $this->purpose,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'remarks' => $this->remarks,
            'admin_remarks' => $this->admin_remarks,
            'status' => [
                'id' => $this->status->id,
                'name' => $this->status->name,
                'label' => $this->status->label,
                'color' => $this->getStatusColor(),
            ],
            'equipment_items' => $this->whenLoaded('loanItems', function () {
                return $this->loanItems->map(function ($loanItem) {
                    return [
                        'id' => $loanItem->equipment_item_id,
                        'name' => $loanItem->equipmentItem->name,
                        'category' => $loanItem->equipmentItem->category->name,
                        'serial_number' => $loanItem->equipmentItem->serial_number,
                        'quantity' => $loanItem->quantity,
                    ];
                });
            }),
            'approved_by' => $this->whenNotNull($this->approvedBy, [
                'id' => $this->approvedBy?->id,
                'name' => $this->approvedBy?->name,
            ]),
            'approved_at' => $this->approved_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get status color for UI display.
     */
    private function getStatusColor(): string
    {
        return match ($this->status->name) {
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            'returned' => 'blue',
            default => 'gray',
        };
    }
}

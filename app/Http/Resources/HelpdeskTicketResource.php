<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $ticket_number
 * @property string $title
 * @property string $description
 * @property \App\Models\User $user
 * @property \App\Models\TicketCategory $category
 * @property string $priority
 * @property \App\Models\TicketStatus $status
 * @property string $location
 * @property \App\Models\EquipmentItem|null $equipmentItem
 * @property \App\Models\User|null $assignedTo
 * @property string|null $admin_remarks
 * @property array|null $attachments
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @mixin \App\Models\HelpdeskTicket
 */
class HelpdeskTicketResource extends JsonResource
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
            'ticket_number' => $this->ticket_number,
            'title' => $this->title,
            'description' => $this->description,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'division' => $this->user->division,
            ],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'icon' => $this->category->icon,
            ],
            'priority' => [
                'level' => $this->priority,
                'label' => $this->getPriorityLabel(),
                'color' => $this->getPriorityColor(),
            ],
            'status' => [
                'id' => $this->status->id,
                'name' => $this->status->name,
                'label' => $this->status->label,
                'color' => $this->getStatusColor(),
            ],
            'location' => $this->location,
            'equipment_item' => $this->whenLoaded('equipmentItem', function () {
                return [
                    'id' => $this->equipmentItem->id,
                    'name' => $this->equipmentItem->name,
                    'category' => $this->equipmentItem->category->name,
                    'serial_number' => $this->equipmentItem->serial_number,
                ];
            }),
            'assigned_to' => $this->whenNotNull($this->assignedTo, [
                'id' => $this->assignedTo?->id,
                'name' => $this->assignedTo?->name,
            ]),
            'admin_remarks' => $this->admin_remarks,
            'attachments' => $this->attachments ? $this->formatAttachments() : [],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get priority label in Bahasa Malaysia.
     */
    private function getPriorityLabel(): string
    {
        return match ($this->priority) {
            'low' => 'Rendah',
            'medium' => 'Sederhana',
            'high' => 'Tinggi',
            'urgent' => 'Segera',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get priority color for UI display.
     */
    private function getPriorityColor(): string
    {
        return match ($this->priority) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'urgent' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get status color for UI display.
     */
    private function getStatusColor(): string
    {
        return match ($this->status->name) {
            'new' => 'blue',
            'in_progress' => 'yellow',
            'resolved' => 'green',
            'closed' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Format attachments with download URLs.
     */
    private function formatAttachments(): array
    {
        return array_map(function ($attachment) {
            return [
                'filename' => $attachment['filename'],
                'size' => $this->formatFileSize($attachment['size']),
                'mime_type' => $attachment['mime_type'],
                'download_url' => asset('storage/'.$attachment['path']),
            ];
        }, $this->attachments);
    }

    /**
     * Format file size for display.
     */
    private function formatFileSize(int $size): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;

        return number_format($size / pow(1024, $power), 2, '.', ',').' '.$units[$power];
    }
}

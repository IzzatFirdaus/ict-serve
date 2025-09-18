<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HelpdeskTicketResource extends JsonResource
    /**
     * @property int                            $id
     * @property string                         $ticket_number
     * @property string                         $title
     * @property string                         $description
     * @property \App\Models\User               $user
     * @property \App\Models\TicketCategory     $category
     * @property string                         $priority
     * @property \App\Models\TicketStatus       $status
     * @property string                         $location
     * @property \App\Models\EquipmentItem|null $equipmentItem
     * @property \App\Models\User|null          $assignedTo
     * @property string|null                    $admin_remarks
     * @property array|null                     $attachments
     * @property \Illuminate\Support\Carbon     $created_at
     * @property \Illuminate\Support\Carbon     $updated_at
     */
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'ticket_number' => $this->resource->ticket_number,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'user' => [
                'id' => $this->resource->user->id,
                'name' => $this->resource->user->name,
                'email' => $this->resource->user->email,
                'division' => $this->resource->user->division,
            ],
            'category' => [
                'id' => $this->resource->category->id,
                'name' => $this->resource->category->name,
                'icon' => $this->resource->category->icon,
            ],
            'priority' => [
                'level' => $this->resource->priority,
                'label' => $this->getPriorityLabel(),
                'color' => $this->getPriorityColor(),
            ],
            'status' => [
                'id' => $this->resource->status->id,
                'name' => $this->resource->status->name,
                'label' => $this->resource->status->label,
                'color' => $this->getStatusColor(),
            ],
            'location' => $this->resource->location,
            'equipment_item' => $this->whenLoaded('equipmentItem', function () {
                return [
                    'id' => $this->resource->equipmentItem->id,
                    'name' => $this->resource->equipmentItem->name,
                    'category' => $this->resource->equipmentItem->category->name,
                    'serial_number' => $this->resource->equipmentItem->serial_number,
                ];
            }),
            'assigned_to' => $this->whenNotNull($this->resource->assignedTo, [
                'id' => $this->resource->assignedTo?->id,
                'name' => $this->resource->assignedTo?->name,
            ]),
            'admin_remarks' => $this->resource->admin_remarks,
            'attachments' => $this->resource->attachments ? $this->formatAttachments() : [],
            'created_at' => $this->resource->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->resource->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get priority label in Bahasa Malaysia.
     */
    private function getPriorityLabel(): string
    {
        return match ($this->resource->priority) {
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
        return match ($this->resource->priority) {
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
        return match ($this->resource->status->name) {
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
        }, $this->resource->attachments);
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

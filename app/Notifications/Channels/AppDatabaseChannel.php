<?php

namespace App\Notifications\Channels;

use App\Models\Notification as AppNotification;
use App\Notifications\Contracts\AppDatabaseNotificationInterface;
use Illuminate\Notifications\Notification;

class AppDatabaseChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @return void
     */
    public function send($notifiable, AppDatabaseNotificationInterface $notification)
    {
        $data = $notification->toAppDatabase($notifiable);

        // Ensure required fields are present
        if (! isset($data['title']) || ! isset($data['message'])) {
            throw new \InvalidArgumentException('App notification must have title and message.');
        }

        AppNotification::create([
            'user_id' => $notifiable->id,
            'type' => $data['type'] ?? get_class($notification),
            'title' => $data['title'],
            'message' => $data['message'],
            'data' => $data['data'] ?? null,
            'category' => $data['category'] ?? 'general',
            'priority' => $data['priority'] ?? 'medium',
            'action_url' => $data['action_url'] ?? null,
            'icon' => $data['icon'] ?? null,
            'color' => $data['color'] ?? null,
            'expires_at' => $data['expires_at'] ?? null,
        ]);
    }
}

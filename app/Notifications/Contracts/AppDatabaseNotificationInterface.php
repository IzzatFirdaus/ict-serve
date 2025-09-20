<?php

namespace App\Notifications\Contracts;

interface AppDatabaseNotificationInterface
{
    /**
     * Get the app database representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toAppDatabase($notifiable): array;
}

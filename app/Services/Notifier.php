<?php

namespace App\Services;

use App\Models\Notification;

class Notifier
{
    /**
     * Send a custom notification to one or more users
     *
     * @param array|int $userIds
     * @param string $type
     * @param string $message
     * @param array $data
     * @return void
     */
    public static function send($userIds, string $type, string $message, array $data = [])
    {
        // Normalize to array
        $userIds = is_array($userIds) ? $userIds : [$userIds];

        $notifications = [];
        $timestamp = now();

        foreach ($userIds as $id) {
            $notifications[] = [
                'user_id' => $id,
                'type' => $type,
                'message' => $message,
                'data' => json_encode($data),
                'read_at' => null,
                'created_at' => $timestamp,
            ];
        }

        // Bulk insert
        Notification::insert($notifications);
    }
}
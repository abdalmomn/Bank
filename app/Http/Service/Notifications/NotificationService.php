<?php

namespace App\Http\Service\Notifications;

use App\Http\DTO\Auth\DeviceTokenDTO;
use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    protected PushNotificationService $push;

    public function __construct(PushNotificationService $push)
    {
        $this->push = $push;
    }

    public function send(
        User $user,
        $title,
        $message,
        $type = 'info',
        ?object $notifiable = null,
        array $extraData = []
    ) {
        $record = Notification::create([
            'type' => 'app', // أو App\\Notifications\\Something
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'data' => array_merge([
                'title' => $title,
                'message' => $message,
                'level' => $type,
                'entity_type' => $notifiable ? get_class($notifiable) : null,
                'entity_id' => $notifiable?->id,
            ], $extraData),
        ]);

        SendNotificationJob::dispatch(
            userId: $user->id,
            title: $title,
            message: $message,
            data: array_merge($extraData, [
                'notification_id' => $record->id,
            ])
        );

        return [
            'success' => true,
            'status' => 201,
            'message' => 'notification sent',
            'data' => $record,
        ];
    }

    public function registerDeviceToken(DeviceTokenDTO $deviceTokenDTO)
    {
        $deviceToken = auth()->user()->deviceTokens()->updateOrCreate(
            [
                'device_token' => $deviceTokenDTO->device_token,
            ],
            [
                'device_type' => $deviceTokenDTO->device_type,
                'platform' => $deviceTokenDTO->platform,
            ]
        );

        return [
            'data' => $deviceToken,
            'message' => 'Device token registered successfully',
            'code' => 201,
        ];
    }


    public function mark_as_read(Request $request, $notificationId)
    {
        $notification = Notification::query()
            ->where('notifiable_id',Auth::id())
            ->where('id', $notificationId)
            ->first();
        $notification->update([
            'read_at' => now()
        ]);
        return [
            'data' => null,
            'message' => 'marked as read',
            'code' => 200,
        ];
    }
}

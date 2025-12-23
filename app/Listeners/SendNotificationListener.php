<?php

namespace App\Listeners;

use App\Events\SendNotificationEvent;
use App\Http\Service\Notifications\NotificationService;

class SendNotificationListener
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(SendNotificationEvent $event): void
    {
        $this->notificationService->send(
            user: $event->user,
            title: $event->title,
            message: $event->message,
            type: $event->level,
            notifiable: $event->notifiable,
            extraData: $event->data
        );
    }
}

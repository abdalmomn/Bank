<?php

namespace App\Jobs;

use App\Models\User;
use App\Http\Service\Notifications\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotificationJob implements ShouldQueue
{
    use Queueable;

    public int $userId;
    public string $title;
    public string $message;
    public array $data;

    public function __construct(
        $userId,
        $title,
        $message,
        array $data = []
    ) {
        $this->userId = $userId;
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
    }

    public function handle(PushNotificationService $push): void
    {
        $user = User::find($this->userId);

        if (!$user) {
            return;
        }

        $push->sendToUserDevices(
            user: $user,
            title: $this->title,
            message: $this->message,
            data: $this->data
        );
    }
}

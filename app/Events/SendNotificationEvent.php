<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotificationEvent
{
    use Dispatchable, SerializesModels;

    public User $user;
    public string $title;
    public string $message;
    public string $level; // info | success | warning | error
    public ?object $notifiable;
    public array $data;

    public function __construct(
        User $user,
        $title,
        $message,
        $level = 'info',
        ?object $notifiable = null,
        array $data = []
    ) {
        $this->user = $user;
        $this->title = $title;
        $this->message = $message;
        $this->level = $level;
        $this->notifiable = $notifiable;
        $this->data = $data;
    }
}

<?php

namespace App\Http\Service\Notifications;

use App\Models\User;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class PushNotificationService
{

    protected $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function sendToUserDevices(User $user, $title, $body, array $data = [])
    {
        $tokens = $user->deviceTokens()->pluck('device_token')->toArray();
        if (empty($tokens)) {
            return;
        }

        foreach ($tokens as $token) {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification(Notification::create($title, $body))
                ->withData($data);

            $this->messaging->send($message);
        }
    }
}

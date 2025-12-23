<?php

namespace App\Http\Controllers\App\Notifications;

use App\Http\Controllers\Controller;
use App\Http\DTO\Auth\DeviceTokenDTO;
use App\Http\Requests\Auth\DeviceTokenRequest;
use App\Http\Resources\App\DeviceTokenResource;
use App\Http\Service\Notifications\NotificationService;
use Illuminate\Http\Request;

class AppNotificationController extends Controller
{

    public $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function registerDeviceToken(DeviceTokenRequest $request)
    {
        $validatedData = $request->validated();
        $deviceTokenDto = DeviceTokenDTO::fromArray($validatedData);
        $data = $this->notificationService->registerDeviceToken($deviceTokenDto);

        return response()->json(
            new DeviceTokenResource($data['data']),
            $result['code'] ?? 200
        );
    }

    public function mark_as_read(Request $request, $id)
    {
        $data = $this->notificationService->mark_as_read($request,$id);
        return response()->json([
            'data' => $data['data'],
            'message' => $data['message'],
            'code' => $data['code']
        ]);
    }
}

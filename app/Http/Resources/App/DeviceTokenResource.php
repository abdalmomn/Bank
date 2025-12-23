<?php

namespace App\Http\Resources\App;

use App\Http\Resources\User\UserLightResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceTokenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->whenLoaded('user', new UserLightResource($this->whenLoaded('user'))),
            'device_token' => $this->device_token,
            'device_type' => $this->device_type,
            'platform' => $this->platform,
        ];
    }
}

<?php

namespace App\Http\DTO\Auth;

class DeviceTokenDTO
{

    public function __construct(
     public string $device_token,
     public string $device_type,
     public string $platform,
    )
    {}

    public static function fromArray($data): self
    {
        return new self(
            device_token: $data['device_token'],
            device_type: $data['device_type'] ?? '',
            platform: $data['platform'] ?? '',
        );
    }
}

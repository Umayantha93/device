<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'deviceId' => $this->device_id,
            'deviceType' => $this->device_type,
            'deviceApiKey' => $this->device_api_key,
            'timestamp' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}

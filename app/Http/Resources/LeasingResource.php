<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeasingResource extends JsonResource
{
    public $computed;

    public function __construct($resource, $computedData = null)
    {
        parent::__construct($resource);
        $this->computed = $computedData;
    }

    public function toArray(Request $request): array
    {
        return [
            'deviceId' => $this->device_id,
            'deviceType' => $this->device_type,
            $this->mergeWhen($this->device_type === "leasing", [
                'deviceOwner' => $this->deviceOwner?->billing_name,
                'deviceOwnerDetails' => $this->deviceOwner 
                ? new OwnerResource($this->deviceOwner) 
                : null,
            ]),
            $this->mergeWhen($this->computed !== null, [
                'leasingPeriodsComputed' => $this->computed,
            ]),
            'leasingPeriods' => LeasingPeriodsResource::collection($this->leasingPeriods),
            'timestamp' => now()->toDateTimeString(),
        ];
    }
}

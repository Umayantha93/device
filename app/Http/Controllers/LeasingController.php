<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeasingResource;
use App\Models\Device;
use Illuminate\Http\Request;

class LeasingController extends Controller
{
    public function getInfo($id)
    {
        $device = Device::with(['deviceOwner', 'leasingPeriods'])->find($id);

        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        $currentLeasingPeriod = $device->leasingPeriods()->latest('start_date')->first();

        $leasingPeriodsComputed = $currentLeasingPeriod ? [
            'leasingConstructionId' => $currentLeasingPeriod->id,
            'leasingConstructionMaximumTraining' => $currentLeasingPeriod->leasing_construction_maximum_training,
            'leasingConstructionMaximumDate' => $currentLeasingPeriod->leasing_construction_maximum_date,
            'leasingActualPeriodStartDate' => $currentLeasingPeriod->start_date,
            'leasingNextCheck' => $currentLeasingPeriod->next_check,
        ] : null;

        return new LeasingResource($device, $leasingPeriodsComputed);
    }
}

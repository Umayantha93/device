<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeasingResource;
use App\Models\Device;
use App\Models\LeasingPlan;
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

    public function updateLeasing(Request $request, $id)
    {
        $validated = $request->validate([
            'deviceId' => 'required|exists:devices,device_id',
            'deviceTrainings' => 'required|integer|min:0',
        ]);
        
        $Device = Device::with(['leasingPeriods'])->find($id);

        if (!$Device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        $leasingPeriod = $Device->leasingPeriods()->latest('start_date')->first();

        if (!$leasingPeriod) {
            return response()->json(['error' => 'Leasing period not found'], 404);
        }

        $updatedLeasigPeriod = $leasingPeriod->leasing_construction_maximum_training += $validated['deviceTrainings'];
        $leasingPlan = LeasingPlan::find($leasingPeriod->leasing_plan_id);  

        if($leasingPlan->maximum_training < $updatedLeasigPeriod){
            return response()->json(['error' => 'The number of trainings exceeds the maximum allowed'], 400);
        }
        $leasingPeriod->update([
            'leasing_construction_maximum_training' => $updatedLeasigPeriod,
        ]);
        
        return response()->json(['success' => true, 'message' => 'Leasing period updated']);
    }
}

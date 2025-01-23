<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $devices = [];
        for ($i = 1; $i <= 10; $i++) {
            $deviceType = match ($i) {
                1, 2 => 'free',
                3 => 'leasing',
                default => 'unset',
            };

            $devices[] = [
                'device_id' => sprintf('NW-H-20-%04d', $i + 16),
                'device_type' => $deviceType,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Device::insert($devices);
    }
}

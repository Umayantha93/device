<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $devices = [];

        // Add the first two devices with activation_code_id 1 and 2
        $devices[] = [
            'device_id' => 'NW-H-20-0017',
            'device_type' => 'leasing',
            'activation_code_id' => 1,
            'device_owner_id' => 1,
            'device_api_key' => Str::random(32),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $devices[] = [
            'device_id' => 'NW-H-20-0018',
            'device_type' => 'leasing',
            'activation_code_id' => 2,
            'device_owner_id' => 2,
            'device_api_key' => Str::random(32),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // $devices[] = [
        //     'device_id' => 'NW-H-20-0019',
        //     'device_type' => 'free',
        //     'activation_code_id' => 3,
        //     'device_owner_id' => 3,
        //     'device_api_key' => Str::random(32),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ];

        // Add the rest of the devices with activation_code_id set to null
        for ($i = 3; $i <= 10; $i++) {
            $deviceType = match ($i) {
                3, 4 => 'free',
                9 => 'restricted',
                default => 'unset',
            };

            $devices[] = [
                'device_id' => sprintf('NW-H-20-%04d', $i + 16),
                'device_type' => $deviceType,
                'activation_code_id' => null,
                'device_owner_id' => $i,
                'device_api_key' => $deviceType === 'free' ? Str::random(32) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert all devices into the database
        Device::insert($devices);
    }
}

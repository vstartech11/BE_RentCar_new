<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeVehicle;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // //add type vehicle
        // TypeVehicle::create([
        //     'name' => 'Innova',
        //     'brand' => 'Toyota',
        //     'description' => 'Toyota Innova is a 7 seater car',
        //     'locationImg'=>'innova no bg.png'


        // ]);

        // TypeVehicle::create([
        //     'name' => 'Terios',
        //     'brand' => 'Daithatsu',
        //     'description' => 'Daihatsu Terios is a 5 seater car',
        //     'locationImg'=>'Terios.png'
        // ]);

        //add vehicle
        Vehicle::create([
            'type_id' => 1,
            'name' => 'Innova Reborn',
            'price' => 500000,
            'license_plate' => 'B 1214 AD',
            'status' => 'available'
        ]);

        Vehicle::create([
            'type_id' => 2,
            'name' => 'Terios 2021',
            'price' => 300000,
            'license_plate' => 'B 1234 D',
            'status' => 'available'
        ]);

    }
}
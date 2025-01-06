<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
class VehicleController extends Controller
{
    //search vehicle by status available
    public function searchVehicle(Request $request)
    {
        $vehicles = Vehicle::where('status', 'available')->get();
        return redirect()->route('search');
    }

    //add vehicle if user role is admin
    public function addVehicle(Request $request)
    {
        $vehicle = new Vehicle();
        $vehicle->type_id = $request->type_id;
        $vehicle->name = $request->name;
        $vehicle->price = $request->price;
        $vehicle->status = $request->status;
        $vehicle->save();
        return redirect()->route('add');
    }

}
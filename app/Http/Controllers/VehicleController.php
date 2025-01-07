<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\TypeVehicle;
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
        try {
            $vehicle = new Vehicle();
            $vehicle->type_id = $request->type_vehicle_id;
            $vehicle->name = $request->name;
            $vehicle->license_plate = $request->license;
            $vehicle->price = $request->price;
            $vehicle->save();
            return redirect()->back()->with('status', 'success add vehicle');
        } catch (\Exception $e) {
            //make back with key 'error' and value 'failed to add vehicle'
            return redirect()->back()->with('error', 'failed to add vehicle');
        }
    }

    //edit vehicle if user role is admin
    public function editVehicle(Request $request, $id)
    {
        try {
            $vehicle = Vehicle::find($id);
            $vehicle->type_id = $request->type_id;
            $vehicle->name = $request->name;
            $vehicle->license_plate = $request->license;
            $vehicle->price = $request->price;
            $vehicle->save();
            return redirect()->back()->with('status', 'success edit vehicle');
        } catch (\Exception $e) {
            //make back with key 'error' and value 'failed to edit vehicle'
            return redirect()->back()->with('error', 'failed to edit vehicle');
        }
    }

    //delete vehicle if user role is admin
    public function deleteVehicle($id)
    {
        try {
            $vehicle = Vehicle::find($id);
            $vehicle->delete();
            return redirect()->back()->with('status', 'success delete vehicle');
        } catch (\Exception $e) {
            //make back with key 'error' and value 'failed to delete vehicle'
            return redirect()->back()->with('error', 'failed to delete vehicle');
        }
    }

    //add type vehicle if user role is admin
    public function addTypeVehicle(Request $request)
    {
        try {
            $typeVehicle = new TypeVehicle();
            $typeVehicle->name = $request->name;
            $typeVehicle->description = $request->description;
            $typeVehicle->brand = $request->brand;
            //copy file $request->locationImg to storage
            $request->file('locationImg')->store('img/cars');
            $typeVehicle->locationImg = $request->file('locationImg')->hashName();






            $typeVehicle->save();
            return redirect()->back()->with('status', 'success add type vehicle');
        } catch (\Exception $e) {
            //make back with key 'error' and value 'failed to add type vehicle'
            return redirect()->back()->with('error', 'failed to add type vehicle');
        }
    }

    //delete type vehicle if user role is admin
    public function deleteTypeVehicle($id)
    {
        try {
            $typeVehicle = TypeVehicle::find($id);
            $typeVehicle->delete();
            return redirect()->back()->with('status', 'success delete type vehicle');
        } catch (\Exception $e) {
            //make back with key 'error' and value 'failed to delete type vehicle'
            return redirect()->back()->with('error', 'failed to delete type vehicle');
        }
    }
}
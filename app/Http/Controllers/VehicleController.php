<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\TypeVehicle;
use Illuminate\Support\Facades\Validator;
class VehicleController extends Controller

{
    //search vehicle by status available
    public function searchVehicle(Request $request)
    {
        //simpan request ke variabel rental_duration, start_date, end_date
        $rental_duration = $request->rental_duration;
        $start_date = $request->start_date;
        $start_time = $request->start_time;
        $typeVehicles = TypeVehicle::all();
        $vehicles = Vehicle::where('status', 'available')->get();
        return view('search', compact('vehicles', 'typeVehicles','rental_duration', 'start_date', 'start_time'));
    }

    //add vehicle if user role is admin
    public function addVehicle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|exists:type_vehicles,id',
            'name' => 'required|string|max:255',
            'license' => 'required|string|max:255|unique:vehicles,license_plate',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }

        try {
            $vehicle = new Vehicle();
            $vehicle->type_id = $request->type_id;
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
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|exists:type_vehicles,id',
            'name' => 'required|string|max:255',
            'license' => 'required|string|max:255|unique:vehicles,license_plate,' . $id,
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }

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

    //edit type vehicle if user role is admin
    public function editTypeVehicle(Request $request, $id)
    {
        try {
            $typeVehicle = TypeVehicle::find($id);
            $typeVehicle->name = $request->name;
            $typeVehicle->description = $request->description;
            $typeVehicle->brand = $request->brand;
            //copy file $request->locationImg to storage
            $request->file('locationImg')->store('img/cars');
            $typeVehicle->locationImg = $request->file('locationImg')->hashName();
            $typeVehicle->save();
            return redirect()->back()->with('status', 'success edit type vehicle');
        } catch (\Exception $e) {
            //make back with key 'error' and value 'failed to edit type vehicle'
            return redirect()->back()->with('error', 'failed to edit type vehicle');
        }
    }
}

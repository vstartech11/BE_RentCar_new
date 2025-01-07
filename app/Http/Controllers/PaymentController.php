<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;


class PaymentController extends Controller
{


    //make payment
    public function makePayment(Request $request)
    {
        //validate request paymentMethod, amount,pickup_date,pickup_time, vehicle_id, rental_duration
        $validator = \Validator::make($request->all(), [
            'paymentMethod' => 'required',
            'amount' => 'required',
            'pickup_date' => 'required',
            'pickup_time' => 'required',
            'vehicle_id' => 'required',
            'rental_duration' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('status', $validator->errors());
        }



        //return_date= pickup_date+rental_duration(days)
        $return_date = date('Y-m-d', strtotime($request->pickup_date . ' + ' . $request->rental_duration . ' days'));
        //insert into reservations table
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'pickup_date' => $request->pickup_date,
            'return_date' => $return_date,
            'vehicle_id' => $request->vehicle_id,
        ]);

        //search users table for only id where role=admin
        $adminId = User::where('role', 'admin')->first();
        //insert into payment table
        $payment = Payment::create([
            'reservation_id' => $reservation->id,
            'amount' => $request->amount,
            'payment_method' => $request->paymentMethod,
            'payment_date' => $request->pickup_date,
            'admin_id' => $adminId->id,
        ]);

    }

    //edit payment 'payment_status'=>'required','reservation_status'=>'required'
    public function editPayment(Request $request)
    {
        //validate request payment_status, reservation_status
        $validator = Validator::make($request->all(), [
            'reservation_id' => 'required',
            'payment_id' => 'required',
            'payment_status' => 'required',
            'reservation_status' => 'required',
            'vehicle_id' => 'required',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->with('status', $validator->errors());
        }

        //update payment table
        $payment = Payment::where('id', $request->payment_id)->update([
            'status' => $request->payment_status,
        ]);

        //update reservations table
        $reservation = Reservation::where('id', $request->reservation_id)->update([
            'status' => $request->reservation_status,
        ]);

        //update vehicle table
        $vehicle = Vehicle::where('id', $request->vehicle_id)->update([
            'status' => 'rented',
        ]);
    }



}
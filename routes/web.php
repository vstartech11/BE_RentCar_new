<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Models\TypeVehicle;
use App\Models\Vehicle;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('login', [AuthController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
//register
Route::get('register', [AuthController::class, 'showRegisterForm'])->middleware('guest')->name('register');
//register
Route::post('register', [AuthController::class, 'register']);
//search
Route::post('search', [VehicleController::class, 'searchVehicle'])->middleware('auth')->name('search');

//edit vehicle is show admin.vehicle
Route::get('admin/vehicle', function () {
    $vehicles = Vehicle::all();
    $typeVehicles = TypeVehicle::all();
    return view('admin.vehicle', compact('vehicles', 'typeVehicles'));
})->middleware('auth')->name('admin.vehicle');
//edit type vehicle is show admin.type_vehicle
Route::get('admin/type_vehicle', function () {
    $typeVehicles = TypeVehicle::all();
    return view('admin.type_vehicle', compact('typeVehicles'));
})->middleware('auth')->name('admin.type_vehicle');
//edit account is show admin.account
Route::get('admin/account', function () {
    $accounts = User::all();
    return view('admin.account', compact('accounts'));
})->middleware('auth')->name('admin.account');


//when / is accessed, it will redirect to /login
Route::get('/', function () {
    return redirect()->route('login');
});
//add vehicle
Route::post('admin/add_vehicle', [VehicleController::class, 'addVehicle'])->middleware('auth')->name('add_vehicle');
//edit vehicle put
Route::put('admin/edit_vehicle/{id}', [VehicleController::class, 'editVehicle'])->middleware('auth')->name('edit_vehicle');
//delete vehicle delete
Route::delete('admin/delete_vehicle/{id}', [VehicleController::class, 'deleteVehicle'])->middleware('auth')->name('delete_vehicle');
//add type vehicle
Route::post('admin/add_type_vehicle', [VehicleController::class, 'addTypeVehicle'])->middleware('auth')->name('add_type_vehicle');
//edit type vehicle put
Route::put('admin/edit_type_vehicle/{id}', [VehicleController::class, 'editTypeVehicle'])->middleware('auth')->name('edit_type_vehicle');
//delete type vehicle delete
Route::delete('admin/delete_type_vehicle/{id}', [VehicleController::class, 'deleteTypeVehicle'])->middleware('auth')->name('delete_type_vehicle');
//add account
Route::post('admin/add_account', [AuthController::class, 'addAccount'])->middleware('auth')->name('add_account');
//edit account put
Route::put('admin/edit_account/{id}', [AuthController::class, 'editAccount'])->middleware('auth')->name('edit_account');
//delete account delete
Route::delete('admin/delete_account/{id}', [AuthController::class, 'deleteAccount'])->middleware('auth')->name('delete_account');


//admin dashboard
Route::get('admin/dashboard', function () {
    $typeVehicle = TypeVehicle::all();

    return view('admin.dashboard', compact('typeVehicle'));
})->middleware('auth')->name('admin.dashboard');

Route::get('dashboard', function () {
    $transactions = DB::table('reservations')
        ->join('vehicles', 'reservations.vehicle_id', '=', 'vehicles.id')
        ->leftJoin('payments', 'reservations.id', '=', 'payments.reservation_id')
        ->select(
            'reservations.created_at as date',
            'vehicles.name as vehicleName',
            'reservations.reservation_date as reservationDate',
            'payments.payment_date as paymentDate',
            'reservations.status as status'
        )
        ->get();
    return view('dashboard', compact('transactions'));
})->middleware('auth')->name('dashboard');



//payment customer post
Route::post('payment', [VehicleController::class, 'payment'])->middleware('auth')->name('payment');

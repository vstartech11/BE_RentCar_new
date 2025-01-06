<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Models\TypeVehicle;
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
//get search
Route::get('search', function () {
    return view('search');
})->middleware('auth')->name('search');

Route::get('/', function () {
    return view('welcome');
});
//add vehicle
Route::post('admin/add_vehicle', [VehicleController::class, 'addVehicle'])->middleware('auth')->name('add_vehicle');
//admin dashboard
Route::get('admin/dashboard', function () {
    $typeVehicle = TypeVehicle::all();

    return view('admin.dashboard', compact('typeVehicle'));
})->middleware('auth')->name('admin.dashboard');

Route::get('dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
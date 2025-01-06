<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{

     // Menampilkan form login
     public function showLoginForm()
     {
         return view('auth.login');
     }

     // Menampilkan form registrasi
        public function showRegisterForm()
        {
            return view('auth.register');
        }


    // Fungsi untuk login
    public function login(Request $request)
    {
        // Validasi input login
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            //jika {"password":["The password field must be at least 6 characters."]} maka return ke key password_error
            if ($validator->errors()->has('password')) {
                return redirect()->back()->with('password_error', $validator->errors()->first('password'));
            }
            return redirect()->back()->with('error', $validator->errors());
        }

        // Cek apakah email dan password valid
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Cek apakah pengguna adalah admin
            if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');  // Mengarahkan ke dashboard admin
            }
            return redirect()->route('dashboard');  // Mengarahkan ke dashboard pengguna biasa
        }

        return redirect()->back()->with('password_error', 'Email atau password salah!');  // Kembali ke halaman login
    }

    // Fungsi untuk logout
    public function logout(Request $request)
    {

        Auth::logout();
        return redirect()->route('login')->with('status', 'Logout berhasil!');
    }

    // Fungsi untuk registrasi pengguna baru (optional)
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('password')) {
                return redirect()->back()->with('error', $validator->errors()->first('password'));
            }
            return redirect()->back()->with('error',$validator->errors());
        }

        if ($request->password !== $request->password_confirmation) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Berikan alert sukses
        session()->flash('error', 'Registrasi berhasil! Silakan login.');

        return redirect()->route('login');
    }
}
<?php

namespace App\Http\Controllers;


use Carbon\Traits\ToStringFormat;
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
            }else{
                //cek apakah customer_validate true
                if (Auth::user()->role === 'customer' && Auth::user()->customer_validate === 1) {
                    return redirect()->route('dashboard');  // Mengarahkan ke dashboard customer
                }else{
                    Auth::logout();
                    return redirect()->back()->with('error', 'Akun anda belum diverifikasi oleh admin!');  // Kembali ke halaman login
                }
            }
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

    // add account khusus admin (name, email, password, role, customer_validate boolean)
    public function addAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
            'customer_validate' => 'required|boolean',
        ]);



        if ($validator->fails()) {
            if ($validator->errors()->has('password')) {
                return redirect()->back()->with('error', $validator->errors()->first('password'));
            }
            return redirect()->back()->with('error', $validator->errors());
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'customer_validate' => $request->customer_validate,
            ]);

            // Berikan alert sukses
            redirect()->back()->with('status', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan akun: ' . $e->getMessage());
        }

        return redirect()->route('admin.account');
    }
    // edit account khusus admin (name, email, password, role, customer_validate boolean) cek jika tidak input password maka password tidak diupdate
    public function editAccount(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string',
            'customer_validate' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('password')) {
                return redirect()->back()->with('error', $validator->errors()->first('password'));
            }
            return redirect()->back()->with('error', $validator->errors());
        }

        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->customer_validate = $request->customer_validate;

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Berikan alert sukses
            redirect()->back()->with('status', 'Akun berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah akun: ' . $e->getMessage());
        }

        return redirect()->route('admin.account');
    }

    // delete account khusus admin
    public function deleteAccount($id)
    {
        try {
            User::destroy($id);

            // Berikan alert sukses
            redirect()->back()->with('status', 'Akun berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus akun: ' . $e->getMessage());
        }

        return redirect()->route('admin.account');
    }

}

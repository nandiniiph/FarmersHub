<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Akun;
use App\Models\Produk;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showDashboardAdmin()
    {
        return view('DashboardAdmin');
    }

    public function showDashboardKonsumen()
    {
        return view('belanja.index');
    }

    public function showDashboardPetani()
    {
        return redirect()->route('belanja.index');
    }



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['error' => 'Email atau password salah.'])->withInput();
        }

        $credentials = $validator->validated();

        $user = Akun::where('email', $credentials['email'])
                    ->where('password', $credentials['password'])
                    ->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();

            switch ($user->role) {
                case 'Admin':
                    return redirect()->intended('DashboardAdmin');
                case 'Petani':
                case 'Konsumen':
                    return redirect()->route('belanja.index');
                default:
                    Auth::logout();
                    return redirect('/login')->withErrors(['role' => 'Role tidak dikenali.']);
            }
        }

        return back()->withErrors(['error' => 'Email atau password salah.'])->withInput();
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:30|unique:user,username',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['error' => 'Registrasi gagal'])->withInput();
        }

        Akun::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'konsumen',
            'status' => true,
        ]);

        return redirect()->route('showLogin')->with('success', 'Registrasi berhasil, silakan login!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('LandingPage');
    }

}

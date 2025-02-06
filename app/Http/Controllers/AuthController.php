<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Auth\Events\Registered;


class AuthController extends Controller
{
    function showRegistration()
    {
        return view('registration');
    }

    function submitRegistration(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:8|max:30'
        ]);

        // Hash password
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Buat pengguna baru
        $user = User::create($validatedData);

        // Trigger event Registered untuk mengirim email verifikasi
        event(new Registered($user));

        // Log in pengguna yang baru terdaftar
        FacadesAuth::login($user);

        // Redirect ke halaman verifikasi email
        return redirect('/email/verify');
    }

    function showLogin()
    {
        return view('login');
    }

    function submitLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (FacadesAuth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('product.index');
        } else {
            return redirect()->back()->with('failed', 'Wrong Email or Password');
        }
    }


    public function logout(Request $request)
    {
        FacadesAuth::logout();  // Logout user

        // Invalidate session dan regenerate token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');  // Redirect ke halaman login
    }
}

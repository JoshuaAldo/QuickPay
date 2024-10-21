<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AuthController extends Controller
{
    function showRegistration()
    {
        return view('registration');
    }

    function submitRegistration(Request $request)
    {
        $successRegist = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:8|max:30'
        ]);
        $successRegist['password'] = bcrypt($successRegist['password']);
        User::create($successRegist);

        return redirect()->route('login');
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

    function logout()
    {
        FacadesAuth::logout();
        return redirect()->route('login');
    }
}

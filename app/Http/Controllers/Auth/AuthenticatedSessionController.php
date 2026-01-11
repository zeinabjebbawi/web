<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthenticatedSessionController extends Controller
{
       
    public function showLoginForm()
    {
    return view('auth.login');
    }


    public function login(Request $request)
    {
        
        $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
        ]);

    if (Auth::attempt($credentials)) {
        
        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
        }
        if ($user->isOwner()) {
        return redirect()->route('owner.dashboard');
        }
        if ($user->isCustomer()) {
        return redirect()->route('customer.dashboard');
            }

    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
        ])->withInput();
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}




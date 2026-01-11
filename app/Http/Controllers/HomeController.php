<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role === 'owner') {
                return redirect()->route('owner.dashboard');
            }

            if ($user->role === 'customer') {
                return redirect()->route('customer.dashboard');
            }
        }
        return view('home.index');
    }
}

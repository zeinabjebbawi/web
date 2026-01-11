<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Owner;
use App\Models\Customer;
use App\Models\Admin;

class RegisteredUserController extends Controller
{
     public function showRegisterForm()
    {
        return view('auth.register');
    }

     public function register(Request $request)
    {
        // 1. Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:owner,customer,admin',

            // Optional fields
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255', // For admin
        ]);
         
            
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);


         // 3. Create role-specific profile
        if ($validated['role'] === 'owner') {
            Owner::create([
                'id' => $user->id,
                'phone' => $validated['phone'] ?? '',
            ]);
        }
        elseif ($validated['role'] === 'customer') {
            Customer::create([
                'id' => $user->id,
                'address' => $validated['address'] ?? '',
                'phone' => $validated['phone'] ?? null,
            ]);
        }
        elseif ($validated['role'] === 'admin') {
            Admin::create([
                'id' => $user->id,
                'department' => $validated['department'] ?? null,
                'phone' => $validated['phone'] ?? null,
            ]);
        }

        // 4. Auto-login after registration
        Auth::login($user);

        // 5. Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isOwner()) {
            return redirect()->route('owner.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    }
}
   
























    
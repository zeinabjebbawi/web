<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Owner;
use App\Models\Customer;
use App\Models\Place;

class AdminController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function dashboard()
    {
        $owners = Owner::with('user')->get();
        $customers = Customer::with('user')->get();
        $places = Place::with('owner.user')->get();

        return view('admin.dashboard', [
            'owners' => $owners,
            'customers' => $customers,
            'places' => $places,
        ]);
    }

    /**
     * List all owners.
     */
    public function indexOwners()
    {
        $owners = Owner::with('user')->get();
        return view('admin.owners.index', ['owners' => $owners]);
    }

    /**
     * List all customers.
     */
    public function indexCustomers()
    {
        $customers = Customer::with('user')->get();
        return view('admin.customers.index', ['customers' => $customers]);
    }

    /**
     * Show form to create a new owner.
     */
    public function createOwner()
    {
        return view('admin.owners.create');
    }

    /**
     * Create a new owner.
     */
    public function storeOwner(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'owner',
        ]);

        Owner::create([
            'id' => $user->id,
            'phone' => $validated['phone'] ?? '',
        ]);

        return redirect()
            ->route('admin.owners.index')
            ->with('success', 'Owner created successfully.');
    }

    /**
     * Delete an owner.
     */
    public function deleteOwner($id)
    {
        $owner = Owner::with('user')->findOrFail($id);

        $owner->delete();
        $owner->user->delete();

        return redirect()
            ->route('admin.owners.index')
            ->with('success', 'Owner deleted successfully.');
    }

    /**
     * Show form to create a new customer.
     */
    public function createCustomer()
    {
        return view('admin.customers.create');
    }

    /**
     * Create a new customer.
     */
    public function storeCustomer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);

        Customer::create([
            'id' => $user->id,
            'address' => $validated['address'] ?? '',
            'phone' => $validated['phone'] ?? null,
        ]);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Delete a customer.
     */
    public function deleteCustomer($id)
    {
        $customer = Customer::with('user')->findOrFail($id);
        $customer->delete();
        $customer->user->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
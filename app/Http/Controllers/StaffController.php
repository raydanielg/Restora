<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $restaurant = auth()->user()->restaurant;
        $staff = User::where('restaurant_id', $restaurant->id)
            ->where('role', '!=', 'owner')
            ->latest()
            ->get();

        return view('dashboard.staff', compact('staff', 'restaurant'));
    }

    public function store(Request $request)
    {
        $restaurant = auth()->user()->restaurant;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'role' => 'required|in:manager,reception,waiter,chef',
        ]);

        // Generate a unique 6-digit staff login code (retry on the rare collision).
        do {
            $code = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        } while (User::where('staff_code', $code)->exists());

        // Build a guaranteed-unique internal login email from the staff name.
        $baseSlug = \Illuminate\Support\Str::slug($validated['name'], '.') ?: 'staff';
        $email = $baseSlug . '.' . $restaurant->id . '@staff.restora.app';
        $suffix = 1;
        while (User::where('email', $email)->exists()) {
            $email = $baseSlug . '.' . $restaurant->id . '.' . $suffix++ . '@staff.restora.app';
        }

        User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'restaurant_id' => $restaurant->id,
            'staff_code' => $code,
            'email' => $email,
            'password' => bcrypt($code),
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff member added. Login code: ' . $code);
    }

    public function destroy(User $user)
    {
        if ($user->restaurant_id !== auth()->user()->restaurant->id || $user->role === 'owner') {
            abort(403);
        }

        $user->delete();

        return redirect()->route('staff.index')->with('success', 'Staff member removed.');
    }
}

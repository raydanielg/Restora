<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.staff-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'staff_code' => 'required|string|size:6',
        ]);

        $user = User::where('staff_code', $request->staff_code)
            ->whereIn('role', ['manager', 'reception', 'waiter', 'chef'])
            ->first();

        if (!$user) {
            return back()->with('error', 'Invalid staff code. Please try again.')->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route(match ($user->role) {
            'chef' => 'kitchen.index',
            'waiter' => 'waiter.index',
            'reception' => 'reception.index',
            default => 'home',
        });
    }
}

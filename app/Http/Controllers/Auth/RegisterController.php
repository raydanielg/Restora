<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'restaurant_name' => ['required', 'string', 'max:255'],
            'restaurant_type' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => 'owner',
        ]);

        Restaurant::create([
            'user_id' => $user->id,
            'name' => $data['restaurant_name'],
            'type' => $data['restaurant_type'] ?? 'restaurant',
            'description' => $data['description'] ?? null,
            'address' => $data['address'] ?? null,
            'status' => 'approved',
        ]);

        $user->update(['restaurant_id' => Restaurant::where('user_id', $user->id)->first()->id]);

        return $user;
    }
}

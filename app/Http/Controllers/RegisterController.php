<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'contact_no' => ['required'],
            'barangay' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8']
        ]);

        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'contact_no' => $validatedData['contact_no'],
            'barangay' => $validatedData['barangay'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);


        return $user;
    }
}
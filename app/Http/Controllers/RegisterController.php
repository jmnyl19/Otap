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
            'age' => ['required'],
            'contact_no' => ['required'],
            'lot_no' => ['max:255'],
            'street' => ['required'],
            'barangay' => ['required'],
            'landmark' => ['max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8']
        ]);

        if ($request->hasFile('profile_picture')) {
            $pfpimage = $request->file('profile_picture');
            $pfpimageName = time().'.'.$pfpimage->getClientOriginalExtension();
            $pfpimage->move(public_path('pfp'), $pfpimageName);
        } else {
            $pfpimageName = null;
        }

        if ($request->hasFile('valid_id')) {
            $validIdimage = $request->file('valid_id');
            $validIdimageName = time().'.'.$validIdimage->getClientOriginalExtension();
            $validIdimage->move(public_path('validid'), $validIdimageName);
        } else {
            $validIdimageName = null;
        }

        if ($request->hasFile('cor')) {
            $corimage = $request->file('cor');
            $corimageName = time().'.'.$corimage->getClientOriginalExtension();
            $corimage->move(public_path('cor'), $corimageName);
        } else {
            $corimageName = null;
        }

        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'age' => $validatedData['age'],
            'contact_no' => $validatedData['contact_no'],
            'lot_no' => $validatedData['lot_no'],
            'street' => $validatedData['street'],
            'barangay' => $validatedData['barangay'],
            'landmark' => $validatedData['landmark'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'profile_picture' => $request->profile_picture = $pfpimageName,
            'valid_id' => $request->valid_id = $validIdimageName,
            'cor' => $request->cor = $corimageName,
        ]);


        return response()->json([
            'message' => 'Successfull',
        ], 200);
    }
}
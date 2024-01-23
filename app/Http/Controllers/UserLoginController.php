<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserLoginController extends Controller
{
    public function userlogin(Request $request)
    {
        $credentials = $request->validate([
            'contact_no' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status === 'Active' ) {
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'user' => $user,
                    'token' => $token,
                ]);
            } else if ($user-> status === 'Inactive') {
                return response()->json([
                    'message' => 'Your Account Is Currently Inactive',
                ], 400);
            }
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function userAccount(Request $request, $id)
    {
        $user = User::find($id);

        return response()->json([
            'userDetail' => $user,
            'message' => 'Successful',
        ], 200);
    }

    public function userEdit(Request $request, $id)
    {
        

        
        $user = User::find($id);

        if ($request->filled('current_password') && !Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect.',
            ], 422);
        } 

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->contact_no = $request->contact_no;
        $user->age = $request->age;
        $user->email = $request->email;
        
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
        return response()->json([
            'userDetail' => $user,
            'message' => 'Successful',
        ], 200);
    }
}
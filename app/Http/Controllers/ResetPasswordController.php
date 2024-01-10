<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{

    public function OtpAlert($number, $message) {
        $ch = curl_init();
        $url = 'https://api.semaphore.co/api/v4/messages';
        $api_key = 'f2dee59156e7c0028c381fd182a61848';
    
        $parameters = array(
            'apikey' => $api_key,
            'number' => $number,
            'message' => $message,
            'sendername' => 'SEMAPHORE'
        );
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    

        $output = curl_exec($ch);
    

        if (curl_errno($ch)) {

            error_log('Semaphore API Error: ' . curl_error($ch));
        }

        curl_close($ch);
    
    }

    public function sendOtp(Request $request)
    {
        $user = User::where('contact_no', $request->contact_no)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        $otp = rand(100000, 999999);
        $user->update(['otp' => $otp]);

        $this->OtpAlert($user->contact_no, "Your [OTAP] one-time password is {$otp}. Please do not share this code.");
    
        return response()->json(['message' => 'OTP sent successfully'], 200);
    }

    public function verifyOtp(Request $request)
    {
        $contactNo = $request->contact_no;
        $inputtedOtp = intval($request->otp);

        $user = User::where('contact_no', $contactNo)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if ($user->otp === $inputtedOtp) {

            $user->update(['otp' => null]);

            return response()->json(['message' => 'OTP verification successful'], 200);
        } else {
            return response()->json(['error' => 'Incorrect OTP'], 400);
        }
    }

    public function changePasswordOtp(Request $request)
{
    $contactNo = $request->contact_no;
    $newPassword = $request->password;

    $user = User::where('contact_no', $contactNo)->first();

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // You might want to add additional validation for the new password

    // Update the user's password
    $user->update(['password' => Hash::make($newPassword)]);

    return response()->json(['message' => 'Password changed successfully'], 200);
}
}

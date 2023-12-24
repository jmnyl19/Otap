<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResidentManagementController extends Controller
{
    public function index()
    {
        $residents = User::where('role', 'Resident')->get();

        return response()->json([
            'residents' => $residents,
            'message' => 'Success',
        ]);
    }
    public function getresidents()
    {
        $residents = User::where('role', 'Resident')->get();

        return view('residents');
    }

    public function getDetails($id){
        $residents = User::where('id', $id)->get();
        
        return response()->json([
            'history7' => $residents,
            'message' => 'Success',
        ], 200);
        }
}

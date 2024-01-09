<?php

namespace App\Http\Controllers;

use App\Models\TextAlert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TextAlertController extends Controller
{
    public function getresponders(){
        $responders = TextAlert::all();

        return view('responderscontact');
    }

    public function manageresponders(){
        $responders = TextAlert::all();

        return response()->json([
            'responders' => $responders,
            'message' => 'Success',
        ]);
    }

    public function getEditResponders($id){
        $responder = TextAlert::find($id);

        return response()->json([
            'responder' => $responder,
            'message' => 'Success',
        ]);
    }
    public function updateResponders(Request $request, $id){
        $responder = TextAlert::find($id);
        $responder->fullname = $request->fullname;
        $responder->responder = $request->responder;
        $responder->number = $request->number;
        $responder->save();
    
        return response()->json([
            'message' => 'Responder updated successfully',
        ]);
    }
    public function deleteResponders(Request $request, $id){
        
            $responder = TextAlert::find($id);
            $responder->delete();

            return response()->json([
                'message' => 'Responder deleted successfully.',
            ]);
       
    }
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'responder' => 'required|string',
            'number' => 'required|string|unique:text_alerts,number',
        ]);
        
        $textAlert = new TextAlert;
        $textAlert->fullname = $request->fullname;
        $textAlert->responder = $request->responder;
        $textAlert->number = $request->number;
        $textAlert->save();

        return response()->json([
            'message' => 'Responders contact number added successfully',
        ]);
        
    }

}

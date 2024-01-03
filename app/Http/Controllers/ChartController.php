<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;


class ChartController extends Controller
{
    
    public function getChartData(Request $request) {
        
        $data = DB::table('incidents')
            ->join('users', 'incidents.residents_id', '=', 'users.id')
            ->where('users.barangay', auth()->user()->barangay) 
            ->whereIn('incidents.status', ['Pending', 'Responding', 'Completed', 'Que'])
            ->select(DB::raw('YEAR(incidents.created_at) as year'), DB::raw('MONTH(incidents.created_at) as month'), 'incidents.status', DB::raw('count(*) as count'))
            ->groupBy('year', 'month', 'status')
            ->get();


            return response()->json($data);
    }

    public function getPieData(Request $request){
        
        $data = DB::table('incidents')
        ->join('users', 'incidents.residents_id', '=', 'users.id')
        ->where('users.barangay', auth()->user()->barangay) 
        ->whereIn('incidents.type', [
            'Requesting for Ambulance',
            'Requesting for a Barangay Public Safety Officer',
            'Requesting for a Fire Truck',
        ])
        ->select(DB::raw('YEAR(incidents.created_at) as year'), DB::raw('MONTH(incidents.created_at) as month'), 
        'incidents.type', DB::raw('count(*) as count'))
        ->groupBy('year','month', 'type')
        ->get();

        return response()->json($data);
    
    }
}
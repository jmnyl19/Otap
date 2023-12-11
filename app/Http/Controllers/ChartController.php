<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incident;
use DB;


class ChartController extends Controller
{
    public function getChartData(Request $request){
        $chartData = DB::table('incidents')
        ->select(DB::raw('COUNT(*) as count'),DB::raw('MONTH(incidents.created_at) as month'),'status')
        ->join('users', 'incidents.residents_id', '=', 'users.id')
        ->where('users.barangay', auth()->user()->barangay)
        ->whereIn('incidents.status', ['Pending', 'Completed', 'Responding'])
        ->groupBy('incidents.status', DB::raw('YEAR(incidents.created_at)'), DB::raw('MONTH(incidents.created_at)'))
        ->get();

        $otherTable = DB::table('forwarded_incidents')
        ->select(DB::raw('COUNT(*) as count'),DB::raw('MONTH(forwarded_incidents.created_at) as month'),'forwarded_incidents.status')
        ->join('incidents', 'forwarded_incidents.incident_id', '=', 'incidents.id')
        ->where('forwarded_incidents.barangay', auth()->user()->barangay)
        ->whereIn('forwarded_incidents.status', ['Pending', 'Completed', 'Responding'])
        ->groupBy('forwarded_incidents.status', DB::raw('YEAR(forwarded_incidents.created_at)'), DB::raw('MONTH(forwarded_incidents.created_at)'))
        ->get();

        $combChartData = $chartData->concat($otherTable);


            $labels = [];
            $datasets = [];
            $statusColors = [
                'Pending' =>  '#d25b46',
                'Completed' => ' #84ec6a',
                'Responding' => '#d3cc3a',
            ];

            foreach ($statusColors as $status => $color) {
                $data = $combChartData
                    ->where('status', $status)
                    ->pluck('count')
                    ->toArray();
             
                $datasets[] = [
                    'label' => ucfirst($status) . ' Incidents',
                    'backgroundColor' => $color,
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data,
                ];

                if (empty($labels)) {
                    $labels = $combChartData
                ->where('status', $status)
                ->pluck('month')
                ->toArray();

                }
            }
            return response()->json([
                'labels' => $labels,
                'datasets' => $datasets,
            ]);
    }

    public function getPieData(Request $request){
        $chartData = DB::table('incidents')
        ->select(DB::raw('COUNT(*) as count'), DB::raw('YEAR(incidents.created_at) as year'),'type')
        ->join('users', 'incidents.residents_id', '=', 'users.id')
        ->where('users.barangay', auth()->user()->barangay)
        ->whereIn('incidents.type', ['Requesting for Ambulance', 'Requesting for a Barangay Public Safety Officer', 'Requesting for a Fire Truck'])
        ->groupBy('incidents.type', DB::raw('YEAR(incidents.created_at)'))
        ->get();
        

            $chartDataByType = $chartData->groupBy('type');

            $labels = [];
            $datasets = [];
            $typeColors = [
                'Requesting for Ambulance' =>  'rgb(255, 99, 132)',
                'Requesting for a Fire Truck' => 'rgb(255, 205, 86)',
                'Requesting for a Barangay Public Safety Officer' => 'rgb(54, 162, 235)',
            ];

            foreach ($chartDataByType as $type => $typeData) {
                
                $data = $typeData->pluck('count');
                $backgroundColor = $typeColors[$type];

                $datasets[] = [
                    'label' => ucfirst($type) .' Incidents',
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data,
                ];
                
                if (empty($labels)) {
                    $labels = $typeData->pluck('year');
                }
            }
            return response()->json([
                'labels' => $labels,
                'datasets' => $datasets,
            ]);
    }
}

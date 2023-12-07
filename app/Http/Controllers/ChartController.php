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
        ->select(DB::raw('COUNT(*) as count'),DB::raw('MONTH(created_at) as month'),'status')
        ->whereIn('status', ['Pending', 'Completed', 'Responding'])
        ->groupBy('status', DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
        ->get();

            $chartDataByStatus = $chartData->groupBy('status');

            $labels = [];
            $datasets = [];
            $statusColors = [
                'Pending' =>  '#d25b46',
                'Completed' => ' #84ec6a',
                'Responding' => '#d3cc3a',
            ];

            foreach ($chartDataByStatus as $status => $statusData) {
                $data = $statusData->pluck('count');
                $backgroundColor = $statusColors[$status];

                $datasets[] = [
                    'label' => ucfirst($status) . ' Incidents',
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data,
                ];

                if (empty($labels)) {
                    $labels = $statusData->pluck('month');
                }
            }
            return response()->json([
                'labels' => $labels,
                'datasets' => $datasets,
            ]);
    }

    public function getPieData(Request $request){
        $chartData = DB::table('incidents')
        ->select(DB::raw('COUNT(*) as count'), DB::raw('YEAR(created_at) as year'),'type')
        ->whereIn('type', ['Requesting for Ambulance', 'Requesting for a Barangay Public Safety Officer', 'Requesting for a Fire Truck'])
        ->groupBy('type', DB::raw('YEAR(created_at)'))
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

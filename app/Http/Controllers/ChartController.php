<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\ForwardedIncident;
use Carbon\Carbon;
use DB;


class ChartController extends Controller
{
    

    public function getChartData(Request $request) {
        
        $chartData = DB::table('incidents')
        ->select(DB::raw('COUNT(*) as count'),DB::raw('MONTH(incidents.created_at) as month'),'incidents.status')
        ->join('users', 'incidents.residents_id', '=', 'users.id')
        ->where('users.barangay', auth()->user()->barangay)
        ->whereIn('incidents.status', ['Pending', 'Responding','Completed', 'Unavailable'])
        ->groupBy('incidents.status', DB::raw('YEAR(incidents.created_at)'), DB::raw('MONTH(incidents.created_at)'))
        ->get();

            $labels = [];
            $datasets = [];
            $statusColors = [
                'Pending' =>  '#d25b46',
                'Responding' => '#d3cc3a',
                'Completed' => ' #84ec6a',
                'Unavailable' => 'rgb(224, 128, 17)',
            ];

            foreach ($statusColors as $status => $color) {
                $data = $chartData
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
                    $labels = $chartData
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
        
        $incidents = Incident::with('user')->get();
        
        $ambulanceCount = $incidents->where('type', 'Requesting for Ambulance')
            ->where('user.barangay', auth()->user()->barangay)
            ->count() ;
        $bpsoCount = $incidents->where('type', 'Requesting for a Barangay Public Safety Officer')
            ->where('user.barangay', auth()->user()->barangay)
            ->count() ;
        $firetruckCount = $incidents->where('type', 'Requesting for a Fire Truck')
            ->where('user.barangay', auth()->user()->barangay)
            ->count() ;
        
        $data = [
            'labels' => ['Requesting for Ambulance', 'Requesting for a Barangay Public Safety Officer', 'Requesting for a Fire Truck'],
            'datasets' => [
                [
                    'label' => 'Incidents',
                    'backgroundColor' => ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
                    'data' => [ $ambulanceCount, $bpsoCount, $firetruckCount],
                ],
            ],
        ];

        return response()->json($data); 
    }
}

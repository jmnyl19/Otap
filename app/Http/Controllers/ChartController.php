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
    public function getChartData(Request $request){
        
        $incidents = Incident::with('user')
        ->join('users', 'incidents.residents_id', '=', 'users.id')
        ->where('users.barangay', auth()->user()->barangay)
        ->get();
        $recincidents = ForwardedIncident::with('incident')
            ->where('barangay', auth()->user()->barangay)
            ->get();

        $combinedData = $incidents->concat($recincidents);

        $groupedData = $combinedData->groupBy([
            'status',
            function ($item) {
                return Carbon::parse($item->created_at)->format('Y');
            }
        ]);

        $labels = [];

        $datasets = [];

        $statusColors = [
            'Pending' => '#d25b46',
            'Responding' => '#d3cc3a',
            'Completed' => '#84ec6a',
            'Forwarded' => '#5f69e8',
        ];

        foreach ($statusColors as $status => $color) {
            $data = $groupedData->has($status) ?
            $groupedData->get($status)->map(function ($value) {
                return $value->count();
            })->all() :
            array_fill_keys($labels->all(), 0);
                

            $datasets[] = [
                'label' => ucfirst($status) . ' Incidents',
                'backgroundColor' => $color,
                'borderColor' => 'rgb(255, 99, 132)',
                'data' => $data,
            ];
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => $datasets,
        ]);

    }

    public function getPieData(Request $request){
        
        $incidents = Incident::with('user')->get();
        $recincidents = ForwardedIncident::with('incident')->get();
        
        $ambulanceCount = $incidents->where('type', 'Requesting for Ambulance')
            ->where('user.barangay', auth()->user()->barangay)
            ->count() + $recincidents->where('type', 'Requesting for Ambulance')
            ->where('barangay', auth()->user()->barangay)->count();
        $bpsoCount = $incidents->where('type', 'Requesting for a Barangay Public Safety Officer')
            ->where('user.barangay', auth()->user()->barangay)
            ->count() + $recincidents->where('type', 'Requesting for a Barangay Public Safety Officer')
            ->where('barangay', auth()->user()->barangay)->count();
        $firetruckCount = $incidents->where('type', 'Requesting for a Fire Truck')
            ->where('user.barangay', auth()->user()->barangay)
            ->count() + $recincidents->where('type', 'Requesting for a Fire Truck')
            ->where('barangay', auth()->user()->barangay)->count();
        
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

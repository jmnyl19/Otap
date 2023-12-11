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
        
        // $incidents = Incident::with('user')->get();
        // $recincidents = ForwardedIncident::with('incident')->get();
        // $labels = ['Pending', 'Responding', 'Completed', 'Forwarded', 'Received'];

        // $pendingCount = $incidents->where('status', 'Pending')
        //     ->where('user.barangay', auth()->user()->barangay)
        //     ->count() + $recincidents->where('status', 'Pending')
        //     ->where('barangay', auth()->user()->barangay)->count();
        // $respondingCount = $incidents->where('status', 'Responding')
        //     ->where('user.barangay', auth()->user()->barangay)
        //     ->count() + $recincidents->where('status', 'Responding')
        //     ->where('barangay', auth()->user()->barangay)->count();
        // $completedCount = $incidents->where('status', 'Completed')
        //     ->where('user.barangay', auth()->user()->barangay)
        //     ->count() + $recincidents->where('status', 'Completed')
        //     ->where('barangay', auth()->user()->barangay)->count();
        // $forwardedCount = $incidents->where('status', 'Forwarded')
        //     ->where('user.barangay', auth()->user()->barangay)
        //     ->count() + $recincidents->where('status', 'Forwarded')
        //     ->where('barangay', auth()->user()->barangay)->count();
        // $recievedCount = $recincidents->where('barangay', auth()->user()->barangay)->count();
        
        // $data = [
        //     'labels' => $labels,
        //     'datasets' => [
        //         [
        //             'label' => 'Incident Status',
        //             'backgroundColor' => ['#d25b46', '#d3cc3a', '#84ec6a', '#5f69e8', 'rgb(224, 128, 17)'],
        //             'data' => [$pendingCount, $respondingCount, $completedCount, $forwardedCount, $recievedCount],
        //         ],
        //     ],
        // ];

        // return response()->json($data); 
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
            return Carbon::parse($item->created_at)->format('Y-m');
        }
    ]);

    $labels = $groupedData->first()->keys()->map(function ($label) {
        return Carbon::parse($label)->format('M Y');
    });

    $datasets = [];

    $statusColors = [
        'Pending' => '#d25b46',
        'Responding' => '#d3cc3a',
        'Completed' => '#84ec6a',
        'Forwarded' => '#5f69e8',
    ];

    foreach ($statusColors as $status => $color) {
        $data = $groupedData->has($status) ?
            $groupedData->get($status)->values()->map(function ($value) {
                return $value->count();
            })->toArray() :
            array_fill(0, count($labels), 0);

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

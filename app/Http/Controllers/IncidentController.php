<?php

namespace App\Http\Controllers;
use App\Models\ForwardedIncident;
use App\Models\Incident;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\IncidentCreated;
use Carbon\Carbon;
class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incidents = Incident::with('user')->where('residents_id', auth()->user()->id)->get();

        return view('landingpage', compact('incidents'));
    }

    public function adminLanding(){
        // $barangayIncident = Incident::where('barangay', auth()->user()->barangay)->get(); 
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $recincidents = ForwardedIncident::with('incident')->orderByDesc('created_at')->get();
        $pendingCount = $incidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay)->count();
        $forpendingCount = $recincidents->where('status', 'Pending')->where('barangay', auth()->user()->barangay)->count();
        $totalPending = $pendingCount + $forpendingCount;

        $respondingCount = $incidents->where('status', 'Responding')->where('user.barangay', auth()->user()->barangay)->count();
        $forrespondingCount = $recincidents->where('status', 'Responding')->where('barangay', auth()->user()->barangay)->count();
        $totalResponding = $respondingCount + $forrespondingCount;

        $completedCount = $incidents->where('status', 'Completed')->where('user.barangay', auth()->user()->barangay)->count();
        $forcompletedCount = $recincidents->where('status', 'Completed')->where('barangay', auth()->user()->barangay)->count();
        $totalCompleted = $completedCount + $forcompletedCount;

        $forwardedCount = $incidents->where('status', 'Forwarded')->where('user.barangay', auth()->user()->barangay)->count();
        $pendingIncidents = $incidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay)->take(5);
        $forwardedIncidents =  $recincidents->where('status', 'Pending')->where('barangay', auth()->user()->barangay)->take(5);
        return view('landingpage', compact('totalPending','totalResponding','totalCompleted', 'forwardedCount' , 'pendingIncidents', 'forwardedIncidents'));
    }

    public function getLatestIncidents()
{
    $incidents = Incident::with('user')->orderByDesc('created_at')->get();
    $pendingIncidents = $incidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay)->take(5);
    return response()->json(['incidents' => $pendingIncidents, 'message' => 'Success',]);
}
    
public function getCurrentIncident($id)
{
    $incidents = Incident::with('user')->where('id', $id)->get();

    return response()->json([
        'history' => $incidents,
        'message' => 'Success',
    ], 200);
}

    public function user_emegency_history( $id)
    {

        $incidents = Incident::where('residents_id', $id)->orderByDesc('created_at')->get();

        return response()->json([
            'history' => $incidents,
            'message' => 'Success',
        ], 200);
    }

    public function manageforwarded()
    {
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $forwardedIncidents =  $incidents->where('status', 'Forwarded')->where('user.barangay', auth()->user()->barangay);

        // dd($forwardedIncidents);
        return view('forwarded', compact('forwardedIncidents'));
        // return response()->json([
        //     'incidents' => $forwardedIncidents,
        //     'message' => 'Success',
        // ], 200);
    }

    public function managereceived()
    {
        $incidents = ForwardedIncident::with('incident')->orderByDesc('created_at')->get();
        $forwardedIncidents =  $incidents->where('barangay', auth()->user()->barangay);

        // dd($forwardedIncidents);
        return view('received', compact('forwardedIncidents'));
        // return response()->json([
        //     'incidents' => $forwardedIncidents,
        //     'message' => 'Success',
        // ], 200);
    }


    public function managepending()
    {
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $recincidents = ForwardedIncident::with('incident')->orderByDesc('created_at')->get();
        $pendingIncidents = $incidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay);
        $forwardedIncidents =  $recincidents->where('status', 'Pending')->where('barangay', auth()->user()->barangay)->take(5);


        return view('pendingpage', compact('pendingIncidents','forwardedIncidents'));
        
    }

    public function managecompleted()
    {
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $recincidents = ForwardedIncident::with('incident')->orderByDesc('created_at')->get();
        $completedIncidents = $incidents->where('status', 'Completed')->where('user.barangay', auth()->user()->barangay);
        $forwardedIncidents =  $recincidents->where('status', 'Completed')->where('barangay', auth()->user()->barangay)->take(5);

        return view('completedpage', compact('completedIncidents','forwardedIncidents'));
    }
    public function manageresponding()
    {
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $recincidents = ForwardedIncident::with('incident')->orderByDesc('created_at')->get();
        $respondingIncidents = $incidents->where('status', 'Responding')->where('user.barangay', auth()->user()->barangay);
        $forwardedIncidents =  $recincidents->where('status', 'Responding')->where('barangay', auth()->user()->barangay)->take(5);

        return view('responding', compact('respondingIncidents','forwardedIncidents'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $incident = new Incident;
        $incident->residents_id = $request->residents_id;
        $incident->type = $request->type;
        $incident->status = $request->status;
        $incident->latitude = $request->latitude;
        $incident->longitude = $request->longitude;

        $incident->save();
        
        event(new IncidentCreated($incident));

        return response()->json([
            'message' => 'Successfull',
        ], 200);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



}

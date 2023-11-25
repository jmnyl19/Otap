<?php

namespace App\Http\Controllers;
use App\Models\ForwardedIncident;
use App\Models\Incident;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        
        $incidents = Incident::with('user')->get();
        $pendingCount = $incidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay)->count();
        $respondingCount = $incidents->where('status', 'Responding')->where('user.barangay', auth()->user()->barangay)->count();
        $completedCount = $incidents->where('status', 'Completed')->where('user.barangay', auth()->user()->barangay)->count();
        $forwardedCount = $incidents->where('status', 'Forwarded')->where('user.barangay', auth()->user()->barangay)->count();
        $pendingIncidents = $incidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay);
        return view('landingpage', compact('pendingCount','respondingCount','completedCount', 'forwardedCount' , 'pendingIncidents'));
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
        $incidents = ForwardedIncident::with('incident')->orderByDesc('created_at')->get();
        $forwardedIncidents =  $incidents->where('barangay', auth()->user()->barangay);

        // dd($forwardedIncidents);
        return view('forwarded', compact('forwardedIncidents'));
        // return response()->json([
        //     'incidents' => $forwardedIncidents,
        //     'message' => 'Success',
        // ], 200);
    }

    public function managepending()
    {
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $pendingIncidents = $incidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay);

        return view('pendingpage', compact('pendingIncidents'));
    }

    public function managecompleted()
    {
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $completedIncidents = $incidents->where('status', 'Completed')->where('user.barangay', auth()->user()->barangay);

        return view('completedpage', compact('completedIncidents'));
    }
    public function manageresponding()
    {
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $respondingIncidents = $incidents->where('status', 'Responding')->where('user.barangay', auth()->user()->barangay);

        return view('responding', compact('respondingIncidents'));
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

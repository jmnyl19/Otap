<?php

namespace App\Http\Controllers;
use App\Models\ForwardedIncident;
use App\Models\ForwardedReport;
use App\Models\Incident;
use App\Models\Report;
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

    public function getLatestIncidents(){
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $pendingIncidents = $incidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay)->take(5);

        $allincidents = Incident::with('user')->orderByDesc('created_at')->get();
        $allpendingIncidents = $allincidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay);
        
        $resincidents = Incident::with('user')->orderByDesc('created_at')->get();
        $allrespondingIncidents = $resincidents->where('status', 'Responding')->where('user.barangay', auth()->user()->barangay);

        $recincidents = ForwardedIncident::with('incident')->orderByDesc('created_at')->get();
        $forwardedIncidents =  $recincidents->where('status', 'Pending')->where('barangay', auth()->user()->barangay)->take(5);
        
        $allrecincidents = ForwardedIncident::with('incident')->orderByDesc('created_at')->get();
        $allforwardedIncidents =  $allrecincidents->where('status', 'Pending')->where('barangay', auth()->user()->barangay);
        
        $resrecincidents = ForwardedIncident::with('incident')->orderByDesc('created_at')->get();
        $respondingforwardedIncidents =  $resrecincidents->where('status', 'Responding')->where('barangay', auth()->user()->barangay);
        
        $forincidents = Incident::with('user')->orderByDesc('created_at')->get();
        $forwardIncidents =  $forincidents->where('status', 'Forwarded')->where('user.barangay', auth()->user()->barangay);

        $comincidents = Incident::with('user')->orderByDesc('created_at')->get();
        $completedIncidents =  $comincidents->where('status', 'Completed')->where('user.barangay', auth()->user()->barangay);

        $forcomincidents = ForwardedIncident::with('incident')->orderByDesc('created_at')->get();
        $completedforwardedIncidents =  $forcomincidents->where('status', 'Completed')->where('barangay', auth()->user()->barangay);
        
        $receIncidents = ForwardedIncident::with('incident')->orderByDesc('created_at')->get();
        $receivedincidents =  $receIncidents->where('barangay', auth()->user()->barangay);

        $reports = Report::with('user')->orderByDesc('datehappened')->get();
        $reportedIncident = $reports->where('user.barangay', auth()->user()->barangay)->where('status', 'Pending');
        
        $forreports = ForwardedReport::with('report')->orderByDesc('created_at')->get();
        $forwardedReports =  $forreports->where('status','Pending')->where('barangay', auth()->user()->barangay);

        $resreports = Report::with('user')->orderByDesc('created_at')->get();
        $respondReports = $resreports->where('status', 'Responding')->where('user.barangay', auth()->user()->barangay);
        
        $resforreports = ForwardedReport::with('report')->orderByDesc('created_at')->get();
        $resforwardedReports =  $resforreports->where('status','Responding')->where('barangay', auth()->user()->barangay);
        
        $foreport = Report::with('user')->orderByDesc('created_at')->get();
        $transferedReports =  $foreport->where('status', 'Forwarded')->where('user.barangay', auth()->user()->barangay);
        
        $reforwarded = ForwardedReport::with('report')->orderByDesc('created_at')->get();
        $transferedReports =  $reforwarded->where('status','Forwarded')->where('barangay', auth()->user()->barangay);
        $completedReports = $foreport->where('status', 'Completed')->where('user.barangay', auth()->user()->barangay);
        $completedForReports =  $reforwarded->where('status','Completed')->where('barangay', auth()->user()->barangay);

        return response()->json([
            'foreport' => $transferedReports,
            'reforwarded' => $transferedReports,
            'compreport' => $completedReports,
            'compforreport' => $completedForReports,

            'incidents' => $pendingIncidents,
            'allincidents' => $allpendingIncidents,
            'resincidents' => $allrespondingIncidents,
            'recincidents' => $forwardedIncidents,
            'allrecincidents' => $allforwardedIncidents,
            'resrecincidents' => $respondingforwardedIncidents,
            'forincidents' => $forwardIncidents,
            'comincidents' => $completedIncidents,
            'forcomincidents' => $completedforwardedIncidents,
            'receIncidents' => $receivedincidents,
            'reports' => $reportedIncident,
            'forreports' => $forwardedReports,
            'resreports' => $respondReports,
            'resforreports' => $resforwardedReports,

            'message' => 'Success',
        ]);
    
    }
    

    
public function getCurrentIncident($id)
{
    $incidents = Incident::with('user')->where('id', $id)->get();
    $resincidents = Incident::with('user')->where('id', $id)->get();
    $forincidents = Incident::with('user')->where('id', $id)->get();
    $comincidents = Incident::with('user')->where('id', $id)->get();
    $recincident = ForwardedIncident::with('incident.user')->where('id', $id)->get();
    $resrecincident = ForwardedIncident::with('incident.user')->where('id', $id)->get();
    $forcomincident = ForwardedIncident::with('incident.user')->where('id', $id)->get();
    $receincident = ForwardedIncident::with('incident.user')->where('id', $id)->get();
    $reports = Report::with('user')->where('id', $id)->get();
    $forreports = ForwardedReport::with('report.user')->where('id', $id)->get();
    $resreports = Report::with('user')->where('id', $id)->get();
    $resforreports = ForwardedReport::with('report.user')->where('id', $id)->get();
    $foreport = Report::with('user')->where('id', $id)->get();
    $reforwarded = ForwardedReport::with('report.user')->where('id', $id)->get();

    return response()->json([
        'history' => $incidents,
        'history1' => $recincident,
        'history2' => $resincidents,
        'history3' => $resrecincident,
        'history4' => $forincidents,
        'history5' => $comincidents,
        'history6' => $forcomincident,
        'history7' => $receincident,
        'history8' => $reports,
        'history9' => $forreports,
        'history10' => $resreports,
        'history11' => $resforreports,
        'history12' => $foreport,
        'history13' => $reforwarded,

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
        $forwardedIncidents =  $recincidents->where('status', 'Pending')->where('barangay', auth()->user()->barangay);


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

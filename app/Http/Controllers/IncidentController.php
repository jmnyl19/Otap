<?php

namespace App\Http\Controllers;
use App\Models\ForwardedIncident;
use App\Models\ForwardedReport;
use App\Models\Incident;
use App\Models\Report;
use App\Models\TextAlert;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\IncidentCreated;
use Carbon\Carbon;
use DB;
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
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $pendingCount = $incidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay)->count();
        $respondingCount = $incidents->where('status', 'Responding')->where('user.barangay', auth()->user()->barangay)->count();
        $completedCount = $incidents->where('status', 'Completed')->where('user.barangay', auth()->user()->barangay)->count();
        $unavailableCount = $incidents->where('status', 'Que')->where('user.barangay', auth()->user()->barangay)->count();
 
        return view('landingpage', compact('pendingCount','respondingCount','completedCount', 'unavailableCount'));
    }

    public function getLatestIncidents(){
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $pendingIncidents = $incidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay)->take(5);

        return response()->json([
            'incidents' => $pendingIncidents,
            'message' => 'Success',
        ]);
    }
    public function getLatestQue(){
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $onqueIncidents = $incidents->where('status', 'Que')->where('user.barangay', auth()->user()->barangay);

        return response()->json([
            'que' => $onqueIncidents,
            'message' => 'Success',
        ]);
    }
    public function getLatestReport(){
        $reports = Report::with('user')->orderByDesc('created_at')->get();
        $reportedIncident = $reports->where('user.barangay', auth()->user()->barangay)->where('status', 'Pending')->take(5);
        return response()->json([
            'reports' => $reportedIncident,
            'message' => 'Success',
        ]);
    }
    public function getLatestQueReport(){
        $reports = Report::with('user')->orderByDesc('created_at')->get();
        $onquereportedIncident = $reports->where('user.barangay', auth()->user()->barangay)->where('status', 'Que');
        return response()->json([
            'quereport' => $onquereportedIncident,
            'message' => 'Success',
        ]);
    }
    public function getLatestForwardedIncidents(){
        $recincidents = ForwardedIncident::with(['incident', 'incident.user'])->orderByDesc('created_at')->get();
        $forwardedIncidents =  $recincidents->where('status', 'Pending')->where('barangay', auth()->user()->barangay)->take(5);
        return response()->json([
            'recincidents' => $forwardedIncidents,
            'message' => 'Success',
        ]);
    }
    public function getpendingIncidents(){
        $allpendingIncidents = Incident::with('user')
        ->where('status', 'Pending')
        ->whereHas('user', function ($query) {
            $query->where('barangay', auth()->user()->barangay);
        })
        ->orderByDesc('created_at')
        ->paginate(10);
        // return response()->json([
        //     'allincidents' => $allpendingIncidents,
        //     'message' => 'Success',
        // ]);
        return response()->json([
            'allincidents' => $allpendingIncidents->items(),
            'pagination' => [
                'current_page' => $allpendingIncidents->currentPage(),
                'last_page' => $allpendingIncidents->lastPage(),
                'per_page' => $allpendingIncidents->perPage(),
                'total' => $allpendingIncidents->total(),
            ],
            'message' => 'Success',
        ]);
    }
    public function getpendingForwarded(){
        $allrecincidents = ForwardedIncident::with(['incident', 'incident.user'])->orderByDesc('created_at')->get();
        $allforwardedIncidents =  $allrecincidents->where('status', 'Pending')->where('barangay', auth()->user()->barangay);
        return response()->json([
            'allrecincidents' => $allforwardedIncidents,
            'message' => 'Success',
        ]);
    }
    public function getResponding(){
        $allrespondingIncidents = Incident::with('user')
        ->where('status', 'Responding')
        ->whereHas('user', function ($query) {
            $query->where('barangay', auth()->user()->barangay);
        })
        ->orderByDesc('created_at')
        ->paginate(10);
        return response()->json([
            'resincidents' => $allrespondingIncidents->items(),
            'pagination' => [
                'current_page' => $allrespondingIncidents->currentPage(),
                'last_page' => $allrespondingIncidents->lastPage(),
                'per_page' => $allrespondingIncidents->perPage(),
                'total' => $allrespondingIncidents->total(),
            ],
            'message' => 'Success',
        ]);
    }
    public function getRespondingForwarded(){
        $resrecincidents = ForwardedIncident::with(['incident', 'incident.user'])->orderByDesc('created_at')->get();
        $respondingforwardedIncidents =  $resrecincidents->where('status', 'Responding')->where('barangay', auth()->user()->barangay);
        return response()->json([
            'resrecincidents' => $respondingforwardedIncidents,
            'message' => 'Success',
        ]);
    }
    public function getUnavailable(){
        $resunavailable =  Incident::with('user')
        ->where('status', 'Que')
        ->whereHas('user', function ($query) {
            $query->where('barangay', auth()->user()->barangay);
        })
        ->orderByDesc('created_at')
        ->paginate(10);
        return response()->json([
            'unavailable' => $resunavailable->items(),
            'pagination' => [
                'current_page' => $resunavailable->currentPage(),
                'last_page' => $resunavailable->lastPage(),
                'per_page' => $resunavailable->perPage(),
                'total' => $resunavailable->total(),
            ],
            'message' => 'Success',
        ]);
    }
    public function getUnavailableReport(){
        $unavailablereport = Report::with('user')
        ->where('status', 'Que')
        ->whereHas('user', function ($query) {
            $query->where('barangay', auth()->user()->barangay);
        })
        ->orderByDesc('datehappened')
        ->paginate(10);
        return response()->json([
            'unavailablereport' => $unavailablereport->items(),
            'pagination' => [
                'current_page' => $unavailablereport->currentPage(),
                'last_page' => $unavailablereport->lastPage(),
                'per_page' => $unavailablereport->perPage(),
                'total' => $unavailablereport->total(),
            ],
            'message' => 'Success',
        ]);
    }
    public function getreForwarded(){
        $forincidents = ForwardedIncident::with(['incident', 'incident.user'])->orderByDesc('created_at')->get();
        $forwardIncidents =  $forincidents->where('status', 'Forwarded')->where('barangay', auth()->user()->barangay);
        return response()->json([
            'forincidents' => $forwardIncidents,
            'message' => 'Success',
        ]);
    }
    public function reForwarded($id){
        $forcomincident = ForwardedIncident::with('incident.user')->where('id', $id)->get();
        
        return response()->json([
            'history6' => $forcomincident,
            'message' => 'Success',
        ], 200);
    }
    public function getCompleted(){
        $completedIncidents =  Incident::with('user')
        ->where('status', 'Completed')
        ->whereHas('user', function ($query) {
            $query->where('barangay', auth()->user()->barangay);
        })
        ->orderByDesc('created_at')
        ->paginate(10);
        return response()->json([
            'comincidents' => $completedIncidents->items(),
            'pagination' => [
                'current_page' => $completedIncidents->currentPage(),
                'last_page' => $completedIncidents->lastPage(),
                'per_page' => $completedIncidents->perPage(),
                'total' => $completedIncidents->total(),
            ],
            'message' => 'Success',
        ]);
    }
    public function getCancelled(){
        $cancelledIncidents =  Incident::with('user')
        ->where('status', 'Cancelled')
        ->whereHas('user', function ($query) {
            $query->where('barangay', auth()->user()->barangay);
        })
        ->orderByDesc('created_at')
        ->paginate(10);
        return response()->json([
            'canincidents' => $cancelledIncidents->items(),
            'pagination' => [
                'current_page' => $cancelledIncidents->currentPage(),
                'last_page' => $cancelledIncidents->lastPage(),
                'per_page' => $cancelledIncidents->perPage(),
                'total' => $cancelledIncidents->total(),
            ],
            'message' => 'Success',
        ]);
    }
    public function getCompletedForwarded(){
        $forcomincidents = ForwardedIncident::with(['incident', 'incident.user'])->orderByDesc('created_at')->get();
        $completedforwardedIncidents =  $forcomincidents->where('status', 'Completed')->where('barangay', auth()->user()->barangay);
        return response()->json([
            'forcomincidents' => $completedforwardedIncidents,
            'message' => 'Success',
        ]);
    }
    public function getReceived(){
        $receIncidents = ForwardedIncident::with(['incident', 'incident.user'])->orderByDesc('created_at')->get();
        $receivedincidents =  $receIncidents->where('barangay', auth()->user()->barangay);
        return response()->json([
            'receIncidents' => $receivedincidents,
            'message' => 'Success',
        ]);
    }
    public function getReport(){
        $reportedIncident = Report::with('user')
        ->where('status', 'Pending')
        ->whereHas('user', function ($query) {
            $query->where('barangay', auth()->user()->barangay);
        })
        ->orderByDesc('datehappened')
        ->paginate(10);
        return response()->json([
            'reports' => $reportedIncident->items(),
            'pagination' => [
                'current_page' => $reportedIncident->currentPage(),
                'last_page' => $reportedIncident->lastPage(),
                'per_page' => $reportedIncident->perPage(),
                'total' => $reportedIncident->total(),
            ],
            'message' => 'Success',
        ]);
    }
    public function getForwardedReport(){
        $forreports = ForwardedReport::with('report')->orderByDesc('created_at')->get();
        $forwardedReports =  $forreports->where('status','Pending')->where('barangay', auth()->user()->barangay);
        return response()->json([
            'forreports' => $forwardedReports,
            'message' => 'Success',
        ]);
    }
    public function getRespondingReport(){
        $respondReports = Report::with('user')
        ->where('status', 'Responding')
        ->whereHas('user', function ($query) {
            $query->where('barangay', auth()->user()->barangay);
        })
        ->orderByDesc('created_at')
        ->paginate(10);
        return response()->json([
            'resreports' => $respondReports->items(),
            'pagination' => [
                'current_page' => $respondReports->currentPage(),
                'last_page' => $respondReports->lastPage(),
                'per_page' => $respondReports->perPage(),
                'total' => $respondReports->total(),
            ],
            'message' => 'Success',
        ]);
    }
    public function getRespondingForwardedReport(){
        $resforreports = ForwardedReport::with('report')->orderByDesc('created_at')->get();
        $resforwardedReports =  $resforreports->where('status','Responding')->where('barangay', auth()->user()->barangay);
        return response()->json([
            'resforreports' => $resforwardedReports,
            'message' => 'Success',
        ]);
    }
    public function getForwardReport(){
        $foreport = Report::with('user')->orderByDesc('created_at')->get();
        $transferedReports =  $foreport->where('status', 'Forwarded')->where('user.barangay', auth()->user()->barangay);
        return response()->json([
            'foreport' => $transferedReports,
            'message' => 'Success',
        ]);
    }
    public function getReForwardReport(){
        $reforwarded = ForwardedReport::with('report')->orderByDesc('created_at')->get();
        $transferedReports =  $reforwarded->where('status','Forwarded')->where('barangay', auth()->user()->barangay);
        return response()->json([
            'reforwarded' => $transferedReports,
            'message' => 'Success',
        ]);
    }
    public function getCompletedReport(){
        $completedReports = Report::with('user')
        ->where('status', 'Completed')
        ->whereHas('user', function ($query) {
            $query->where('barangay', auth()->user()->barangay);
        })
        ->orderByDesc('created_at')
        ->paginate(10);
        return response()->json([
            'compreport' => $completedReports->items(),
            'pagination' => [
                'current_page' => $completedReports->currentPage(),
                'last_page' => $completedReports->lastPage(),
                'per_page' => $completedReports->perPage(),
                'total' => $completedReports->total(),
            ],
            'message' => 'Success',
        ]);
    }
    public function getCompletedForwardReport(){
        $reforwarded = ForwardedReport::with('report')->orderByDesc('created_at')->get();
        $completedForReports =  $reforwarded->where('status','Completed')->where('barangay', auth()->user()->barangay);
        return response()->json([
            'compforreport' => $completedForReports,
            'message' => 'Success',
        ]);
    }
    public function getCancelledReport(){
        $cancelledReports = Report::with('user')
        ->where('status', 'Cancelled')
        ->whereHas('user', function ($query) {
            $query->where('barangay', auth()->user()->barangay);
        })
        ->orderByDesc('created_at')
        ->paginate(10);
        return response()->json([
            'canpreport' => $cancelledReports->items(),
            'pagination' => [
                'current_page' => $cancelledReports->currentPage(),
                'last_page' => $cancelledReports->lastPage(),
                'per_page' => $cancelledReports->perPage(),
                'total' => $cancelledReports->total(),
            ],
            'message' => 'Success',
        ]);
    }
    public function cancelledReport($id){
        $canpreport = Report::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history12' => $canpreport,
            'message' => 'Success',
        ], 200);
    }
    public function cancelledIncident($id){
        $canincidents = Incident::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history15' => $canincidents,
            'message' => 'Success',
        ], 200);
    }
    public function reforwardReport($id){
        $reforwarded = ForwardedReport::with('report.user')->where('id', $id)->get();
        
        return response()->json([
            'history13' => $reforwarded,
            'message' => 'Success',
        ], 200);
    }
    public function completedReport($id){
        $foreport = Report::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history12' => $foreport,
            'message' => 'Success',
        ], 200);
    }
    public function completedForwardReport($id){
        $reforwarded = ForwardedReport::with('report.user')->where('id', $id)->get();
        
        return response()->json([
            'history13' => $reforwarded,
            'message' => 'Success',
        ], 200);
    }
    public function forwardReport($id){
        $foreport = Report::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history12' => $foreport,
            'message' => 'Success',
        ], 200);
    }
    public function RespondingReport($id){
        $resreports = Report::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history10' => $resreports,
            'message' => 'Success',
        ], 200);
    }
    public function RespondingForwardedReport($id){
        $resforreports = ForwardedReport::with('report.user')->where('id', $id)->get();
        
        return response()->json([
            'history11' => $resforreports,
            'message' => 'Success',
        ], 200);
    }
    public function PendingReport($id){
        $reports = Report::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history8' => $reports,
            'message' => 'Success',
        ], 200);
    }
    public function getCurrentReport($id){
        $reports = Report::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history14' => $reports,
            'message' => 'Success',
        ], 200);
    }
    public function getCurrentQueReport($id){
        $reports = Report::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history14' => $reports,
            'message' => 'Success',
        ], 200);
    }
    public function ForwardedReport($id){
        $reports = ForwardedReport::with('report.user')->where('id', $id)->get();
        
        return response()->json([
            'history9' => $reports,
            'message' => 'Success',
        ], 200);
    }
    public function ReceivedIncident($id){
        $receincident = ForwardedIncident::with('incident.user')->where('id', $id)->get();
        
        return response()->json([
            'history7' => $receincident,
            'message' => 'Success',
        ], 200);
    }
    public function completedIncident($id){
        $comincidents = Incident::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history5' => $comincidents,
            'message' => 'Success',
        ], 200);
    }
    public function completedForwarded($id){
        $forcomincident = ForwardedIncident::with('incident.user')->where('id', $id)->get();
        
        return response()->json([
            'history6' => $forcomincident,
            'message' => 'Success',
        ], 200);
    }
    public function unavailable($id){
        $unavailable = Incident::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history4' => $unavailable,
            'message' => 'Success',
        ], 200);
    }
    public function unavailableReport($id){
        $reports = Report::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history13' => $reports,
            'message' => 'Success',
        ], 200);
    }
    public function RespondingForwarded($id){
        $resrecincident = ForwardedIncident::with('incident.user')->where('id', $id)->get();
        
        return response()->json([
            'history3' => $resrecincident,
            'message' => 'Success',
        ], 200);
    }
    public function RespondingIncident($id){
        $resincidents = Incident::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history2' => $resincidents,
            'message' => 'Success',
        ], 200);
    }
    public function PendingForwarded($id){
        $recincident = ForwardedIncident::with('incident.user')->where('id', $id)->get();
        
        return response()->json([
            'history1' => $recincident,
            'message' => 'Success',
        ], 200);
    }
    public function PendingIncident($id){
        $incidents = Incident::with('user')->where('id', $id)->get();
        
        return response()->json([
            'history' => $incidents,
            'message' => 'Success',
        ], 200);
    }
    public function getCurrentForwarded($id){
        $recincident = ForwardedIncident::with('incident.user')->where('id', $id)->get();
        
        return response()->json([
            'history1' => $recincident,
            'message' => 'Success',
        ], 200);
    }
    public function getCurrentIncident($id){
    $incidents = Incident::with('user')->where('id', $id)->get();
    
    return response()->json([
        'history' => $incidents,
        'message' => 'Success',
    ], 200);
    }
    public function getCurrentQue($id){
        $incidents = Incident::with('user')->where('id', $id)->get();
        
        return response()->json([
            'que' => $incidents,
            'message' => 'Success',
        ], 200);
        }

    public function user_emegency_history($id)
    {
        $incidents = Incident::where('residents_id', $id)->orderByDesc('created_at')->get();

        return response()->json([
            'history' => $incidents,
            'message' => 'Success',
        ], 200);
    }

    public function user_incident_history($id)
    {
        $incidents = Report::where('residents_id', $id)->orderByDesc('created_at')->get();

        return response()->json([
            'history' => $incidents,
            'message' => 'Success',
        ], 200);
    }

    public function manageUnavailable()
    {
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $forwardedIncidents =  $incidents->where('status', 'Que')->where('user.barangay', auth()->user()->barangay);

        // dd($forwardedIncidents);
        return view('unavailable', compact('forwardedIncidents'));
        // return response()->json([
        //     'incidents' => $forwardedIncidents,
        //     'message' => 'Success',
        // ], 200);
    }
    public function manageCancelled()
    {
        $incidents = Incident::with('user')->orderByDesc('created_at')->get();
        $cancelledIncidents =  $incidents->where('status', 'Cancelled')->where('user.barangay', auth()->user()->barangay);

        return view('cancelled', compact('cancelledIncidents'));
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

    public function textAlert($number, $message) {
        $ch = curl_init();
        $url = 'https://semaphore.co/api/v4/messages';
        $api_key = 'f2dee59156e7c0028c381fd182a61848';
    
        $parameters = array(
            'apikey' => $api_key,
            'number' => $number,
            'message' => $message,
            'sendername' => 'SEMAPHORE'
        );
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    

        $output = curl_exec($ch);
    

        if (curl_errno($ch)) {

            error_log('Semaphore API Error: ' . curl_error($ch));
        }

        curl_close($ch);
    
    }




    public function create(Request $request)
    {

        $validateUser = User::find($request->residents_id);

        if (!$validateUser || $validateUser->status !== 'Active') {
            return response()->json([
                'error' => 'Account has been banned!',
            ], 400);
        }

        $responders = TextAlert::all();
        $incident = new Incident;
        
        $incident->residents_id = $request->residents_id;
        $incident->type = $request->type;
        $incident->status = $request->status;
        $incident->latitude = $request->latitude;
        $incident->longitude = $request->longitude;
        
        $incident->save();

       
        event(new IncidentCreated($incident));
       
        $phoneNumbers = null;
        $user = $incident->user; 

        if ($request->type == 'Requesting for Ambulance') {
            $phoneNumbers = $responders->where('responder', 'Ambulance')->pluck('number')->toArray();
        } elseif ($request->type == 'Requesting for a Fire Truck') {
            $phoneNumbers = $responders->where('responder', 'Firetruck')->pluck('number')->toArray();
        } elseif ($request->type == 'Requesting for a Barangay Public Safety Officer') {
            $phoneNumbers = $responders->where('responder', 'Bpat')->pluck('number')->toArray();
        }

        $message = "OTAP-Emergency\n\n";
        $message .= "User Information\n";
        $message .= "Name: {$user->first_name} {$user->last_name}\n";
        $message .= "Contact Number: {$user->contact_no}\n";
        $message .= "Location: https://www.google.com/maps?q={$request->latitude},{$request->longitude}\n";
        
        foreach ($phoneNumbers as $phoneNumber) {
            // $this->textAlert($phoneNumber, $message);
        }

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

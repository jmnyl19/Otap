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
        // $recincidents = ForwardedIncident::with('incident')->orderByDesc('created_at')->get();
        $pendingCount = $incidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay)->count();
        // $forpendingCount = $recincidents->where('status', 'Pending')->where('barangay', auth()->user()->barangay)->count();
        // $totalPending = $pendingCount + $forpendingCount;

        $respondingCount = $incidents->where('status', 'Responding')->where('user.barangay', auth()->user()->barangay)->count();
        // $forrespondingCount = $recincidents->where('status', 'Responding')->where('barangay', auth()->user()->barangay)->count();
        // $totalResponding = $respondingCount + $forrespondingCount;

        $completedCount = $incidents->where('status', 'Completed')->where('user.barangay', auth()->user()->barangay)->count();
        // $forcompletedCount = $recincidents->where('status', 'Completed')->where('barangay', auth()->user()->barangay)->count();
        // $totalCompleted = $completedCount + $forcompletedCount;

        // $forwardedCount = $incidents->where('status', 'Forwarded')->where('user.barangay', auth()->user()->barangay)->count();
        // $forforwardedCount = $recincidents->where('status', 'Forwarded')->where('barangay', auth()->user()->barangay)->count();
        // $totalForwarded = $forwardedCount + $forforwardedCount;

        $unavailableCount = $incidents->where('status', 'Unavailable')->where('user.barangay', auth()->user()->barangay)->count();
        


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
    public function getLatestReport(){
        $reports = Report::with('user')->orderByDesc('datehappened')->get();
        $reportedIncident = $reports->where('user.barangay', auth()->user()->barangay)->where('status', 'Pending')->take(5);
        return response()->json([
            'reports' => $reportedIncident,
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
        $allincidents = Incident::with('user')->orderByDesc('created_at')->get();
        $allpendingIncidents = $allincidents->where('status', 'Pending')->where('user.barangay', auth()->user()->barangay);
        return response()->json([
            'allincidents' => $allpendingIncidents,
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
        $resincidents = Incident::with('user')->orderByDesc('created_at')->get();
        $allrespondingIncidents = $resincidents->where('status', 'Responding')->where('user.barangay', auth()->user()->barangay);
        return response()->json([
            'resincidents' => $allrespondingIncidents,
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
        $unavailable = Incident::with('user')->orderByDesc('created_at')->get();
        $resunavailable =  $unavailable->where('status', 'Unavailable')->where('user.barangay', auth()->user()->barangay);
        return response()->json([
            'unavailable' => $resunavailable,
            'message' => 'Success',
        ]);
    }
    public function getUnavailableReport(){
        $unavailable = Report::with('user')->orderByDesc('datehappened')->get();
        $unavailablereport = $unavailable->where('user.barangay', auth()->user()->barangay)->where('status', 'Unavailable');
        return response()->json([
            'unavailablereport' => $unavailablereport,
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
        $comincidents = Incident::with('user')->orderByDesc('created_at')->get();
        $completedIncidents =  $comincidents->where('status', 'Completed')->where('user.barangay', auth()->user()->barangay);
        return response()->json([
            'comincidents' => $completedIncidents,
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
        $reports = Report::with('user')->orderByDesc('datehappened')->get();
        $reportedIncident = $reports->where('user.barangay', auth()->user()->barangay)->where('status', 'Pending');
        return response()->json([
            'reports' => $reportedIncident,
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
        $resreports = Report::with('user')->orderByDesc('created_at')->get();
        $respondReports = $resreports->where('status', 'Responding')->where('user.barangay', auth()->user()->barangay);
        return response()->json([
            'resreports' => $respondReports,
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
        $foreport = Report::with('user')->orderByDesc('created_at')->get();
        $completedReports = $foreport->where('status', 'Completed')->where('user.barangay', auth()->user()->barangay);
        return response()->json([
            'compreport' => $completedReports,
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
        $forwardedIncidents =  $incidents->where('status', 'Forwarded')->where('user.barangay', auth()->user()->barangay);

        // dd($forwardedIncidents);
        return view('unavailable', compact('forwardedIncidents'));
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

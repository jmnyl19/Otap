<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ForwardedReport;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\EmergencyCreated;
use App\Models\TextAlert;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::with('user')->orderByDesc('datehappened')->get();
        $reportedIncident = $reports->where('user.barangay', auth()->user()->barangay)->where('status', 'Pending');
        $incidents = ForwardedReport::with('report')->orderByDesc('created_at')->get();
        $forwardedReports =  $incidents->where('status','Pending')->where('barangay', auth()->user()->barangay);

        return view('latest', compact('reportedIncident','forwardedReports'));
    }

    public function respondedreports()
    {
        $reports = Report::with('user')->orderByDesc('created_at')->get();
        $respondIncident = $reports->where('status', 'Responding')->where('user.barangay', auth()->user()->barangay);
        $incidents = ForwardedReport::with('report')->orderByDesc('created_at')->get();
        $forwardedReports =  $incidents->where('status','Responding')->where('barangay', auth()->user()->barangay);

        return view('respondedreports', compact('respondIncident','forwardedReports')); 
    }

    public function manageUnavailableReports()
    {
        $incidents = Report::with('user')->orderByDesc('created_at')->get();
        $forwardedReports =  $incidents->where('status', 'Que')->where('user.barangay', auth()->user()->barangay);
        // $incidents = ForwardedReport::with('report')->orderByDesc('created_at')->get();
        // $reforwardedReports =  $incidents->where('status','Forwarded')->where('barangay', auth()->user()->barangay);

        return view('unavailablereports', compact('forwardedReports'));
    }
    public function manageCancellReports()
    {
        $incidents = Report::with('user')->orderByDesc('created_at')->get();
        $cancelledReports =  $incidents->where('status', 'Cancelled')->where('user.barangay', auth()->user()->barangay);
       
        return view('cancelledreports', compact('cancelledReports'));
    }


    public function completedreports()
    {
        $reports = Report::with('user')->orderByDesc('created_at')->get();
        $completedIncident = $reports->where('status', 'Completed')->where('user.barangay', auth()->user()->barangay);
        $incidents = ForwardedReport::with('report')->orderByDesc('created_at')->get();
        $forwardedReports =  $incidents->where('status','Completed')->where('barangay', auth()->user()->barangay);

        return view('completedreports', compact('completedIncident','forwardedReports')); 
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function textAlertReport($number, $message) {
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
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('file'), $imageName);
        } else {
            $imageName = null;
        }

        $report = new Report;
        $report->residents_id = $request->residents_id;
        $report->file = $imageName;
        $report->datehappened = $request->datehappened;
        $report->timehappened = $request->timehappened;
        $report->longitude = $request->longitude;
        $report->latitude = $request->latitude;
        $report->type_of_incidents = $request->type_of_incidents;
        $report->BPSO = $request->BPSO;
        $report->Ambulance = $request->Ambulance;
        $report->Firetruck = $request->Firetruck;
        $report->details = $request->details;
        $report->addnotes = $request->addnotes;
        $report->status = $request->status;
        $report->save();

        event(new EmergencyCreated($report));

        $phoneNumbers = [];
        $user = $report->user; 

        if ($request->Ambulance == 1) {
            $phoneNumbers = array_merge($phoneNumbers, $responders->where('responder', 'Ambulance')->pluck('number')->toArray());
        } 
        if ($request->Firetruck == 1) {
            $phoneNumbers = array_merge($phoneNumbers, $responders->where('responder', 'Firetruck')->pluck('number')->toArray());
        } 
        if ($request->BPSO == 1) {
            $phoneNumbers = array_merge($phoneNumbers, $responders->where('responder', 'Bpat')->pluck('number')->toArray());
        }

        $message = "OTAP-Incident\n\n";
        $message .= "User Information\n";
        $message .= "Name: {$user->first_name} {$user->last_name}\n";
        $message .= "Contact Number: {$user->contact_no}\n";
        $message .= "Location: https://www.google.com/maps?q={$request->latitude},{$request->longitude}\n";
        
        foreach ($phoneNumbers as $phoneNumber) {
            $this->textAlertReport($phoneNumber, $message);
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

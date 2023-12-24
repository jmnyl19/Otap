<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ForwardedReport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $forwardedReports =  $incidents->where('status', 'Unavailable')->where('user.barangay', auth()->user()->barangay);
        // $incidents = ForwardedReport::with('report')->orderByDesc('created_at')->get();
        // $reforwardedReports =  $incidents->where('status','Forwarded')->where('barangay', auth()->user()->barangay);

        return view('unavailablereports', compact('forwardedReports'));
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
    public function create(Request $request)
    {
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
        $report->details = $request->details;
        $report->addnotes = $request->addnotes;
        $report->status = $request->status;
        $report->save();

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

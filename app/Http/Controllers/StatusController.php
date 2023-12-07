<?php

namespace App\Http\Controllers;
use App\Models\ForwardedIncident;
use App\Models\ForwardedReport;
use App\Models\Report;
use App\Models\Incident;
use App\Http\Controllers\Controller;
use App\Events\UpdateStatus;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function respond(Request $request, $id)
    {
        $incidents = Incident::find($id);
        $incidents->status = 'Responding';
        $incidents->save();
        // event(new UpdateStatus($incidents));
        return response()->json([
            
            'message' => 'Responding...',
        ], 200);
    }

    public function responded(Request $request, $id)
    {
        $incidents = ForwardedIncident::find($id);
        $incidents->status = 'Responding';
        $incidents->save();
        return redirect('/responding');
    }
    public function responding(Request $request, $id)
    {
        $incidents = Report::find($id);
        $incidents->status = 'Responding';
        $incidents->save();
        return redirect('/respondedreports');
    }
    public function respondreport(Request $request, $id)
    {
        $incidents = ForwardedReport::find($id);
        $incidents->status = 'Responding';
        $incidents->save();
        return redirect('/respondedreports');
    }

    public function forward(Request $request, $id)
    {
        $incidents = Incident::find($id);
        $incidents->status = 'Forwarded';
        $incidents->save();

        $forward = new ForwardedIncident;
        $forward->incident_id = $request->incident_id;
        $forward->barangay = $request->barangay;
        $forward->status = $request->status;
        $forward->save();

        return redirect('/forwarded');
    }
    public function forwarded(Request $request, $id)
    {
        $incidents = Report::find($id);
        $incidents->status = 'Forwarded';
        $incidents->save();

        $forwarded = new ForwardedReport;
        $forwarded->report_id = $request->report_id;
        $forwarded->barangay = $request->barangay;
        $forwarded->status = $request->status;
        $forwarded->save();

        return redirect('/forwardedreports');
    }

    public function reforward(Request $request, $id)
    {

        $incidents = ForwardedIncident::find($id);
        $incidents->status = 'Forwarded';
        $incidents->save();

        $forward = new ForwardedIncident;
        $forward->incident_id = $request->incident_id;
        $forward->barangay = $request->barangay;
        $forward->status = $request->status;
        $forward->save();

        return redirect('/forwarded');
    }

    public function reforwarded(Request $request, $id)
    {
        $incidents = ForwardedReport::find($id);
        $incidents->status = 'Forwarded';
        $incidents->save();

        $forwarded = new ForwardedReport;
        $forwarded->report_id = $request->report_id;
        $forwarded->barangay = $request->barangay;
        $forwarded->status = $request->status;
        $forwarded->save();

        return redirect('/forwardedreports');
    }

    public function completed(Request $request, $id)
    {
        $incidents = Incident::find($id);
        $incidents->status = 'Completed';
        $incidents->save();
        return redirect('/completedpage');
    }
    public function forcompleted(Request $request, $id)
    {
        $incidents = ForwardedIncident::find($id);
        $incidents->status = 'Completed';
        $incidents->save();
        return redirect('/completedpage');
    }
    public function completing(Request $request, $id)
    {
        $incidents = Report::find($id);
        $incidents->status = 'Completed';
        $incidents->save();
        return redirect('/completedreports');
    }
    public function completedreport(Request $request, $id)
    {
        $incidents = ForwardedReport::find($id);
        $incidents->status = 'Completed';
        $incidents->save();
        return redirect('/completedreports');
    }

    public function cancelled(Request $request, $id)
    {
        $incidents = Incident::find($id);
        $incidents->status = 'Cancelled';
        $incidents->save();
        
        return response()->json([
            'cancel' => $incidents,
            'message' => 'Success',
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

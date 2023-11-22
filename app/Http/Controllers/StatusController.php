<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Http\Controllers\Controller;
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
        return redirect('/responding');
    }
    public function forward(Request $request, $id)
    {
        $incidents = Incident::find($id);
        $incidents->status = 'Forwarded';
        $incidents->save();
        return redirect('/forwarded');
    }
    public function completed(Request $request, $id)
    {
        $incidents = Incident::find($id);
        $incidents->status = 'Completed';
        $incidents->save();
        return redirect('/completedpage');
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

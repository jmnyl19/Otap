<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incidents = Incident::with('user')->where('residents_id',auth()->user()->id)->get();
        $pendingCount = Incident::with('user')->where('residents_id',auth()->user()->id)->where('status', 'Pending')->count();
        $respondCount = Incident::with('user')->where('residents_id',auth()->user()->id)->where('status', 'Respond')->count();
        $forwardCount = Incident::with('user')->where('residents_id',auth()->user()->id)->where('status', 'Forward')->count();
        return view('landingpage', compact('incidents','pendingCount','respondCount','forwardCount'));
   
    }

    public function staritaadmin() {
        // return this view
        $incidents = Incident::all();
        $pendingCount = Incident::where('status', 'Pending')->count();
        $respondedCount = Incident::where('status', 'Respond')->count();
        $forwardedCount = Incident::where('status', 'Forward')->count();
    
        return view('landingpage', compact('incidents','pendingCount','respondedCount','forwardedCount'));
    }

    public function etapinacadmin() {
        // return this view
        $incidents = Incident::all();
        $pendingCount = Incident::where('status', 'Pending')->count();
        $respondedCount = Incident::where('status', 'Respond')->count();
        $forwardedCount = Incident::where('status', 'Forward')->count();
    
        return view('secadminpage', compact('incidents','pendingCount','respondedCount','forwardedCount'));
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
    public function show() {
        return view('welcome');
    }
    public function login(Request $request) {
  

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
          

            if (auth()->user()->role == 'Resident'){
                return redirect()->intended('incidents');
            }elseif (auth()->user()->role == 'Sta Rita Admin') {
                return redirect()->intended('staritaadmin');
            } else {
                return redirect()->intended('etapinacadmin');
            }
            
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match!'
        ])->onlyInput('email');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}

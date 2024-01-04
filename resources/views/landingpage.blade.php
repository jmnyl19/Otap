@extends('layouts.app')
@section('css')
<link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
Dashboard
@endsection


@section('content')
@section('js')
<script src="{{ asset('path/to/maps.js') }}"></script>
<script src="{{ asset('js/sidenav.js') }}"></script>


@endsection

@php
    use Carbon\Carbon;
@endphp

@auth
    @include('sidebar.sidenav')
   
    <div class="landing-container p-4 mt-5" >
        <div class="row text-center justify-content-between align-items-center gap-3 mb-2" style="width: 100%">
            <div class="col-md-2 col-sm-4  p-4 rounded-3">
                <h3 class="fw-bolder pageTitle">Dashboard</h3>
            </div>
         
        </div>

        {{-- <div class="card-body">
            <div class="row align-items-center">
                <div class="row shadow p-4 mb-4 bg-white rounded-4 justify-content-around">
                    <div class="col col-md-6">
                        <h3 class="fw-bolder">Welcome back Barangay {{auth()->user()->barangay}}!</h3>
                    </div>
                    <div class="col col-md-6">
                        <img src="{{ asset('assets/dashboard.png') }}" width="250" height="250" alt="dashboardpng">
                    </div>
                </div>
            </div>
        </div> --}}
        

            <div class="row justify-content-evenly text-center mb-4" style="width: 100%">
                <div class="col col-md-2  p-4 mb-4 rounded-4 countCont" type="button" onclick="window.location='{{route('pendingpage')}}'" style="background-color: #fedcdc">
                    <div class="card-body ">
                        <div class="countLabel">
                            <div class="col-auto col-md-4">
                                <i class="bi bi-exclamation-triangle h1 pendingLogo "></i>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                            <div class="row justify-content-center">
                               
                                <div class="col-auto col-md-4 countText">
                                    <h1 class="fw-normal " style="color: #012763">{{$pendingCount}}</h1>
                                </div>
                                <h6 class="pendingLogo">Pending Emergency</h6>
                            </div>
                            
                        </div>
                </div>

                <div class="col-sm-4 col-md-2  p-4 mb-4 rounded-4 countCont" type="button" onclick="window.location='{{route('responding')}}'" style="background-color: #f5f8d4">
                    <div class="card-body ">
                        <div class="countLabel">
                            <div class="col-auto col-md-4">
                                <i class="bi bi-arrow-repeat h1 respondingLogo"></i>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                            <div class="row justify-content-center">
                               
                                <div class="col-auto col-md-4 countText">
                                    <h1 class="fw-normal " style="color: #012763">{{$respondingCount}}</h1>
                                </div>
                                <h6 class="respondingLogo">Responding Emergency</h6>
                            </div>
                        </div>
                </div>
                
                <div class="col-sm-4 col-md-2  p-4 mb-4 rounded-4 countCont" type="button" onclick="window.location='{{route('completedpage')}}'" style="background-color: #daf7d7">
                    <div class="card-body ">
                            <div class="row justify-content-center">
                                <div class="countLabel">
                                    <div class="col-auto col-md-4 ">
                                        <i class="bi bi-check-circle h1 completedLogo"></i>
                                    </div>
                                    <i class="bi bi-chevron-right"></i>
                                </div>
                                
                                <div class="col-auto col-md-4  countText">
                                    <h1 class="fw-normal " style="color: #012763">{{$completedCount}}</h1>
                                </div>
                                <h6 class="completedLogo">Completed Emergency</h6>
                            </div>
                        </div>
                </div>
                <div class="col-sm-4 col-md-2  p-4 mb-4 rounded-4 countCont" type="button" onclick="window.location='{{route('unavailable')}}'" style="background-color: #ffe6c9df">
                    <div class="card-body ">
                        <div class="countLabel">
                            <div class="col-auto col-md-4">
                                <i class="bi bi-send-exclamation h1 recievedLogo"></i>
                                </div>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                            <div class="row justify-content-center">
                                
                                <div class="col-auto col-md-4 countText">
                                    <h1 class="fw-normal " style="color: #012763">{{$unavailableCount}}</h1>
                                </div>
                                <h6 class="recievedLogo">Queue</h6>
                            </div>
                        </div>
                </div>

            </div>

            <div class="row justify-content-between latestMain mb-4" style="width: 100%;">
                <div class="col-sm-8 col-md-5 latestCont shadow p-4 mb-4 bg-white rounded-4">
                    <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="fw-bold" style="color: #012763">Latest Incident Reports</h5>
                                    <div class="col" id="getLatestReportsCont">
                                    </div>
                                    <div class="col" id="getLatestQueReportsCont">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-sm-4 col-md-5 latestCont shadow p-4 mb-4 bg-white rounded-4">
                
                    <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="fw-bold" style="color: #012763">Latest Emergency Request</h5>
                                    <div class="col" id="latestIncidentCont">
                                    </div>
                                    <div class="col" id="latestQueCont">
                                    </div>
                                </div>
                            </div>
                    </div>

                    <!-- Modal -->
        
                        <div class="modal fade"  id="pendingModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                        <h5 style="text-align: center"><i class="bi bi-megaphone-fill mr-5 pendingLogo"></i>   Emergency Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                    <div class="modal-body justify-content-center" id="pendingModalBody">
                                        
                                    </div>
                                    
                                        <div class="modal-body">
                                               
                                        </div>

                                        <input type="hidden" name="status" id="incidentStatus" value="Pending">
                            
                                    <div class="modal-footer justify-content-center" id="pendingModalFooter">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade"  id="pendingqueModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                        <h5 style="text-align: center"><i class="bi bi-megaphone-fill mr-5 pendingLogo"></i>   Emergency Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                        
                                    <div class="modal-body justify-content-center" id="pendingqueModalBody">
                                        
                                    </div>
                                    
                                        <div class="modal-body">
                                               
                                        </div>

                                        <input type="hidden" name="status" id="incidentStatus" value="Pending">
                            
                                    <div class="modal-footer justify-content-center" id="pendingqueModalFooter">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="reportModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                        <h4 style="text-align: center">Incident Report</h4>                                        
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="reportModalBody">
                                    
                                    </div>
                                    

                                    <div class="modal-body">
                                         
                                    </div>
                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="reportModalFooter">
                                        
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="reportqueModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                        <h4 style="text-align: center">Incident Report</h4>                                        
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="reportqueModalBody">
                                    
                                    </div>
                                    

                                    <div class="modal-body">
                                         
                                    </div>
                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="reportqueModalFooter">
                                        
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>

                        
                
                </div>
                <div class="col-sm-8 col-md-5 latestCont shadow p-4 mb-4 bg-white rounded-4">
                    <h5 class="fw-bold" style="color: #012763">Emergency Status Count</h5>
                    <div class="row">
                        <div class="col">
                            <label for="dateFilter">Select Filter:</label>
                            <select  id="dateFilter" onchange="updateChart()">
                                <option value="month">By Month</option>
                                <option value="year">By Year</option>
                            </select>
                        </div>
                        <div class="col">
                            <button onclick="downloadChart()">IMG</button>
                            <button onclick="printChart()">PDF</button>
                            <button onclick="exportToExcel()">Excel</button>

                        </div>
                    </div>
                    
                    
                    <div id="chartContainer">
                    <canvas id="myChart"></canvas>
                    </div>
                    
                </div>

                <div class="col-sm-4 col-md-5 latestCont shadow p-4 mb-4 bg-white rounded-4">
                    <h5 class="fw-bold" style="color: #012763">Emergency Count</h5>
                    
                    <div class="row">
                        <div  class="col">
                            <label for="pieFilter">Select Filter:</label>
                            <select id="pieFilter" onchange="updateChart1()">
                                <option value="month">By Month</option>
                                <option value="year">By Year</option>
                            </select>
                        </div>
                        <div  class="col">
                            <button onclick="downloadtypeChart()">IMG</button>
                            <button onclick="printtypeChart()">PDF</button>
                            <button onclick="exportTypeToExcel()">Excel</button>

                        </div>
                    </div>
                    <div>
                        <canvas id="PieChart" style="width: 200; height: 200;"></canvas>
                    </div>
                </div>
            </div>

            <!-- <div class="row justify-content-between" syle="width:100%;">
                
            </div> -->
    </div>
    





@section('pageJs')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/landing.js')}}"></script>
<script src="{{ asset('js/chart.js')}}"></script>
<script src="{{ asset('js/barchart.js')}}"></script>

@endsection
@endauth
@endsection
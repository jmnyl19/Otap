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
        

            <div class="row justify-content-between text-center mb-4" style="width: 100%">
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
                                    <h1 class="fw-normal " style="color: #012763">{{$totalPending}}</h1>
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
                                    <h1 class="fw-normal " style="color: #012763">{{$totalResponding}}</h1>
                                </div>
                                <h6 class="respondingLogo">Responding Emergency</h6>
                            </div>
                        </div>
                </div>
                <div class="col-sm-4 col-md-2  p-4 mb-4 rounded-4 countCont" type="button" onclick="window.location='{{route('forwarded')}}'" style="background-color: #d0d5fbd5">
                    <div class="card-body ">
                        <div class="countLabel">
                            <div class="col-auto col-md-4">
                                <i class="bi bi-send-check h1 forwardedLogo"></i>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-auto col-md-4 countText">
                                <h1 class="fw-normal " style="color: #012763">{{$forwardedCount}}</h1>
                            </div>
                            <h6 class="forwardedLogo">Forwarded Emergency</h6>
                        </div>
                        </div>
                </div>
                <div class="col-sm-4 col-md-2  p-4 mb-4 rounded-4 countCont" type="button" onclick="window.location='{{route('forwarded')}}'" style="background-color: #ffe6c9df">
                    <div class="card-body ">
                        <div class="countLabel">
                            <div class="col-auto col-md-4">
                                <i class="bi bi-send-exclamation h1 recievedLogo"></i>
                                </div>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                            <div class="row justify-content-center">
                                
                                <div class="col-auto col-md-4 countText">
                                    <h1 class="fw-normal " style="color: #012763">{{$recievedCount}}</h1>
                                </div>
                                <h6 class="recievedLogo">Recieved Emergency</h6>
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
                                    <h1 class="fw-normal " style="color: #012763">{{$totalCompleted}}</h1>
                                </div>
                                <h6 class="completedLogo">Completed Emergency</h6>
                            </div>
                        </div>
                </div>

            </div>


          


            <div class="row justify-content-between latestMain mb-4" style="width: 100%;">
                <div class="col-sm-8 col-md-5 latestCont shadow p-4 mb-4 bg-white rounded-4">
                    <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="fw-bold" style="color: #012763">Latest Forwarded Emergency Request</h5>
                                    <div class="col" id="latestForIncidentCont">
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
                                                <!-- Dropdown -->
                                                <div class="form-group">
                                                    <div class="form-group">

                                                        <label for="forwardDropdown">Forward this Emergency?</label>
                                                        <select class="form-control" id="forwardDropdown" name="barangay">
                                                            <!-- Add your dropdown options here -->
                                                            <option value="" selected disabled>Choose a Barangay:</option>
                                                            <option value="East Tapinac">East Tapinac</option>
                                                            <option value="Santa Rita">Santa Rita</option>
                                                        </select>
                                                    </div>
                                                    
                                            </div>
                                        </div>

                                        <input type="hidden" name="status" id="incidentStatus" value="Pending">
                            
                                    <div class="modal-footer justify-content-center" id="pendingModalFooter">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                

                        <div class="modal fade" id="pendingModal1" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border border-success border-3">
                                    <div class="modal-header">
                                        <h5 style="text-align: center"><i class="bi bi-megaphone-fill mr-5 pendingLogo"></i>   Emergency Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body justify-content-center" id="pendingModal1Body">
                                    
                                    </div>
                                    

                                    <div class="modal-body">
                                            <!-- Dropdown -->
                                        <div class="form-group">
                                                <div class="form-group">

                                                    <label for="forwardDropdown1">Forward this Emergency?</label>
                                                    <select class="form-control" id="forwardDropdown1" name="barangay">
                                                        <!-- Add your dropdown options here -->
                                                        <option value="" selected disabled>Choose a Barangay:</option>
                                                        <option value="East Tapinac">East Tapinac</option>
                                                        <option value="Santa Rita">Santa Rita</option>
                                                    </select>
                                                </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="status" id="incidentStatus" value="Pending">
                        
                                    <div class="modal-footer justify-content-center" id="pendingModal1Footer">
                                        
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                
                </div>

            </div>

            <div class="row justify-content-between">
                <div class="col col-md-6 shadow p-4 mb-4 bg-white rounded-4">
                    <canvas id="myChart" ></canvas>
                </div>
                <div class="col col-md-6 shadow p-4 mb-4 bg-white rounded-4">
                    <canvas id="lineChart" style="width: 600px; height: 300px;" ></canvas>
                </div>
            </div>
    </div>
    


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
  
var labels = {!! json_encode($labels) !!};
var datasets = {!! json_encode($datasets) !!};

const data = {
  labels: labels,
  datasets: datasets,
};

const config = {
  type: 'bar',
  data: data,
  options: {}
};

const myChart = new Chart(
  document.getElementById('myChart'),
  config
);
  
</script>

<!-- Add this script to initialize the maps -->
<script>
    // Array to store map instances
    // Your JavaScript code here
</script>




<!-- Call the initMaps function once the Google Maps API is loaded -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3sNbXeLLaZQcJiCWNzC4Rwp-xALyV4lM&callback=initMaps"></script>
@section('pageJs')
<script src="{{ asset('js/landing.js')}}"></script>
<script src="{{ asset('js/chart.js')}}"></script>
@endsection
@endauth
@endsection
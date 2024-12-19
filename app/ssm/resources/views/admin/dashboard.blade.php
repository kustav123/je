@extends('layouts.master')

@section('content')

    <div class="row">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Earnings (Monthly) Card Example -->
        {{-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Earnings ( {{ $currentMonth }} )</div>
                                <div class="h5 mb-0 font-weight-bold "><i class="fas fa-inr"></i>{{ $paidamount }} </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-inr fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1 d-flex justify-content-between">
                                <span>Earnings (Annual)</span>
                                <span class="text-gray-500">{{ $fiscalData['startOfFiscalYear']}} to {{ $fiscalData['endOfFiscalYear'] }}</span>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <i class="fas fa-inr"></i>{{ number_format($fiscalData['sumPaidAmount'], 2) }} <!-- Dynamically displaying sumPaidAmountYr -->
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-inr fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Earnings (Monthly) Card Example -->
        {{-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
{{--
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-m font-weight-bold text-success text-uppercase mb-1">
                                Accounts Receivable</div>

                            <div class="h5 mb-0 font-weight-bold "><i class="fas fa-inr"></i>{{ $totaldue }} </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-inr fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-m font-weight-bold text-success text-uppercase mb-1">
                                Number of client</div>

                            <div class="h5 mb-0 font-weight-bold ">{{ $totalclientCount }} </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Earnings vs Receivable</h6>
            </div>

            <div class="col-md-12 mb-3" style="text-align: center; margin-bottom: 20px;">
                <span style="display: inline-block; width: 15px; height: 15px; background-color: #4caf50; margin-right: 5px;"></span>
                Earnings
                <span style="display: inline-block; width: 15px; height: 15px; background-color: #f44336; margin-left: 20px; margin-right: 5px;"></span>
                Receivable
            </div>

            @foreach($appinfos as $appinfo)
            <div class="col-md-12 mb-3">
                <div style="text-align: center; margin-bottom: 5px;">
                    {{ $appinfo['company_name'] }}
                </div>
                <div class="chart-container" style="display: flex; align-items: center;">
                    <div class="left-bar"
                        style="width: {{ $appinfo['erpercentage'] }}%; background-color: #4caf50; color: white; padding: 5px; text-align: center;"
                        title="Earnings: {{ $appinfo['earnings'] }} | Total: {{ $appinfo['total'] }}">
                        {{ $appinfo['erpercentage'] }}%
                    </div>

                    <div class="right-bar"
                        style="width: {{ $appinfo['dupercentage'] }}%; background-color: #f44336; color: white; padding: 5px; text-align: center;"
                        title="Due: {{ $appinfo['due'] }} | Total: {{ $appinfo['total'] }}">
                        {{ $appinfo['dupercentage'] }}%
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

    <div class="row">

            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Job Status Overview</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="container mt-4">
                        <div class="row">
                            <!-- Chart Column -->
                            <div class="col-md-8">
                                <div id="chartContainer" style="height: 400px; ">
                                    <canvas id="myPieChart"></canvas>
                                    <span id="openJobs" style="display:none;">{{ $openjobs }}</span>
                                    <span id="assignedJobs" style="display:none;">{{ $assigned }}</span>
                                    <span id="holdJobs" style="display:none;">{{ $hold }}</span>
                                    <span id="pendingJobs" style="display:none;">{{ $pending }}</span>
                                    <span id="ready" style="display:none;">{{ $readyfordel }}</span>
                                </div>
                            </div>
                            <!-- Table Column -->
                            <div class="col-md-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><i class="fas fa-circle text-danger"></i> Open</td>
                                            <td>{{ $openjobs }}</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-circle text-success"></i> Assigned</td>
                                            <td>{{ $assigned }}</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-circle text-info"></i> Hold</td>
                                            <td>{{ $hold }}</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-circle text-warning"></i> Pending</td>
                                            <td>{{ $pending }}</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-circle text-secondary"></i> Ready</td>
                                            <td>{{ $readyfordel }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Top 5 Clients with Maximum Outstanding Dues</h6>
                    </div>
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myBarChart" style="width: 100%; height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


    </div>
    {{-- <div id="topDueClients" data-top-due-clients="{{ json_encode($topDueClients) }}"></div> --}}


  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
<script src="{{ asset('js/demo/chart-bar.js') }}"></script>




@endsection



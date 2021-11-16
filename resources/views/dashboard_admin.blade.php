@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('body')
    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Overview</h2>
                        <p>Snippet of what is happening on BillingPlusU</p>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link"></a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            @include('flash-message')
            <div class="row">           
	            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
	                <div class="card">
	                    <div class="card-body">
	                        <div class="d-inline-block">
	                            <h5 class="text-muted">Total Claims</h5>
	                            <h2 class="mb-0"> 10</h2>
	                        </div>
	                            <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
	                                <i class="fas fa-file-medical fa-fw fa-sm text-info"></i>
	                            </div>
	                    </div>
	                </div>
	            </div>
	            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
	                <div class="card">
	                    <div class="card-body">
	                        <div class="d-inline-block">
	                            <h5 class="text-muted">Total Specialists</h5>
	                            <h2 class="mb-0"> 6</h2>
	                        </div>
	                        <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
	                            <i class="fas fa-user-md fa-fw fa-sm text-primary"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
	                <div class="card">
	                    <div class="card-body">
	                        <div class="d-inline-block">
	                            <h5 class="text-muted">Total Processors</h5>
	                            <h2 class="mb-0">14</h2>
	                        </div>
	                        <div class="float-right icon-circle-medium  icon-box-lg  bg-secondary-light mt-1">
	                            <i class="fa fa-user fa-fw fa-sm text-secondary"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-8 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Claim per month</h5>
                        <div class="card-body">
                            <canvas id="month" width="400" height="150"></canvas>
                        </div>
                        <div class="card-body border-top">
                            <div class="row">
                                <div class="offset-xl-1 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 p-3">
                                    <h5>Here is the total submitted claims this month and previous month</h5>
                                </div>
                                <div class="offset-xl-1 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 p-3">
                                    <h2 class="font-weight-normal mb-3"><span>this_month_claims_num claims</span></h2>
                                    <div class="mb-0 mt-3 legend-item">
                                        <span class="fa-xs text-primary mr-1 legend-title "><i class="fa fa-fw fa-square-full"></i></span>
                                        <span class="legend-text">This Month</span></div>
                                    </div>
                                    <div class="offset-xl-1 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 p-3">
                                        <h2 class="font-weight-normal mb-3">
                                        <span>last_month_claims_num claims</span>
                                        </h2>
                                        <div class="text-muted mb-0 mt-3 legend-item"> <span class="fa-xs text-secondary mr-1 legend-title"><i class="fa fa-fw fa-square-full"></i></span><span class="legend-text">Previous Month</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('foot')
    <script src="{{ URL::asset('js/charts-bundle/Chart.bundle.js') }}"></script>
    <script src="{{ URL::asset('js/charts-bundle/chartjs.js') }}"></script>
    <script>
        $(function() {
            "use strict";
            var ctx = document.getElementById('month').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    datasets: [{
                        label: 'This Month',
                        data: [12, 19, 3, 17, 6, 3, 7],
                        backgroundColor: "rgba(89, 105, 255,0.5)",
                        borderColor: "rgba(89, 105, 255,0.7)",
                        borderWidth: 2

                        }, {
                        label: 'Previous Month',
                        data: [2, 29, 5, 5, 2, 3, 10],
                        backgroundColor: "rgba(255, 64, 123,0.5)",
                        borderColor: "rgba(255, 64, 123,0.7)",
                        borderWidth: 2
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function(value, index, values) {
                                    return '$' + value;
                                }
                            }
                        }]
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d',
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                fontSize: 14,
                                fontFamily: 'Circular Std Book',
                                fontColor: '#71748d',
                            }
                        }]
                    }
                }
            });
            var ctx = document.getElementById("item-num").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["111", " 222", "310", " 453"],
                    datasets: [{
                        backgroundColor: [
                            "#5969ff",
                            "#ff407b",
                            "#25d5f2",
                            "#ffc750"
                        ],
                        data: [350.56, 135.18, 48.96, 154.02]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    }
                }
            });
        });
    </script>
@stop
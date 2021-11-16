@extends('layouts.dashboard')
@section('title', 'Manage All Claim')
@section('head')
    <link rel="stylesheet" href="{{ URL::asset('css/notika-custom-icon.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/inputclaimcss/css/jquery.dataTables.min.css') }}">
@stop
@section('body')
    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Showing All Claims Submitted</h2>
                        <p class="pageheader-text">Manage the claim to be processed</p>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">BillingPlusU for Processor</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            @include('flash-message')
            <div class="data-table-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="data-table-list">
                                <div class="basic-tb-hd text-center">
                                    <br>
                                    <h3 style="color:#3F51B5;">Waiting for Billing</h3>
                                    <br>
                                </div>
                                <div class="table-responsive">
                                    <table id="data-table-basic" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Specialist Name</th>
                                                <th>Date of Service</th>
                                                <th>Patient Name</th>
                                                <th>Item Numbers</th>
                                                <th>Location</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($claim_waiting as $claim)
                                                <tr>
                                                    <td>{{ $claim->user ? $claim->user->first_name . ' ' . $claim->user->last_name : ""}}</td>
                                                    <td>{{ $claim->date_of_services ? $claim->date_of_services->format('d/m/Y') : "" }}</td>
                                                    @if ($claim->first_name)
                                                        <td>{{$claim->title}} {{$claim->first_name}} {{$claim->last_name}}</td>  
                                                    @else
                                                        <td>Please fill in the details</td>
                                                    @endisset
                                                    <td>{{ $claim->item_numbers }}</td>
                                                    <td>{{ $claim->location ? $claim->location->location : "" }}</td>
                                                    <td><a class="btn-sm btn-success" href="{{ url('claim_details', $claim['id'])}}">Input Claim Details</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Specialist Name</th>
                                            <th>Date of Service</th>
                                            <th>Patient Name</th>
                                            <th>Item Numbers</th>
                                            <th>Location</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <!-- Processed claim table -->
            <div class="data-table-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="data-table-list">
                                <div class="basic-tb-hd text-center">
                                    <br>
                                    <h3 style="color:#3F51B5;">Processed Claim Table</h3>
                                    <br>
                                </div>
                                <div class="table-responsive">
                                    <table id="data-table-basic" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Specialist Name</th>
                                                <th>Date of Service</th>
                                                <th>Patient Name</th>
                                                <th>Item Numbers</th>
                                                <th>Location</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($claim_process as $claim)
                                                <tr>
                                                    <td>{{ $claim->user ? $claim->user->first_name . ' ' . $claim->user->last_name : ""}}</td>
                                                    <td>{{ $claim->date_of_services ? $claim->date_of_services->format('d/m/Y') : "" }}</td>
                                                    @if ($claim->first_name)
                                                        <td>{{$claim->title}} {{$claim->first_name}} {{$claim->last_name}}</td>  
                                                    @else
                                                        <td>Please fill in the details</td>
                                                    @endisset
                                                    <td>{{ $claim->item_numbers }}</td>
                                                    <td>{{ $claim->location ? $claim->location->location : "" }}</td>
                                                    <td><a class="btn-sm btn-success" href="{{ url('claim_details', $claim['id'])}}">Input Claim Details</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Specialist Name</th>
                                            <th>Date of Service</th>
                                            <th>Patient Name</th>
                                            <th>Item Numbers</th>
                                            <th>Location</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of Processed Claim table -->
        </div>
    </div>
@stop
@section('foot')
    <script src="{{ URL::asset('js/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('js/datatable/data-table-act.js') }}"></script>
@stop

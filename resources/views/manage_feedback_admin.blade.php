@extends('layouts.dashboard')
@section('title', 'Manage User Admin')
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
                        <h2 class="pageheader-title">Manage Feedback</h2>
                        <p>Review all messages from the users</p>
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
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">User Feedbacks</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="users-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        foreach ($specialists as $specialist)
                                        <tr>
                                            <td> $specialist->specialist->first_name   $specialist->specialist->last_name </td>
                                            <td> Message</td>
                                        </tr>
                                        endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
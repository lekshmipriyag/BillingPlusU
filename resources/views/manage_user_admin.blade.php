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
                        <h2 class="pageheader-title">Manage User</h2>
                        <p>You are currently manage<span class="counter" style="color:#3F51B5;"> count </span>users: <span class="counter" style="color:#3F51B5;"> count </span> processors & <span class="counter" style="color:#3F51B5;"> count </span> specialists</p>
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
                        <div class="card-header">User Table List</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="users-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile Number</th>
                                            <th>Post Code</th>
                                            <th>Profession</th>
                                            <th>Account Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        foreach ($specialists as $specialist)
                                        <tr>
                                            <td> $specialist->specialist->first_name   $specialist->specialist->last_name </td>
                                            <td> $specialist->specialist->email </td>
                                            <td> $specialist->specialist->mobile </td>
                                            <td> $specialist->specialist->postcode </td>
                                            <td> $specialist->specialist->profession </td>
                                            <td> acc type</td>
                                            <td><a href="#" class="btn btn-default btn-sm"><i class="fas fa-external-link-alt"></i> View</a>
                                            <a href="#" class="btn btn-default btn-sm" data-token="#" data-toggle="modal" data-target="#delUserModal" data-delete data-confirmation="notie"> <i class="fas fa-times-circle"></i> Delete</a></td>
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
        <!-- Delete User Modal -->
        <form action="" method="POST">
            @csrf
            <div class="modal fade" id="delUserModal" tabindex="-1" role="dialog" aria-labelledby="delUserModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="delUserModalLabel">Delete Users</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure? Once you delete, the user account will be removed<p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-rounded btn-success" type="submit">Delete</button>
                            <a href="#" class="btn btn-rounded btn-outline-dark" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
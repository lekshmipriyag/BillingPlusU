@extends('layouts.dashboard')
@section('title', 'Dashboard Processor')
@section('body')
    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">BillingPlusU for Processor</h2>
                        <p>You are currently manage<span class="counter" style="color:#3F51B5;"> {{ count($active_specialist_num) }} </span>specialists</p>
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
                    <div class="page-section" id="overview">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h2>As a processor,</h2>
                                <p class="lead">You can manage and process specialists' claims, to start:</p>
                                <ul class="list-unstyled arrow">
                                    <li>Invite registered specialist by clicking "New Specialist" button, after invitation sent the status shows as "Pending"</li>
                                    <li>Once the specialist accept the invitation, you will be able to manage their claims</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-actions">
                        <a href="#" class="btn btn-rounded btn-success" data-toggle="modal" data-target="#addSpecialistModal"><i class="fas fa-user-plus"></i> New Specialist</a>
                        <a href="{{ url('manage_all_claim') }}" class="btn btn-rounded btn-secondary"><i class="fas fa-file-medical"></i> See All Claims</a>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header">Manage Specialists</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="users-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($specialists as $specialist)
                                            <form id="specialistForm{{ $specialist['id'] }}" action="{{ url('delete_specialist') }}" method="POST">
                                                @csrf
                                                <tr>
                                                    <td>{{ $specialist->specialist->first_name }} {{ $specialist->specialist->last_name }}</td>
                                                    <td>{{ $specialist->specialist->email }}</td>
                                                    @if ($specialist['status'] == "Active")
                                                        <td><span class="badge badge-success badge-pill pull-right">{{ $specialist['status'] }}</span></td>
                                                    @else
                                                        <td><span class="badge badge-primary badge-pill pull-right">{{ $specialist['status'] }}</span></td>
                                                    @endif
                                                    <td>
                                                        <a href="{{ url('manage_claim', $specialist->specialist->id) }}" class="btn btn-default btn-sm"><i class="fas fa-external-link-alt"></i> View</a>
                                                        <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#deleteModal{{ $specialist['id'] }}"><i class="fas fa-times-circle"></i> Delete</a>
                                                    </td>
                                                </tr>
                                                <input type="hidden" name="specialist" value="{{ $specialist->specialist->id }}">
                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteModal{{ $specialist['id'] }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $specialist['id'] }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalLabel{{ $specialist['id'] }}">Removing the specialist</h5>
                                                                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this item?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="submit">Delete</button>
                                                                <a href="#" class="btn btn-primary" data-dismiss="modal">Cancel</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end of Modal -->
                                            </form>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ url('add_specialist') }}" method="POST">
            @csrf
            <div class="modal fade" id="addSpecialistModal" tabindex="-1" role="dialog" aria-labelledby="addSpecialistModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addSpecialistModalLabel">Invite New Specialists</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="inputEmail">Input the Specialists' Email address</label>
                                <input id="inputEmail" name="email" type="email" placeholder="email@example.com" class="form-control">
                                <p>We will send email to the specialist, once they accept, you will be able to manage their claim!</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-rounded btn-success" type="submit">Send</button>
                            <a href="#" class="btn btn-rounded btn-outline-dark" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

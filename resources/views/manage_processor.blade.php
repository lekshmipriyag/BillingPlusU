@extends('layouts.dashboard')
@section('title', 'Manage Processor')
@section('body')
<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Manage Processor</h2>
                    <p>Get the right person to process your claims </p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">BillingPlusU for Specialist</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">Processor
                    </div>
                    <div class="card-body">
                        @include('flash-message')
                        @if (count($has_processor) < 1) <div class="noprocessor text-center">
                            <p style="color:blue;">No Processor found</p>
                            <i>To get assistance from the processor, get your processor to send you a request.
                                While waiting the processor on board, you can always manage your own claim.</i>
                    </div>
                    @else
                    <ul class="list-group mb-4">
                        @foreach ($active_processors as $active_processor)
                        <a class="list-processor" href="#" data-toggle="modal" data-target="#activeProcessorModal{{ $active_processor['id'] }}">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div style="float: left; padding:2px,10px,2px,10px;">
                                    <span class="fas fa-user-md fa-4x mr-4"></span>
                                </div>
                                <div style="float: left;">
                                    <p>{{ $active_processor->processor->first_name }} {{ $active_processor->processor->last_name }}</p>
                                    <p>Request sent on: {{ $active_processor['updated_at'] }}</p>
                                </div>
                                <div class="badge">
                                    <span class="badge badge-success badge-pill pull-right">{{ $active_processor['status'] }}</span>
                                </div>
                            </li>
                        </a>
                        <form method="POST">
                            @csrf
                            <div class="modal fade" id="activeProcessorModal{{ $active_processor['id'] }}" tabindex="-1" role="dialog" aria-labelledby="activeProcessorModalLabel{{ $active_processor['id'] }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="activeProcessorModalLabel{{ $active_processor['id'] }}">Unassigned Processor</h5>
                                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Do you wish to unassign the processor?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="processor" value="{{ $active_processor->processor->id }}">
                                            <input type="hidden" name="status" value="2">
                                            <button class="btn btn-rounded btn-dark" type="submit">Unassign</button>
                                            <button class="btn btn-rounded btn-outline-dark" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endforeach
                        @foreach ($pending_processors as $pending_processor)
                        <a class="list-processor" href="#" data-toggle="modal" data-target="#pendingProcessorModal{{ $pending_processor['id'] }}">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div style="float: left; padding:2px,10px,2px,10px;">
                                    <span class="fas fa-user-md fa-4x mr-4"></span>
                                </div>
                                <div style="float: left;">
                                    <p>{{ $pending_processor->processor->first_name }} {{ $pending_processor->processor->last_name }}</p>
                                    <p>Request sent on: {{ $pending_processor['updated_at'] }}</p>
                                </div>
                                <div class="badge">
                                    <span class="badge badge-primary badge-pill pull-right">Activate</span>
                                </div>
                            </li>
                        </a>
                        <form method="POST">
                            @csrf
                            <div class="modal fade" id="pendingProcessorModal{{ $pending_processor['id'] }}" tabindex="-1" role="dialog" aria-labelledby="pendingProcessorendingModalLabel{{ $pending_processor['id'] }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="pendingProcessorendingModalLabel{{ $pending_processor['id'] }}">Respond to Processor Invitation</h5>
                                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Allowing the processor to manage your claim will lift up a bit of your administration burden.
                                                But rest assured, you can always unassign the processor anytime and process your own claim</p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="processor" value="{{ $pending_processor->processor->id }}">
                                            <input type="hidden" id="pendingStatus{{ $pending_processor['id'] }}" name="status" value="3">
                                            <button class="btn btn-rounded btn-dark" type="submit" onclick="pendingProcessor('pendingStatus{{ $pending_processor['id'] }}')">Allow</button>
                                            <button class="btn btn-rounded btn-outline-dark" type="submit">Decline</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop
@section('foot')
<script>
    function pendingProcessor(id) {
        document.getElementById(id).value = "1";
    }

</script>
@stop

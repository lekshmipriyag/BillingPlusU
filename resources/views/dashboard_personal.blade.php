@extends('layouts.dashboard')
@section('title', 'Dashboard Personal')
@section('head')
<link rel="stylesheet" href="{{ URL::asset('css/notika-custom-icon.css') }}">
<link rel="stylesheet" href="{{ URL::asset('js/select/bootstrap-select.css') }}">
@stop
@section('body')
<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Welcome to BillingPlusU, <font color="#3F51B5">{{ $name }}</font>
                    </h2>
                    <p>You have submitted <span class="counter" style="color:#3F51B5;">{{ $count }}</span> claims this month</p>
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
        @include('flash-message')
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-actions">
                    <a href="{{ url('add_new_claim') }}" class="btn btn-rounded btn-success"><i class="fas fa-plus"></i> Add New Claim</a>
                    <a href="{{ url('manage_processor') }}" class="btn btn-rounded btn-outline-dark">Manage Processor</a>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">Claims
                        <button class="btn btn-xs bg-transparent" data-container="body" data-toggle="tooltip" data-placement="right" title="Manage your claim by clicking the claim item"><span class="far fa-question-circle mr-3"></span></button>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-4">
                            @foreach ($claims as $claim)
                            <a class="list-claim" href="#" data-toggle="modal" data-target="#claimModal{{$claim['id']}}">
                                <li class="list-group-item d-flex flex-start align-items-center mb-4">
                                    <div style="float: left; padding:2px,10px,2px,10px;">
                                        <img src="{{ url('image', ['claim_id' => $claim->id, 'filename' => $claim->image_path]) }}" hspace="20" style="width:75px;height:75px;" alt="" id="itemImg">
                                    </div>
                                    <div style="float: left;">
                                        <p>Claim #{{$claim['id']}}</p>
                                        @if ($claim['status'] == "Processed")
                                        <p>{{$claim->title}} {{$claim->first_name}} {{$claim->last_name}}</p>
                                        @elseif(isset($claim->first_name))
                                        <p>{{$claim->title}} {{$claim->first_name}} {{$claim->last_name}}</p>
                                        @else
                                        <p>Patient Name</p>
                                        @endif
                                        <p>{{date('d-m-Y', strtotime($claim['date_of_services']))}}</p>
                                    </div>
                                    <div style="float: none; clear: both;"></div>
                                </li>
                            </a>
                            <div class="modal fade" id="claimModal{{$claim['id']}}" role="dialog">
                                <div class="modal-dialog modals-default">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Claim Details</h5>
                                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <div class="contact-inner">
                                                <div class="contact-map widget-contact-map text-center">
                                                    <img src="{{ url('image', ['claim_id' => $claim->id, 'filename' => $claim->image_path]) }}" alt="" style="width:150px;height:150px;"></img>
                                                </div>
                                                <div class="align-left text-justify">
                                                    <hr>
                                                    <ul class="list-unstyled">
                                                        <li><i class="notika-icon notika-star"></i> Status : {{$claim['status']}}</li>
                                                        <li><i class="notika-icon notika-calendar"></i> Date of Service : {{date('d-m-Y', strtotime($claim['date_of_services']))}}</li>
                                                        <li><i class="notika-icon notika-map"></i> Location : {{$claim->location->location}}</li>
                                                        <li><i class="notika-icon notika-support"></i> Referring Doctor : {{$claim->doctor->title}} {{$claim->doctor->first_name}} {{$claim->doctor->last_name}}</li>
                                                        <li><i class="notika-icon notika-star"></i> Item Number : {{$claim['item_numbers']}}</li>
                                                        <li><i class="notika-icon notika-edit"></i> Notes : {{$claim['notes']}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ url('rebill_claim') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="claim" value="{{ $claim['id'] }}">
                                                <a class="btn btn-rounded btn-outline-dark" href="#" data-toggle="modal" data-target="#rebillModal{{$claim['id']}}">Re-bill</a>
                                            </form>
                                            <form action="{{ url('discharge_claim') }}" method="POST" onsubmit="javascript: return dischargeClaim();">
                                                @csrf
                                                <input type="hidden" name="claim" value="{{ $claim['id'] }}">
                                                <button type="submit" class="btn btn-rounded btn-outline-danger btn-discharge">Discharge</button>
                                            </form>
                                            {{-- <a href="{{ url('manage_claim') }}" class="btn btn-rounded btn-success">Process Claim</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <form action="{{ url('rebill_claim') }}" method="POST">
                                @csrf
                                <div class="modal fade" id="rebillModal{{$claim['id']}}" role="dialog">
                                    <div class="modal-dialog modal-dialog-default">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Rebill</h5>
                                                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <div class="contact-inner">
                                                    <div class="contact-map widget-contact-map text-center">
                                                        <img src="{{ url('image', ['claim_id' => $claim->id, 'filename' => $claim->image_path]) }}" alt="" style="width:150px;height:150px;"></img>
                                                    </div>
                                                    <hr>
                                                    <div class="align-left text-justify">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                                                                <label for="date_of_service{{$claim['id']}}"><i class="notika-icon notika-calendar"></i><small> Date of Service</small></label>
                                                                <div class="form-group">
                                                                    <input id="date_of_service{{ $claim['id'] }}" type="date" data-date-format="DD MMMM YYYY" class="form-control" onchange="checkInputs()" max=<?php echo date('Y-m-d'); ?> name="date_of_services" required style=" height:35px;" value="<?php echo date('Y-m-d'); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                                                                <label for="item_numbers{{$claim['id']}}"><i class="notika-icon notika-star"></i><small> Select Item Number</small></label>
                                                                <div class="form-group" id="item_numbers{{$claim['id']}}">
                                                                    <select class="selectpicker" data-dropup-auto="false" multiple name="item_numbers[]" onchange="checkInputs()">
                                                                        <optgroup label="Item Number List">
                                                                            @foreach ($item_numbers as $item_number)
                                                                            <option value="{{$item_number['item_numbers']}}">{{$item_number['item_numbers']}}</option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
                                                                <label for="new_item_numbers{{$claim['id']}}"><small><b>OR</b> Input New Item Number</small></label>
                                                                <div class="form-group" id="new_item_numbers{{$claim['id']}}">
                                                                    <input name="new_item_numbers" id="newitemnumber{{$claim['id']}}" type="text" class="form-control" placeholder="Ex: 13,63,43" value="{{ Session::get('new_item_numbers') }}" onchange="checkInputs({{$claim['id']}})">
                                                                </div>
                                                                <div id="error_text{{$claim['id']}}" style="display: none;">
                                                                    <span style="color: #800000;">Please input only number and comma as separator</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <ul class="list-unstyled">
                                                        <li><i class="notika-icon notika-support"></i> Referring Doctor : {{$claim->doctor->title}} {{$claim->doctor->first_name}} {{$claim->doctor->last_name}}</li>
                                                        <li><i class="notika-icon notika-map"></i> Location : {{$claim->location->location}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="claim" value="{{ $claim['id'] }}">
                                                <button type="submit" class="btn btn-rounded btn-success" syle="margin:auto;">Re-bill</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('foot')
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        })
    })

    function isNotEmpty(str) {
        return !(!str.trim().length);
    }

    function checkInputs(id) {
        var error_text = document.getElementById("error_text" + id);
        var newitemnumber = isNotEmpty(document.getElementById("newitemnumber" + id).value);
        if (newitemnumber && !document.getElementById("newitemnumber" + id).value.match(/^(\d+)(,*\d+)*$/g)) {
            error_text.style.display = "block";
        } else {
            error_text.style.display = "none";
        }
    }

    function dischargeClaim() {
        return confirm("Are you sure?");
    }

</script>
<script src="{{ URL::asset('js/select/bootstrap-select.js') }}"></script>
@stop

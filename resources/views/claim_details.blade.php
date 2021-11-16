@extends('layouts.dashboard')
@section('title', 'Input/Update Claim Detail')
@section('head')
<link rel="stylesheet" href="{{ URL::asset('css/notika-custom-icon.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/inputclaimcss/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/cropper.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/darkroom.css') }}">
@stop

@section('body')
<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Input/Update Patient Detail</h2>
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
        <form action="{{ url('update_claim', $claim->id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <h3>Claim Details</h3>
                                <hr>
                            </div>
                            <label for="input_patient_name"><i class="fas fa-user"></i> <b>Patient Name</b></label>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="form-control" id="title" name="title" style=" height:35px;" onchange="if(this.options[this.selectedIndex].value=='customOption'){
                                                toggleField(this,this.nextSibling);
                                                this.selectedIndex='0';
                                            }">
                                            <option value="">Select Title</option>
                                            @foreach ($titles as $title)
                                            <option value="{{ $title }}" @if ($claim->title == $title) selected @endif>{{ $title }}</option>
                                            @endforeach
                                            <option value="customOption">Input Title</option>
                                        </select><input name="browser" style="display:none;" disabled="disabled" onblur="if(this.value==''){toggleField(this,this.previousSibling);}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label for="first_name">First Name <b>(Required)</b></label>
                                    <input id="first_name{{ $claim['id'] }}" name="first_name" type="text" placeholder="First Name" class="form-control" value="{{ $claim['first_name'] }}" required style=" height:35px;">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label for="last_name">Last Name</label>
                                    <input id="last_name{{ $claim['id'] }}" name="last_name" type="text" placeholder="Last Name" class="form-control" value="{{ $claim['last_name'] }}" style=" height:35px;">
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <label for="input_item_number"><i class="fas fa-star"></i> <b>Item Number <b>(Required)</b></b></label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="item_number" placeholder="Item Number" name="item_numbers" value="{{ $claim->item_numbers }}" required style=" height:35px;">
                                    </div>
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <label for="input_att_doctor"><i class="fas fa-user-md"></i> <b>Attendant Doctor <b>(Required)</b></b></label>
                                    <div class="form-group">
                                        <label for="input_att_doctor"><b>Dr. {{ $claim->user->first_name }} {{ $claim->user->last_name }}</b></label>
                                    </div>
                                </div>
                            </div><br>

                            <label for="input_ref_doctor"><i class="fas fa-user-md"></i> <b>Referred by</b></label>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="form-control" id="ref_doctor" name="ref_doctor" required style=" height:35px;">
                                            <option value="">Select from Existing Records</option>
                                            <optgroup label="Referring Doctor List">
                                                @foreach ($doctors as $doctor)
                                                <option @if ($claim->doctor && $claim->doctor->id == $doctor->id) selected @endif value="{{$doctor['id']}}">{{$doctor['title']}} {{$doctor['first_name']}} {{$doctor['last_name']}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <p> --------- OR ---------- </p>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label for="doctor_title">Title</label>
                                    <div class="form-group">
                                        <select class="form-control" id="doctor_title" name="ref_doctor_title" style=" height:35px;">
                                            <option value="">Select Title</option>
                                            @foreach ($titles as $title)
                                            <option value="{{ $title }}">{{ $title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label for="doctor_first_name">First Name</label>
                                    <input id="doctor_first_name{{ $claim['id'] }}" name="ref_doctor_first_name" type="text" placeholder="First Name" class="form-control" value="" style=" height:35px;">
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label for="doctor_last_name">Last Name</label>
                                    <input id="doctor_last_name{{ $claim['id'] }}" name="ref_doctor_last_name" type="text" placeholder="Last Name" class="form-control" value="" style=" height:35px;">
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label for="referral_length">Referral Length</label>
                                    <div class="form-group">
                                        <select class="form-control" id="referral_length" name="referral_length" style=" height:35px;">
                                            <option value="">Referral Length</option>
                                            <option value="">Select</option>
                                            <option value="">12 month</option>
                                            <option value="">3 month</option>
                                            <option value="">Don't know</option>
                                        </select>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <label for="referred_on">Referred On</label>
                                    <input id="reffered_on{{ $claim['id'] }}" name="referral_date" type="text" placeholder="Referred On (DD/MM/YYYY)" class="form-control" value="{{ $claim->referral_date ? $claim->referral_date->format('d/m/Y') : "" }}" style=" height:35px;">
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                                    <label for="input_date_of_service"><i class="fas fa-calendar-alt"></i> <b> Date of Service</b></label>
                                    <input id="date_of_service{{ $claim['id'] }}" name="date_of_services" type="text" placeholder="Date of Service (DD/MM/YYYY)" class="form-control" value="{{ $claim->date_of_services ? $claim->date_of_services->format('d/m/Y') : "" }}" style=" height:35px;">
                                </div>
                            </div><br>

                            <label for="location"><i class="fas fa-map-marker"></i> <b>Location of Service</b></label>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="form-control" id="location_data" name="location" value="" required style=" height:35px;">
                                            <option value="">Select from Existing Records</option>
                                            @foreach ($locations as $location)
                                            <option @if ($claim->location && $claim->location->id == $location->id) selected @endif value="{{$location['id']}}">{{$location['location']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <p> --------- OR ---------- </p>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <input id="new_location{{ $claim['id'] }}" name="new_location" type="text" placeholder="New Location" class="form-control" value="" style=" height:35px;">
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="input_notes"><i class="fas fa-notes-medical"></i> <b>Notes</b></label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3">{{$claim->notes}}</textarea>
                                    </div>
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                                    <label for="input_claim_status"><i class="fas fa-clipboard-check"></i> <b> Claim Status</b></label>

                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" id="status" name="status" value="1" onclick="statusCheck();" @if ($claim->status == "Processed") checked @endif class="custom-control-input"><span id="status_text" class="custom-control-label">{{$claim->status}}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="row">
                                    <a href="@if (Session::get('user_id') != null) {{ url('manage_claim').'/'.Session::get('user_id') }} @else {{ url('manage_all_claim') }} @endif" class="btn btn-rounded btn-outline-dark">See list of the claim</a>
                                    <button type="submit" id="submit" class="btn btn-rounded btn-success">@if ($claim->status == "Processed") Submit @else Update @endif</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                    <div class="card">
                        <div class="card-body img-cont">
                            <div class="text-center">
                                <h3>Hospital Sticker</h3>
                                <hr>
                            </div>
                            <img id="sticker" class="preview-sticker" src="{{ url('image', ['claim_id' => $claim->id, 'filename' => $claim->image_path]) }}" alt="Picture">
                            <input id="stickerData" name="sticker" type="hidden" value="empty,empty">
                            <a id="editImageButton" href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#editImage">Edit Image</a>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div id="editImage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Edit Image</h5>
                                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </a>
                            </div>
                            <div class="modal-body">
                                <div class="figure-wrapper">
                                    <figure id="target" class="image-container target">
                                        <img src="{{ url('image', ['claim_id' => $claim->id, 'filename' => $claim->image_path]) }}" alt="Picture">
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of Modal -->
            </div>
        </form>
    </div>
</div>


@stop
@section('foot')
<script src="{{ URL::asset('js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('js/datatable/data-table-act.js') }}"></script>
<script src="{{ URL::asset('js/cropimg/cropper.min.js') }}"></script>
<script src="{{ URL::asset('js/cropimg/cropper-int.js') }}"></script>
<script src="{{ URL::asset('js/fabric.js') }}"></script>
<script src="{{ URL::asset('js/darkroom.js') }}"></script>

<script>
    function toggleField(hideObj,showObj){
        hideObj.disabled=true;		
        hideObj.style.display='none';
        showObj.disabled=false;	
        showObj.style.display='inline';
        showObj.focus();
    }

    function statusCheck() {
        if (document.getElementById('status').checked) {
            document.getElementById('status_text').innerHTML = "Processed";
            document.getElementById('submit').innerHTML = "Submit";
        } else {
            document.getElementById('status_text').innerHTML = "Waiting for Billing";
            document.getElementById('submit').innerHTML = "Update";
        }
    }

    $('#editImageButton').click(function () {
        var dkrm = new Darkroom($("#target").children()[0], {
            // Size options
            minWidth: 50,
            minHeight: 50,
            maxWidth: 600,
            maxHeight: 500,
            ratio: 4/3,
            backgroundColor: '#000',

            // Plugins options
            plugins: {
                //save: false,
                crop: {
                    quickCropKey: 67, //key "c"
                    //minHeight: 50,
                    //minWidth: 50,
                    //ratio: 4/3
                },
                save: {
                    callback: function() {
                        this.darkroom.selfDestroy(); // Cleanup
                        var newImage = dkrm.canvas.toDataURL();
                        $('#sticker').attr('src', newImage);
                        $('#stickerData').val(newImage);
                        $('#editImage').modal('hide');
                    }
                },
            },
            // Post initialize script
            initialize: function() {
                var cropPlugin = this.plugins['crop'];
                // cropPlugin.selectZone(170, 25, 300, 300);
                cropPlugin.requireFocus();
            }
        });
    })

</script>
@stop

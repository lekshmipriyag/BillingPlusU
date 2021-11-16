@extends('layouts.dashboard')
@section('title', 'Add New Claim')
@section('head')
<link rel="stylesheet" href="{{ URL::asset('css/inputclaimcss/css/notika-custom-icon.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/cropper.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('js/select/bootstrap-select.css') }}">
@stop
@section('body')
<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Add New Claim</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('add_new_claim') }}" class="breadcrumb-link">BillingPlusU for Specialist</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        @include('flash-message')
        <form method="POST" enctype="multipart/form-data" onsubmit="javascript: return processInput();">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="docs-preview clearfix">
                        <div class="preview-img-pro-ad">
                            <div class="maincrop-img">
                                <div class="image-crp-int text-center">
                                    <div class="img-preview img-preview-custom">
                                    </div>
                                </div>
                                <div class="image-crp-img text-center">
                                    <div class="btn-group images-cropper-pro">
                                        <label title="Upload image file" for="inputImage" class="btn btn-rounded btn-success btn-lg img-cropper-cp">
                                            <input type="file" class="sr-only" id="inputImage" capture="camera" name="image_file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff" onchange="readURL(this);"><i class="fa fa-camera" style="font-size:30px;"></i><br>Capture the Hospital Sticker
                                        </label>
                                    </div>
                                </div>
                                <p class="text-center">A clear picture of the hospital sticker makes the claim process easier & faster</p>
                                <br>
                                <div class="image-prev text-center">
                                    <img id="blah" src="#" alt="" width="200" height="200" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-example-wrap">
                        <div class="cmp-tb-hd text-center">
                            <hr>
                            <br>
                            <h3>Claim Details</h3>
                            <p>Please input your claim details here</p>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                                    <div class="form-group ic-cmp-int">
                                        <div class="form-ic-cmp">
                                            <i class="notika-icon notika-calendar"></i>
                                        </div>
                                        <div class="nk-int-mk sl-dp-mn sm-res-mg-t-10">
                                            <label>Date of Service</label>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <input id="date_of_services" type="date" data-date-format="DD MMMM YYYY" class="form-control" onchange="checkInputs()" max=<?php echo date('Y-m-d'); ?> name="date_of_services" required style=" height:35px;" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <label class="label-desc" for="description">Date of Service cannot be future date</label>
                                    </div>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-map"></i>
                                    </div>
                                    <div class="nk-int-mk sl-dp-mn sm-res-mg-t-10">
                                        <label>Location</label>
                                    </div>
                                    <div class="form-group row" id="location">
                                        <div class="col-lg-12">
                                            <select id="location_data" class="selectpicker show-tick form-control" data-dropup-auto="false" data-live-search="true" name="location" onchange="checkInputs()">
                                                <option value="">Select Location</option>
                                                @foreach ($recent_locations as $recent_location)
                                                <option value="{{$recent_location->id}}" data-subtext="most recent">{{$recent_location->location}}</option>
                                                @endforeach
                                                <optgroup label="All Location" data-subtext="">
                                                    @foreach ($locations as $location)
                                                    @if (session('location') == $location['id'] || session('rebill_location') == $location['id'])
                                                    <option selected value="{{$location['id']}}">{{$location['location']}}</option>
                                                    @else
                                                    <option value="{{$location['id']}}">{{$location['location']}}</option>
                                                    @endif
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="new_location" style="display: none">
                                        <input name="new_location" type="text" id="newlocation" class="form-control is-valid" placeholder="Type new location here" value="{{ Session::get('new_location') }}" onchange="locationStateChange()">
                                        <span id="valid-icon" class="notika-icon notika-checked greenspan" style="display:none;"></span>
                                        <div id="valid-feedback" class="valid-feedback" style="display:none;">After claim submitted, new location will be updated on the list</div>
                                        <br>
                                    </div>
                                    <a class="btn btn-primary btn-xs" href='javascript:;' id="location-change" onclick='newLocation()'><i class="fas fa-exclamation-circle"></i> Click here to input new location</a>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-support"></i>
                                    </div>
                                    <div class="nk-int-mk sl-dp-mn sm-res-mg-t-10">
                                        <label>Referring Doctor</label>
                                    </div>
                                    <div class="form-group row" id="doctor">
                                        <div class="col-lg-12">
                                            <select id="doctor_data" class="selectpicker show-tick form-control" data-dropup-auto="false" data-live-search="true" name="doctor" value="{{ Session::get('doctor') }}" onchange="checkInputs()">
                                                <option value="">Select Referring Doctor</option>
                                                @foreach ($recent_doctors as $recent_doctor)
                                                <option value="{{$recent_doctor->id}}" data-subtext="most recent">{{$recent_doctor->title}} {{$recent_doctor->first_name}} {{$recent_doctor->last_name}}</option>
                                                @endforeach
                                                <optgroup label="Referring Doctor List">
                                                    @foreach ($doctors as $doctor)
                                                    @if (session('doctor') == $doctor['id'] || session('rebill_doctor') == $doctor['id'])
                                                    <option selected value="{{$doctor['id']}}">{{$doctor['title']}} {{$doctor['first_name']}} {{$doctor['last_name']}}</option>
                                                    @else
                                                    <option value="{{$doctor['id']}}">{{$doctor['title']}} {{$doctor['first_name']}} {{$doctor['last_name']}}</option>
                                                    @endif
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="new_doctor" style="display: none">
                                        <input name="new_doctor_first_name" id="new_doctor_first_name" type="text" class="form-control is-valid" placeholder="Type First Name here" value="{{ Session::get('new_doctor_first_name') }}" onchange="doctorStateChange()">
                                        <span id="valid-icon-1" class="notika-icon notika-checked greenspan" style="display:none;"></span>
                                        <input name="new_doctor_last_name" id="new_doctor_last_name" type="text" class="form-control is-valid" placeholder="Type Last Name here" value="{{ Session::get('new_doctor_last_name') }}" onchange="doctorStateChange()">
                                        <span id="valid-icon-2" class="notika-icon notika-checked greenspan" style="display:none;"></span>
                                        <input name="new_doctor_provider_number" id="new_doctor_provider_number" type="text" class="form-control is-valid" placeholder="Type Provider Number here" value="{{ Session::get('new_doctor_provider_nummber') }}" onchange="doctorStateChange()">
                                        <span id="valid-icon-3" class="notika-icon notika-checked greenspan" style="display:none;"></span>
                                        <div id="doctor-valid-feedback" class="valid-feedback" style="display:none;">After claim submitted, new referring doctor will be updated on the list</div>
                                        <br>
                                    </div>
                                    <a class="btn btn-primary btn-xs" href='javascript:;' id="doctor-change" onclick='newDoctor()'><i class="fas fa-exclamation-circle"></i> Click here to input new referring doctor</a>
                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-star"></i>
                                    </div>
                                    <div class="nk-int-mk sl-dp-mn sm-res-mg-t-10">
                                        <label>Item Number</label>
                                    </div>
                                    <input id="input_option" name="input_option" type="hidden" value="0" />
                                    <a href="#manual_inputs_button" id="manual_input_button" class="btn btn-outline-dark active" href='javascript:;' onclick='manualInputs()'>
                                        <p id="manual_inputs_button">Manual Inputs</p>
                                    </a>
                                    <a href="#favorite_list_button" id="fav_list_button" class="btn btn-outline-dark" href='javascript:;' onclick='favoriteLists()'>
                                        <p id="favorite_list_button">Favorite List</p>
                                    </a>
                                    <div id="manual_inputs" style="display: block; margin-top: 1em;">
                                        <div class="form-group" id="item_numbers">
                                            <select class="selectpicker" data-dropup-auto="false" multiple id="itemnumber" name="item_numbers[]" onchange="checkInputs()">
                                                <optgroup label="Item Number List">
                                                    @foreach ($item_numbers as $item_number)
                                                    <option value="{{$item_number['item_numbers']}}">{{$item_number['item_numbers']}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div id="new_item_numbers">
                                            <input name="new_item_numbers" id="newitemnumber" type="text" class="form-control" placeholder="Can't find the item number? Type here!" value="{{ Session::get('new_item_numbers') }}" onchange="checkInputs()">
                                        </div>
                                        <div id="error_text" style="display: none;">
                                            <span style="color: #800000;">Please input only number and comma as separator</span>
                                        </div>
                                    </div>
                                    <div id="favorite_lists" style="display: none; margin-top: 1em;">
                                        <div class="card">
                                            <h5 class="card-header">Select Your Favorite List</h5>
                                            <div class="card-body">
                                                <table class="table table-bordered centeredContent multiSelectFunctionality" id="table">
                                                    <tbody>
                                                        @foreach ($favorite_lists as $favorite_list)
                                                        <tr id="row-{{$loop->iteration}}">
                                                            <td>
                                                                @if ($loop->iteration == 1)
                                                                <button type="button" class="btn btn-plus fa fa-plus" title="Add Row"></button>
                                                                @else
                                                                <button type="button" class="btn btn-minus fa fa-minus" title="Remove Row"></button>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <input id="favorite_list_name_{{$loop->iteration}}" name="favorite_list_name[]" class="form-control searchItem" placeholder="Type Favorite List Name" value="{{$favorite_list->favorite_list_name}}" />
                                                            </td>
                                                            <td>
                                                                <select class="selectpicker" data-dropup-auto="false" multiple id="item_numbers_{{$loop->iteration}}">
                                                                    <optgroup label="Item Number List">
                                                                        @foreach ($item_numbers as $item_number)
                                                                        <option value="{{$item_number['item_numbers']}}">{{$item_number['item_numbers']}}</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                </select>
                                                                <input id="favorite_list_value_{{$loop->iteration}}" name="favorite_list_value[]" type="hidden" value="{{$favorite_list->item_numbers}}" />
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="favorite_list_checkbox_{{$loop->iteration}}" onchange="checkInputs()">
                                                                <input type="hidden" id="checkbox_value_{{$loop->iteration}}" name="favorite_list_checkbox_value[]">
                                                                <label for="favorite_list_{{$loop->iteration}}">Use this favorite list</label>
                                                            </td>
                                                            <td>
                                                                <input id="favorite_list_new_value_{{$loop->iteration}}" name="favorite_list_new_value[]" type="text" class="form-control" placeholder="Additional item number" disabled>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group ic-cmp-int">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-edit"></i>
                                    </div>
                                    <div class="nk-int-mk sl-dp-mn sm-res-mg-t-10">
                                        <label>Notes</label>
                                    </div>
                                    <textarea class="form-control" rows="5" placeholder="Additional comment" name="notes">{{ Session::get('notes') }}</textarea>
                                </div>
                                <br>
                                <div class="form-example-int mg-t-15 text-center">
                                    <button class="btn btn-rounded btn-success" id="submitBtn" type="submit">Submit</button>
                                    <a class="btn btn-rounded btn-danger" href="{{ url('dashboard_personal') }}" role="button">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
@section('foot')
<script src="{{ URL::asset('js/cropimg/cropper.min.js') }}"></script>
<script src="{{ URL::asset('js/cropimg/cropper-int.js') }}"></script>
<script src="{{ URL::asset('js/select/bootstrap-select.js') }}"></script>
<script>
    document.getElementById('submitBtn').disabled = true;

    function newLocation() {
        var location = document.getElementById("location");
        var new_location = document.getElementById("new_location");
        var location_change = document.getElementById("location-change");
        if (location.style.display === "none") {
            location_change.innerHTML = "<span><i class='fas fa-exclamation-circle'></i> Click here to input new location</span>";
            location.style.display = "block";
            new_location.style.display = "none";
        } else {
            location_change.innerHTML = " Select location from the existing list";
            location.style.display = "none";
            new_location.style.display = "block";
        }
    }

    function newDoctor() {
        var doctor = document.getElementById("doctor");
        var new_doctor = document.getElementById("new_doctor");
        var doctor_change = document.getElementById("doctor-change");
        if (doctor.style.display === "none") {
            doctor_change.innerHTML = "<span><i class='fas fa-exclamation-circle'></i> Click here to input new referring doctor</span>";
            doctor.style.display = "block";
            new_doctor.style.display = "none";
        } else {
            doctor_change.innerHTML = " Select referring doctor from the existing list";
            doctor.style.display = "none";
            new_doctor.style.display = "block";
        }
    }

    function manualInputs() {
        var manual_input_button = document.getElementById("manual_input_button");
        var fav_list_button = document.getElementById("fav_list_button");
        var manual_inputs = document.getElementById("manual_inputs");
        var favorite_lists = document.getElementById("favorite_lists");
        var input_option = document.getElementById("input_option");
        manual_input_button.classList.add("active");
        fav_list_button.classList.remove("active");
        manual_inputs.style.display = "block";
        favorite_lists.style.display = "none";
        input_option.value = "0";
        $("[id^=item_numbers_]").each(function() {
            var pos = $(this).attr('id').split("_").pop();
            $("#favorite_list_name_" + pos).attr("required", false);
            $(this).attr("required", false);
        });
        checkInputs();
    }

    function favoriteLists() {
        var manual_input_button = document.getElementById("manual_input_button");
        var fav_list_button = document.getElementById("fav_list_button");
        var manual_inputs = document.getElementById("manual_inputs");
        var favorite_lists = document.getElementById("favorite_lists");
        var input_option = document.getElementById("input_option");
        manual_input_button.classList.remove("active");
        fav_list_button.classList.add("active");
        manual_inputs.style.display = "none";
        favorite_lists.style.display = "block";
        input_option.value = "1";
        $("[id^=item_numbers_]").each(function() {
            var pos = $(this).attr('id').split("_").pop();
            $("#favorite_list_name_" + pos).attr("required", true);
            $(this).attr("required", true);
        });
        checkInputs();
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
        checkInputs();
    }

    $("#inputImage").change(function() {
        readURL(this);
    });

    function isNotEmpty(str) {
        return !(!str.trim().length);
    }

    function validateMultipleSelect(select) {
        var number = $('option:selected', select).size();
        return (number == 0);
    }

    function locationStateChange() {
        var myInput = document.getElementById("newlocation");
        var feedback = document.getElementById("valid-feedback");
        var icon = document.getElementById("valid-icon");

        if(myInput.value.length >1) {
            feedback.style.display = "block";
            icon.style.display = "block";
        } else {
            feedback.style.display = "none";
            icon.style.display = "none";
        }
        checkInputs();
    }

    function doctorStateChange() {
        var myInputDoctorFirstName = document.getElementById("new_doctor_first_name");
        var myInputDoctorLastName = document.getElementById("new_doctor_last_name");
        var myInputDoctorProviderNumber = document.getElementById("new_doctor_provider_number");
        var icon1 = document.getElementById("valid-icon-1");
        var icon2 = document.getElementById("valid-icon-2");
        var icon3 = document.getElementById("valid-icon-3");

        var doctorfeedback = document.getElementById("doctor-valid-feedback");

        if(myInputDoctorFirstName.value.length >1) {
            icon1.style.display = "block";
        } else {
            icon1.style.display = "none";
        }

        if(myInputDoctorLastName.value.length >1) {
            icon2.style.display = "block";
        } else {
            icon2.style.display = "none";
        }

        if(myInputDoctorProviderNumber.value.length >1) {
            icon3.style.display = "block";
        } else {
            icon3.style.display = "none";
        }

        if(myInputDoctorProviderNumber.value.length >1 && myInputDoctorLastName.value.length >1 && myInputDoctorProviderNumber.value.length >1) {
            doctorfeedback.style.display = "block";
        } else {
            doctorfeedback.style.display = "none";
        }

        checkInputs();
    }

    function itemNumberStateChange() {
        var myInput = document.getElementById("new_item_numbers");
        var feedback = document.getElementById("item-number-valid-feedback");

        if(myInput.value.length >1) {
            feedback.style.display = "block";
            icon.style.display = "block";
        } else {
            feedback.style.display = "none";
            icon.style.display = "none";
        }
        checkInputs();
    }

    function checkInputs() {
        var image = (document.getElementById("inputImage").files.length != 0);
        console.log('image ' + image);
        var date_of_services = isNotEmpty(document.getElementById("date_of_services").value);
        console.log('date_of_services ' + date_of_services);
        var location_data = isNotEmpty(document.getElementById("location_data").value);
        console.log('location_data ' + location_data);
        var newlocation = isNotEmpty(document.getElementById("newlocation").value);
        console.log('newlocation ' + newlocation);
        var doctor_data = isNotEmpty(document.getElementById("doctor_data").value);
        console.log('doctor_data ' + doctor_data);
        var new_doctor_first_name = isNotEmpty(document.getElementById("new_doctor_first_name").value);
        console.log('new_doctor_first_name ' + new_doctor_first_name);
        var new_doctor_last_name = isNotEmpty(document.getElementById("new_doctor_last_name").value);
        console.log('new_doctor_last_name ' + new_doctor_last_name);
        var new_doctor_provider_number = isNotEmpty(document.getElementById("new_doctor_provider_number").value);
        console.log('new_doctor_provider_number ' + new_doctor_provider_number);
        var itemnumber = isNotEmpty(document.getElementById("itemnumber").value);
        console.log('itemnumber ' + itemnumber);
        var error_text = document.getElementById("error_text");
        var newitemnumber = isNotEmpty(document.getElementById("newitemnumber").value);
        if (newitemnumber && !document.getElementById("newitemnumber").value.match(/^(\d+)(,*\d+)*$/g)) {
            error_text.style.display = "block";
        } else {
            error_text.style.display = "none";
        }
        console.log(newitemnumber);
        var input_option = document.getElementById("input_option").value;
        console.log('input_option ' + input_option);
        var itemnumber_check = input_option == "0" ? itemnumber || newitemnumber : $("[id^=favorite_list_checkbox_]:checked").length > 0 ? true : false;
        console.log('itemnumber_check ' + itemnumber_check);
        if (image && date_of_services && (location_data || newlocation) && (doctor_data || (new_doctor_first_name && new_doctor_last_name)) && itemnumber_check) {
            document.getElementById("submitBtn").disabled = false;
            console.log('button can be click');
        } else {

            console.log('button cannot be click');
            document.getElementById("submitBtn").disabled = true;
        }
        //document.getElementById("submitBtn").disabled = false;
    }

    function processInput() {
        $("[id^=item_numbers_]").each(function() {
            var pos = $(this).attr('id').split("_").pop();
            $("#favorite_list_value_" + pos).val($(this).val().join(","));
            if ($("#favorite_list_checkbox_" + pos).prop("checked") == true) {
                $("#checkbox_value_" + pos).val("1");
            } else {
                $("#checkbox_value_" + pos).val("0");
            }
        });
        $('[id^=favorite_list_new_value_]').prop('disabled', false);
    }

</script>
<script>
    var counter = $("[id^=item_numbers_]").length;
    $("[id^=item_numbers_]").each(function() {
        $(this).selectpicker('val', $("#favorite_list_value_" + $(this).attr('id').split("_").pop()).val().split(","));
    });
    $(".btn-minus").each(function() {
        $(this).click(function() {
            deleteRow(this);
        });
    });
    $('[id^=favorite_list_checkbox_]').click(function() {
        $('[id^=favorite_list_checkbox_]').not(this).prop('checked', false);
        $('[id^=favorite_list_new_value_]').prop('disabled', true);
        if ($(this).is(":checked")) {
            $('#favorite_list_new_value_' + $(this).attr('id').split("_").pop()).prop('disabled', false);
        }
    });

    function makeRow($obj) {
        $obj = $obj.length ? $obj : $("#table tbody");
        counter++;
        if (counter > 7) {
            $(".btn-plus").button("disable");
            counter = 7;
            return;
        } else {
            var b = $obj.find("tr:first");
            $trLast1 = $obj.find("tr:last");
            $trNew = $("<tr>", {
                id: "row-" + counter
            });
            var count = 0;
            b.find("td").each(function() {
                if (count == 2) {
                    $trNew.append("<td>" + $(this).find("select").prop('outerHTML') + $(this).find("[id^=favorite_list_value]").prop('outerHTML') + "</td>");
                } else {
                    $(this).clone().appendTo($trNew);
                }
                count++;
            });
            $trNew.find(".btn-plus").remove();
            $trNew.find("td:first").append($("<button>", {
                type: "button"
                , class: "btn btn-minus fa fa-minus"
                , title: "Remove Row"
            }).button({
                icon: "ui-icon-minus"
            }).click(function() {
                deleteRow(this);
            }));
            $trNew.find("select").attr("id", "item_numbers_" + counter).selectpicker('val', []);
            $trNew.find("[id^=favorite_list_value]").attr("id", "favorite_list_value_" + counter).val("");
            $trNew.find("[id^=favorite_list_name]").attr("id", "favorite_list_name_" + counter).val("");
            $trNew.find("[id^=checkbox_value]").attr("id", "checkbox_value_" + counter).val("");
            $trNew.find("[id^=favorite_list_new_value]").attr("id", "favorite_list_new_value_" + counter).val("");
            $trNew.find("[id^=favorite_list_checkbox]").attr("id", "favorite_list_checkbox_" + counter).prop("checked", false).click(function() {
                $('[id^=favorite_list_checkbox_]').not(this).prop('checked', false);
                $('[id^=favorite_list_new_value_]').prop('disabled', true);
                if ($(this).is(":checked")) {
                    $('#favorite_list_new_value_' + counter).prop('disabled', false);
                }
            });
            $trLast1.after($trNew);
        }
    }

    function deleteRow(a) {
        if (confirm("Are you sure?") == true) {
            $(a).closest("tr").remove();
            $(".btn-plus").button("enable");
            counter--;
            checkInputs()
        }
    }

    var options = [
        @foreach($item_numbers as $item_number) {
            value: "{{$item_number['item_numbers']}}"
            , label: "{{$item_number['item_numbers']}}"
        }
        , @endforeach
    ];

    $(function() {
        $(".btn-plus").button({
            icon: "ui-icon-plus"
        });
        $(".btn-plus").click(function() {
            makeRow($("#table tbody"));
        });
    });

</script>
@stop

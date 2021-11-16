@extends('layouts.dashboard')
@section('title', 'Manage Claim Admin')
@section('head')
    <link rel="stylesheet" href="{{ URL::asset('css/notika-custom-icon.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/tabulator/tabulator.min.css') }}">
@stop
@section('body')
    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Manage Claims</h2>
                        <p>Total claim submitted: <span class="counter" style="color:#3F51B5;">2</span></p>
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
            <div class="data-table-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <a href="#" role="button" class="btn btn-dark">Manage Referral Doctor</a>
                                <a href="#" role="button" class="btn btn-dark">Manage Location</a>
                            </div>
                            <br>
                            <div class="data-table-list">
                                <div class="basic-tb-hd text-center">
                                    <h3>List of all submitted claims</h3>
                                </div>
                                <table id="example-table">
                                    <thead>
                                        <tr>
                                            <th>Claim ID</th>
                                            <th>Patient Title</th>
                                            <th>Patient First Name</th>
                                            <th>Patient Last Name</th>
                                            <th>Item Number</th>
                                            <th>Attendant Doctor</th>
                                            <th>Referral Doctor First Name</th>
                                            <th>Referral Doctor Last Name</th>
                                            <th>Referral Length</th>
                                            <th>Date Of Service</th>
                                            <th>Location Of Service</th>
                                            <th>Notes</th>
                                            <th>Claim Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Mrs.</td>
                                            <td>Laura</td>
                                            <td>Jonathan</td>
                                            <td>10,20,989</td>
                                            <td>Dr Marco Bonollo</td>
                                            <td>Sisca</td>
                                            <td>Patricia</td>
                                            <td>12 Months</td>
                                            <td>13/05/2020</td>
                                            <td>RMIT Clinic</td>
                                            <td>COVID 19</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Mr.</td>
                                            <td>Suwat</td>
                                            <td>Tangtragonviwatt</td>
                                            <td>999, 1000</td>
                                            <td>Dr Lucifer Morningstar</td>
                                            <td>Bella</td>
                                            <td>Decker</td>
                                            <td>3 Months</td>
                                            <td>15/05/2020</td>
                                            <td>Melbourne Clinic</td>
                                            <td>Headache</td>
                                        </tr>
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

@section('foot')
    <script src="{{ URL::asset('js/tabulator/tabulator.min.js') }}"></script>
    <script> 
        //Create Date Editor
        var dateEditor = function(cell, onRendered, success, cancel){
            //cell - the cell component for the editable cell
            //onRendered - function to call when the editor has been rendered
            //success - function to call to pass the successfuly updated value to Tabulator
            //cancel - function to call to abort the edit and return to a normal cell

            //create and style input
            var cellValue = moment(cell.getValue(), "DD/MM/YYYY").format("YYYY-MM-DD"),
            input = document.createElement("input");

            input.setAttribute("type", "date");

            input.style.padding = "4px";
            input.style.width = "100%";
            input.style.boxSizing = "border-box";

            input.value = cellValue;

            onRendered(function(){
                input.focus();
                input.style.height = "100%";
            });

            function onChange(){
                if(input.value != cellValue){
                    success(moment(input.value, "YYYY-MM-DD").format("DD/MM/YYYY"));
                }else{
                    cancel();
                }
            }

            //submit new value on blur or change
            input.addEventListener("change", onChange);
            input.addEventListener("blur", onChange);

            //submit new value on enter
            input.addEventListener("keydown", function(e){
                if(e.keyCode == 13){
                    onChange();
                }

                if(e.keyCode == 27){
                    cancel();
                }
            });

            return input;
        };


        //Build Tabulator
        var table = new Tabulator("#example-table", {
            height:"311px",
            columns:[
                {title:"Claim ID", field:"claim_id", width:150},
                {title:"Patient Title", field:"patient_title", width:150, editor:"input"},
                {title:"Patient First Name", field:"patient_first_name", width:150, editor:"input"},
                {title:"Patient Last Name", field:"patient_last_name", width:150, editor:"input"},
                {title:"Item Number", field:"item_number", width:150, editor:"input"},
                {title:"Attendant Doctor", field:"attendant_doctor", width:150},
                {title:"Referral Doctor First Name", field:"referral_doctor_first_name", width:150, editor:"input"},
                {title:"Referral Doctor Last Name", field:"referral_doctor_last_name", width:150, editor:"input"},
                {title:"Referral Length", field:"referral_length", width:150, editor:"select", editorParams:{values:{"3 Month":"3 Month", "12 Month":"12 Month", "unknown":"Unknown"}}},
                {title:"Date Of Service", field:"date_of_service", align:"center", sorter:"date", editor:dateEditor},
                {title:"Location Of Service", field:"location", width:130, editor:"autocomplete", editor:"input"},
                {title:"Notes", field:"notes", editor:"textarea"},
                {title:"Claim Status", field:"claim_status", align:"center", editor:true, formatter:"tickCross"}
            ],
        });
</script>
    
@stop

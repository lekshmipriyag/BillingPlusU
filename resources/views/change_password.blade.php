@extends('layouts.dashboard')
@section('title', 'Change Password')
@section('head')
    <link rel="stylesheet" href="{{ URL::asset('css/notika-custom-icon.css') }}">
    <style>
        html,
        body {
            height: 100%;
        }
    </style>
@stop
@section('body')
    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Change Password</h2>
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
            <div class="card">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-example-wrap">
                            <form method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-example-int form-horizental">
                                        @include('flash-message')
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="password">New Password</label>
                                                </div>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="nk-int-st">
                                                        <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="form-control input-sm" placeholder="Enter your new password" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <span id="length" class="notika-icon notika-close" style="color:#F44336;"></span> Minimum 8 characters<br>
                                                            <span id="upper" class="notika-icon notika-close" style="color:#F44336;"></span> A Uppercase Letter
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <span id="lower" class="notika-icon notika-close" style="color:#F44336;"></span> A Lowercase Letter<br>
                                                            <span id="number" class="notika-icon notika-close" style="color:#F44336;"></span> A number
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-example-int form-horizental mg-t-15 mr-2">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="password_confirmation">Confirm Password</label>
                                                </div>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="nk-int-st">
                                                        <input type="password" id="password_confirmation" name="password_confirmation" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must be the same as New Password" class="form-control input-sm" placeholder="Confirm password" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="message">
                                                                <span id="same" class="notika-icon notika-close" style="color:#F44336;"></span> Same as New Password
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-example-int mg-t-15 mr-6 text-center">
                                        <div class="row">
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                            </div>
                                            <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                <button class="btn btn-rounded btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('foot')
    <script>
        var myInput = document.getElementById("password");
        var confirmInput = document.getElementById("password_confirmation");
        var lower = document.getElementById("lower");
        var upper = document.getElementById("upper");
        var number = document.getElementById("number");
        var length = document.getElementById("length");
        var same = document.getElementById("same");

        myInput.onkeyup = function() {

            var lowerCaseLetters = /[a-z]/g;
            if(myInput.value.match(lowerCaseLetters)) {
                lower.className = "notika-icon notika-checked";
                lower.style.color = "#4CAF50";
            } else {
                lower.className = "notika-icon notika-close";
                lower.style.color = "#F44336";
            }
    
            var upperCaseLetters = /[A-Z]/g;
            if(myInput.value.match(upperCaseLetters)) {
                upper.className = "notika-icon notika-checked";
                upper.style.color = "#4CAF50";   
            } else {
                upper.className = "notika-icon notika-close";
                upper.style.color = "#F44336";
            }

            var numbers = /[0-9]/g;
            if(myInput.value.match(numbers)) {
                number.className = "notika-icon notika-checked";
                number.style.color = "#4CAF50";   
            } else {
                number.className = "notika-icon notika-close";
                number.style.color = "#F44336";
            }

            if(myInput.value.length >= 8) {
                length.className = "notika-icon notika-checked";
                length.style.color = "#4CAF50";   
            } else {
                length.className = "notika-icon notika-close";
                length.style.color = "#F44336";
            }
        }

        confirmInput.onkeyup = function() {
    
            if(confirmInput.value == myInput.value) {
                same.className = "notika-icon notika-checked";
                same.style.color = "#4CAF50";   
            } else {
                same.className = "notika-icon notika-close";
                same.style.color = "#F44336";
            }
        }

    </script>
@stop

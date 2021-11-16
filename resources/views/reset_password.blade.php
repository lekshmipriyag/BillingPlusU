@extends('layouts.authentication')
@section('title', 'Reset Password')
@section('head')
    <link rel="stylesheet" href="{{ URL::asset('css/notika-custom-icon.css') }}">
    <style>
        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }

        #message {
            display:none;
            position: relative;
        }
        #message2 {
            display:none;
            position: relative;
        }
    </style>
@stop
@section('body')
    <form method="POST" class="splash-container">
        @csrf
        <div class="card">
            <div class="card-header text-center"><img class="logo-img" src="{{ URL::asset('images/logo-blue-web-466x277.png') }}" alt="logo" width="210" height="120"><span class="splash-description"></span></div>
            <div class="card-body">
                @include('flash-message')
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-prepend"><span class="input-group-text" style="color:#2196F3";><i class="fas fa-unlock-alt"></i></span></span>
                            <input id="password" name="password" type="password" placeholder="New Password" class="form-control" required>
                        </div>
                        <div class="row" id="message">
                            <div class="col-12">
                                <span id="length" class="notika-icon notika-close" style="color:#F44336;"></span> Minimum 8 characters<br>
                                <span id="upper" class="notika-icon notika-close" style="color:#F44336;"></span> A Uppercase Letter<br>
                                <span id="lower" class="notika-icon notika-close" style="color:#F44336;"></span> A Lowercase Letter<br>
                                <span id="number" class="notika-icon notika-close" style="color:#F44336;"></span> A number
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-prepend"><span class="input-group-text" style="color:#2196F3";><i class="fas fa-lock"></i></span></span>
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Re-Type New Password" class="form-control" required>
                        </div>
                        <div class="row" id="message2">
                            <div class="col-12">
                                <span id="same" class="notika-icon notika-close" style="color:#F44336;"></span> Password needs to match<br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group pt-2 text-center">
                    <button class="btn btn-block btn-primary" type="submit">Reset Password</button>
                </div>
            </div>
            <div class="card-footer bg-white">
                <p>Don't want to reset?<a href="{{ url('login') }}" class="text-secondary"> Go to Login Page </a></p>
            </div>
        </div>
    </form>
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
        var message = document.getElementById("message");
        var message2 = document.getElementById("message2");
        myInput.onfocus = function() {
            message.style.display = "block";
        }

        myInput.onblur = function() {
            message.style.display = "none";
        }
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

        confirmInput.onfocus = function() {
            message2.style.display = "block";
        }

        confirmInput.onblur = function() {
            message2.style.display = "none";
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

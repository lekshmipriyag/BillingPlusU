@extends('layouts.authentication')
@section('title', 'Register Processor')
@section('head')
    <link rel="stylesheet" href="{{ URL::asset('css/notika-custom-icon.css') }}">
    <style>
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
            <div class="card-header">
                <h3 class="mb-1">You are one step away from paperless billing</h3>
                <p>We want to understand you better</p>
            </div>
            <div class="card-body">
                @include('flash-message')
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-prepend"><span class="input-group-text" style="color:#2196F3";><i class="fas fa-user"></i></span></span>
                            <input name="first_name" type="text" placeholder="First Name" class="form-control" value="{{ Session::get('first_name') }}" required>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-prepend"><span class="input-group-text" style="color:#2196F3";><i class="fas fa-user"></i></span></span>
                            <input name="last_name" type="text" placeholder="Last Name" class="form-control" value="{{ Session::get('last_name') }}" required>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-prepend"><span class="input-group-text" style="color:#2196F3";><i class="fas fa-envelope"></i></span></span>
                            <input type="text" class="form-control" id="validationCustom03" placeholder="Email Address" name="email" value="{{ Session::get('email') }}" required>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-prepend"><span class="input-group-text" style="color:#2196F3";><i class="fas fa-unlock-alt"></i></span></span>
                            <input id="password" name="password" type="password" placeholder="Password" class="form-control" required>
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
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Re-Type Password" class="form-control" required>
                        </div>
                        <div class="row" id="message2">
                            <div class="col-12">
                                <span id="same" class="notika-icon notika-close" style="color:#F44336;"></span> Password needs to match<br>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-prepend"><span class="input-group-text" style="color:#2196F3";><i class="fas fa-phone"></i></span></span>
                            <input type="text" class="form-control" placeholder="Mobile Number" name="mobile_number" value="{{ Session::get('mobile_number') }}" required>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-prepend"><span class="input-group-text" style="color:#2196F3";><i class="fas fa-map"></i></span></span>
                            <input type="text" class="form-control" placeholder="Post Code" name="post_code" value="{{ Session::get('post_code') }}" required>
                            <div class="invalid-feedback">Please provide a valid post code</div>
                        </div>
                    </div>
                    @if(env('GOOGLE_RECAPTCHA_KEY'))
                        <div class="input-group mb-3">
                            <div class="input-group mb-3">
                                <div class="g-recaptcha"
                                    data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="custom-control custom-checkbox" for="invalidCheck">
                            <input class="custom-control-input" type="checkbox" value="1" id="invalidCheck" name="term" required><span class="custom-control-label">By creating an account, you agree the <a href="#termModal" data-toggle="modal" class="terms"><b>terms and conditions</b></a></span>
                    </label>
                    <div class="invalid-feedback">You must agree before submitting.</div>
                </div>
                <div class="form-group pt-2 text-center">
                    <button class="btn btn-block btn-primary" type="submit">Register My Processor Account</button>
                </div>
                <div class="card-footer bg-white">
                    <p>Already have an account?<a href="{{ url('login') }}" class="text-secondary"> Login here</a></p>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="termModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Terms & Condition</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <p>1) If you are registering as a Supplier of goods and services and You list those goods and services on Your organisation profile You acknowledge and accept that You hold all such qualifications, licenses and approvals as may be required at law or otherwise to provide the goods and services and You are not prevented from providing a good or service by any contractual, fiduciary or other obligations.</p>
                    <p>2) Where you are registering in your capacity as a representative of another entity (including as a principal, partner, director, officer, or employee of a body corporate or partnership), You are duly authorised to so register and to use the Services on behalf of such entity;</p>
                    <p>3) You must not during the registration process, nor at any other time in the course of Your use of the Services or the Platform, provide any information, including any User Content, that is false or misleading. </p>
                    <p>4) You may only access and use the Services and the Platform via Your unique username and password.</p>
                    <p>5) You must take all reasonable measures to keep such username and password, and other account details, safe, secure and secret, and not share them with anyone else, and must prevent unauthorised use of the Services or the Platform.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="message" id="message">
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
@stop
@section('foot')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
    $(document).ready(function(){
        $(".terms").click(function(){
            $("#exampleModal").modal("show");
        });
    });
    </script>
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

@extends('layouts.authentication')
@section('title', 'Forgot Password')
@section('head')
<style>
        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
@stop
@section('body')
    <div class="splash-container">
        <div class="card">
            <div class="card-header text-center"><img class="logo-img" src="{{ URL::asset('images/logo-blue-web-466x277.png') }}" alt="logo" width="210" height="120"><span class="splash-description"></span></div>
            <div class="card-body">
                @include('flash-message')
                <form method="POST">
                    @csrf
                    <p>Don't worry, we'll send you an email to reset your password.</p>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="email" name="email" placeholder="Your Email Address" required>
                    </div>
                    <div class="form-group pt-1">
                        <button class="btn btn-block btn-primary" type="submit">Reset Password</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <span>Don't have an account? <a href="{{ url('pricing') }}">Sign Up</a></span>
            </div>
        </div>
    </div>
@stop

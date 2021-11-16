@extends('layouts.dashboard')
@section('title', 'Contact Us')
@section('head')
<link rel="stylesheet" href="{{ URL::asset('css/notika-custom-icon.css') }}">
@stop

@section('body')
<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Contact Us</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('contact_us') }}" class="breadcrumb-link">Needs to get in touch with the team? We're all ears.</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        @include('flash-message')
        <div class="row">
            <div class="col-md-6">
                <div class="container-contact">
                    <div class="wrap-contact">
                        <div class="contact-bg">
                            <span class="text-center" id="contact-icon">
                                <i class="fas fa-envelope fa-2x"></i>
                                <h3>Email Us</h3>
                                <a href="mailto:contact@billingplus.com?subject=Hello BillingPlusU Team" class="btn btn-rounded btn-success">contact@billingplus.com</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="container-contact">
                    <div class="wrap-contact">
                        <span class="text-center" id="contact-icon">
                            <i class="fas fa-phone fa-2x"></i>
                            <h3>Call us</h3>
                            <a href="tel:1300 923 955" class="btn btn-rounded btn-success">1300 923 955</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

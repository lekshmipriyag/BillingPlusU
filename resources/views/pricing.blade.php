@extends('layouts.authentication')
@section('title', 'Pricing')
@section('body')
    <div class="container-fluid dashboard-content">
        <div class="offset-xl-1 col-xl-10">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header bg-white text-center p-4 ">
                            <h3 class="mb-1">Processor</h3>
                            <span class="mb-2 d-block">For processing claims</span>
                            <h1 class="mb-1"><sub class="display-4">Free</sub></h1>
                            <p>per month per user</p>
                            <a href="{{ url('register_processor') }}" class="btn btn-primary mb-2">Start Now</a>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled bullet-check font-14  mb-0">
                                <li>Paperless billing solution for specialists</li>
                                <li>Access history of claims anytime</li>
                                <li>Easy administration</li>
                                <li>Technical Support</li>
                            </ul>
                        </div>
                        <div class="card-body border-top">
                            <ul class="list-unstyled font-14 ">
                                <li>Process claims submitted via our administration dashboard to your practice bills!</li>
                            </ul>
                            <a href="{{ url('register_processor') }}" class="btn btn-outline-primary btn-block btn-lg">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header bg-white text-center p-4 ">
                            <h3 class="mb-1">Personal</h3>
                            <span class="mb-2 d-block">Best for Specialist</span>
                            <h1 class="mb-1"><span class="font-24">$</span><sub class="display-4">35</sub></h1>
                            <p>per month per user</p>
                            <a href="#" class="btn btn-primary mb-2">Start 30 Days Free Trial</a>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled bullet-check font-14  mb-0">
                                <li>Paperless billing solution for specialists</li>
                                <li>Access history of claims anytime</li>
                                <li>Easy administration</li>
                                <li>Technical Support</li>
                            </ul>
                        </div>
                        <div class="card-body border-top">
                            <ul class="list-unstyled font-14 ">
                                <li>No more stickers pilling up!</li>
                                <li>You provide patient care – we do the paperwork.</li>
                                <li>Consult information is collected at the bedside.</li>
                                <li>Billing information send to your administration in the real time.</li>
                            </ul>
                            <a href="{{ url('register_personal') }}" class="btn btn-outline-primary btn-block btn-lg">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header bg-white text-center p-4 ">
                            <h3 class="mb-1">Pratices</h3>
                            <span class="mb-2 d-block">Best for Small & Medium & Large Practices</span>
                            <h1 class=" mb-1"> <sub class="display-4">Let's Talk</sub></h1>
                            <p>For more details contact us.</p>
                            <a href="#" class="btn btn-primary mb-2">Contact us Now</a>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled bullet-check mb-0">
                                <li>Get your own admin onboard</li>
                                <li>Manage up to 5 specialists</li>
                                <li>Access history of claims anytime</li>
                                <li>Automatic Data Reporting</li>
                                <li>Amazing Data Visualization</li>
                                <li>Technical Support</li>
                            </ul>
                        </div>
                        <div class="card-body border-top">
                            <ul class="list-unstyled">
                                <li>No more stickers pilling up!</li>
                                <li>You provide patient care – we do the paperwork.</li>
                                <li>Consult information is collected at the bedside.</li>
                                <li>Billing information send to your administration in the real time.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

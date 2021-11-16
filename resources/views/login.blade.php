@extends('layouts.authentication')
@section('title', 'Login')

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


@section('body')
<div class="splash-container">
    <div class="card ">
        <div class="card-header text-center"><a href="#"><img class="logo-img" src="{{ URL::asset('images/logo-blue-web-466x277.png') }}" alt="logo" width="210" height="120"></a><span class="splash-description"></span></div>
        <div class="card-body">
            @include('flash-message')
            <form method="POST">
                @csrf
                <div class="form-group">
                    <input class="form-control-pwd form-control-lg" name="email" type="text" placeholder="Email Address" required>
                </div>
                <div class="form-group">
                    <input class="form-control-pwd form-control-lg" name="password" type="password" placeholder="Password" id="pass_log_id" value="" required>
                    <button type="button" id="btnToggle" class="toggle-pwd"><i id="eyeIcon" class="fa fa-eye"></i></button>
                </div>
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" name="remember"><span class="custom-control-label">Stay signed in</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
            </form>
        </div>
        <div class="card-footer bg-white p-0">
            <div class="card-footer-item card-footer-item-bordered">
                <a href="{{ url('pricing') }}" class="footer-link">Create An Account</a>
            </div>
            <div class="card-footer-item card-footer-item-bordered">
                <a href="{{ url('forgot_password') }}" class="footer-link">Forgot Password</a>
            </div>
        </div>
    </div>
</div>
@stop
@section('foot')
<script>
    let passwordInput = document.getElementById('pass_log_id')
        , toggle = document.getElementById('btnToggle')
        , icon = document.getElementById('eyeIcon');

    function togglePassword() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = 'password';
            icon.classList.remove("fa-eye-slash");
        }
    }

    toggle.addEventListener('click', togglePassword, false);
    passwordInput.addEventListener('keyup', checkInput, false);

</script>
@stop

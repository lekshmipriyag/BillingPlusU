<!doctype html>
<html lang="en">
    
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Register</title>
        <!-- Bootstrap CSS -->
        <link rel="shortcut icon" type="image/x-icon" href="http://billingplus.com/wp-content/uploads/2017/05/logo-favicon-32x32.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/circular-std/style.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="container-fluid  dashboard-content">
            <!-- ============================================================== -->
            <!-- pageheader -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">You are one step away from paperless billing</h2>
                        <p>We want to understand you better</p>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end pageheader -->
            <!-- ============================================================== -->
            
            <div class="row">
                <!-- ============================================================== -->
                <!-- validation form -->
                <!-- ============================================================== -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Practice Account Registration</h5>
                        <div class="card-body">
                            @if (count($errors) > 0)
                            <div class = "alert alert-danger">
                                <h3>Error!</h3>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <label for="validationCustom02"><i class="fas fa-hospital"></i> <b>Practice Name</b></label>
                                        <input type="text" class="form-control" id="validationCustom03" placeholder="Practice Name" name="practice_name" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <label for="validationCustom02"><i class="fas fa-user"></i> <b>Name</b></label>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <input name="first_name" type="text" placeholder="First Name" class="form-control" required>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <input name="last_name" type="text" placeholder="Last Name" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <label for="validationCustom02"><i class="fas fa-envelope"></i> <b>Email Address</b></label>
                                        <input type="text" class="form-control" id="validationCustom03" placeholder="Email Address" name="email" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <label for="validationCustom02"><i class="fas fa-lock"></i> <b>Password</b></label>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <input id="pass2" name="password" type="password" placeholder="Password" class="form-control" required>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <input type="password" name="password_confirmation" data-parsley-equalto="#pass2" placeholder="Re-Type Password" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <label for="validationCustom02"><i class="fas fa-phone"></i> <b>Practice Phone Number</b></label>
                                        <input type="text" class="form-control" id="validationCustom04" placeholder="Practice Phone Number" name="practice_phone_number" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <label for="validationCustom02"><i class="fas fa-mobile-alt"></i> <b>Mobile Number</b></label>
                                        <input type="text" class="form-control" id="validationCustom04" placeholder="Mobile Number" name="mobile_number" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                        <label for="validationCustom05"><i class="fas fa-map-marker"></i> <b> Practice Full Address</b></label>
                                        <input type="text" class="form-control" id="validationCustom05" placeholder="Practice Full address" name="address" required>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                        <label for="validationCustom05"><i class="fas fa-sign"></i> <b> Post Code</b></label>
                                        <input type="text" class="form-control" id="validationCustom05" placeholder="Post Code" name="post_code" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid post code
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <label for="validationCustom02"><i class="fas fa-briefical"></i> <b> Practice ABN</b></label>
                                        <input type="text" class="form-control" id="validationCustom03" placeholder="ABN Number" name="abn" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="invalidCheck" name="term" required>
                                                <label class="form-check-label" for="invalidCheck">
                                                    Agree to terms and conditions
                                                </label>
                                                <div class="invalid-feedback">
                                                    You must agree before submitting.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pl-0">
                                        <p class="text-right">
                                            <button type="submit" class="btn btn-space btn-primary">Submit</button>
                                            <a href="{{ url('pricing') }}" class="btn btn-space btn-secondary">Cancel</a>
                                            <a href="{{ url('login') }}" class="btn btn-space btn-primary" style="float: left;" >Back to Login</a>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end validation form -->
                <!-- ============================================================== -->
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end main wrapper -->
        <!-- ============================================================== -->
        <!-- Optional JavaScript -->
        @if (session('status'))
        <script type="text/javascript">
        alert("{{ session('status') }}");
        window.location.replace("{{ url('login') }}");
        </script>
        @endif
        
        <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
        'use strict';
        window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
        }
        form.classList.add('was-validated');
        }, false);
        });
        }, false);
        })();
        </script>
    </body>
</html>

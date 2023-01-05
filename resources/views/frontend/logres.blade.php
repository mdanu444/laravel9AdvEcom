@extends('frontend.master')
@section('mainbody')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" type=""></script>
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">Login</li>
        </ul>
        <h3> Register / Login</h3>
        <hr class="soft" />
        @if (Session::has('error_msg'))
            <div class="alert alert-danger">
                {{ Session::get('error_msg') }}
            </div>
        @endif
        @if (Session::has('success_msg'))
            <div class="alert alert-success">
                {{ Session::get('success_msg') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="span4">
                <div class="well">
                    <h5>CREATE YOUR ACCOUNT</h5><br />
                    Give necessary data to create account.<br /><br /><br />
                    <form id="regform" action="{{ route('frontend.user.register') }}" method="post">@csrf

                        <div class="control-group">
                            <label class="control-label" for="name">Name</label>
                            <div class="controls">
                                <input class="span3" value="{{ old('name') }}" name="name" type="text"
                                    id="name" placeholder="Name">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="email">Email Address</label>
                            <div class="controls">
                                <input class="span3" value="{{ old('email') }}" name="email" type="text"
                                    id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="phone">Phone Number</label>
                            <div class="controls">
                                <input class="span3" value="{{ old('mobile') }}" name="mobile" type="text"
                                    id="phone" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="password">Password</label>
                            <div class="controls">
                                <input class="span3" value="{{ old('password') }}" name="password" type="password"
                                    id="password" placeholder="Password">
                            </div>
                        </div>

                        <div class="controls">
                            <button type="submit" class="btn block">Create Your Account</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="span1"> &nbsp;</div>


            <div class="span4">
                <div class="well">
                    <h5>ALREADY REGISTERED ?</h5>
                    <form action="{{ route('frontend.user.login') }}" method="post">@csrf

                        <div class="control-group">
                            <label class="control-label" for="inputEmail1">Email</label>
                            <div class="controls">
                                <input class="span3" value="{{ old('email') }}" name="email" type="text"
                                    id="inputEmail1" placeholder="Email">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword1">Password</label>
                            <div class="controls">
                                <input type="password" class="span3" value="{{ old('password') }}" name="password"
                                    id="inputPassword1" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">Sign in</button> <a href="{{ route('frontend.user.forgotpassview') }}">Forgot
                                    password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <style>
        .error {
            color: red;
        }
    </style>
    <script>
        $(document).ready(() => {
            $("#regform").validate({
                rules: {
                    name: "required",
                    phone: "required",
                    password: {
                        required: true,
                        minlength: 5,
                        maxlength: 12,
                    },
                    email: {
                        required: true,
                        email: true,
                    }
                }
            });
        });
    </script>
@endsection

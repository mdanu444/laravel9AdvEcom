@extends('frontend.master')
@section('mainbody')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">Profile</li>
        </ul>
        <h3> My Account </h3>
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
                    <form id="regform" action="{{ route('frontend.user.updateuser') }}" method="post">
                        @csrf
                        @method('put')

                        <div class="control-group">
                            <label class="control-label" for="name">Name</label>
                            <div class="controls">
                                <input disabled class="span3" value="{{ Auth::user()->name }}" name="name"
                                    type="text" id="name" placeholder="Name">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="email">Email Address</label>
                            <div class="controls">
                                <input disabled class="span3" value="{{ Auth::user()->email }}" name="email"
                                    type="text" id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mobile">Mobile Number</label>
                            <div class="controls">
                                <input disabled class="span3" value="{{ Auth::user()->mobile }}" name="mobile"
                                    type="text" id="phone" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="address">Address</label>
                            <div class="controls">
                                <input class="span3" value="{{ Auth::user()->address }}" name="address" type="text"
                                    id="address" placeholder="address">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="city">City</label>
                            <div class="controls">
                                <input class="span3" value="{{ Auth::user()->city }}" name="city" type="text"
                                    id="city" placeholder="City">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="country">Country</label>
                            <div class="controls">
                                <input class="span3" value="{{ Auth::user()->country }}" name="country" type="text"
                                    id="country" placeholder="Country">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="postcode">Postcode</label>
                            <div class="controls">
                                <input class="span3" value="{{ Auth::user()->postcode }}" name="postcode" type="text"
                                    id="postcode" placeholder="Postcode">
                            </div>
                        </div>


                        <div class="controls">
                            <button type="submit" class="btn block">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="span4">
                <div class="well">
                    <form id="regform" action="{{ route('frontend.user.updatepassword') }}" method="post">
                        @csrf
                        @method('put')

                        <div class="control-group">
                            <label class="control-label" for="oldpassword">Old Password</label>
                            <div class="controls">
                                <input  class="span3" value="" name="oldpassword" type="password"
                                    id="oldpassword" placeholder="Old Password">
                                    <br><span id="OldPassResult"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="newpassword">New Password</label>
                            <div class="controls">
                                <input  class="span3" value="" name="newpassword" type="password"
                                    id="newpassword" placeholder="New Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="confirmpassword">Confirm Password</label>
                            <div class="controls">
                                <input  class="span3" value="" name="confirmpassword" type="password"
                                    id="confirmpassword" placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="controls">
                            <button type="submit" class="btn block">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="span1"> &nbsp;</div>
        </div>
    </div>
    <script>
        let oldpasswordInput = document.getElementById('oldpassword');
        function sendData(){
            let formData = new FormData();
            formData.append('oldpassword', oldpasswordInput.value);
            fetch("{{ route('frontend.user.checkpass') }}", {
                method:'post',
                body: formData,
                headers:{
                    "X-CSRF-Token":document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(res => res.json())
            .then((data) =>{
                if(data.status == true){
                    document.getElementById('OldPassResult').innerHTML = "Password Matched !";
                    document.getElementById('OldPassResult').style.color = "green";
                }else{
                    document.getElementById('OldPassResult').innerHTML = "Wrong Password !";
                    document.getElementById('OldPassResult').style.color = "red";
                }
            })
        }
        let myTimeout;
        oldpasswordInput.addEventListener('keyup', ()=>{
            clearTimeout(myTimeout);
            myTimeout = setTimeout(sendData, 1000);
        });
    </script>
@endsection

@extends('frontend.master')
@section('mainbody')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ route('frontend.index') }}">Home</a> <span class="divider">/</span></li>
            <li class="active">Add New Shipping Address</li>
        </ul>
        <h3> New Shipping Address</h3>
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
                    <form id="regform" action="{{ route('frontend.user.addnewshippingaddress.update', ['id' => Crypt::encryptString($data->id)]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="control-group">
                            <label class="control-label" for="name">Name</label>
                            <div class="controls">
                                <input  class="span3" value="{{ $data->name }}" name="name"
                                    type="text" id="name" placeholder="Name">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="email">Full Address</label>
                            <div class="controls">
                                <textarea name="address" id="address" class="form-control" style="width: 78%" cols="100">{{ $data->address }}</textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="mobile">Mobile Number</label>
                            <div class="controls">
                                <input  class="span3" value="{{ $data->mobile }}" name="mobile"
                                    type="text" id="phone" placeholder="Mobile Number">
                            </div>
                        </div>
                        <div class="controls">
                            <button type="submit" class="btn block">Update Shipping Address</button>
                            <a style="float: right;" href="{{ route('frontend.checkout') }}"><div type="button" class="btn">Back</div></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('frontend.master')
@section('mainbody')
    <div class="span9">
        @if (Session::has('success_msg'))
            <div class="alert alert-success">
                {{ Session::get('success_msg') }}
            </div>
        @endif
        @if (Session::has('error_msg'))
            <div class="alert alert-danger">
                {{ Session::get('error_msg') }}
            </div>
        @endif
        <div class="card" style="padding: 10px; border: 1px solid lightgray;">
            <div class="card-header">
                <h2> User Varification by sms code</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('frontend.user.varification') }}" method="post">
                    @csrf
                    <div class="form-controle">
                        <label for="code">
                            <input type="text" name="code" placeholder="Varification Code">
                        </label>
                        <input type="submit" value="Submit" class="btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

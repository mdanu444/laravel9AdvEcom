@extends('templates.admin.master')


@section('main_content')
    <!-- general form elements -->
    <div class="card card-primary col-md-6">
        <div class="card-header">
            <h3 class="card-title">Change Password</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('admin.profile.updatepsw') }}" method="post">
            @csrf
            @method('put')
            <div class="card-body">
                <div class="form-group">
                    <label for="oldp">Old Password</label>
                    <input name="oldp" type="password" class="form-control" id="oldp"
                        placeholder="Enter Old Password">
                </div>
                <div class="form-group">
                    <label for="newp">New Password</label>
                    <input name="newp" type="password" class="form-control" id="new"
                        placeholder="Enter New Password">
                </div>
                <div class="form-group">
                    <label for="confirmp">Confirm Password</label>
                    <input name="confirmp" type="password" class="form-control" id="confirmp"
                        placeholder="Enter Confirm Password">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@endsection

@extends('templates.admin.master')


@section('main_content')
    <!-- general form elements -->
    <div class="card card-primary col-md-6">
        <div class="card-header">
            <h3 class="card-title">Admin Profile</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('admin.profile.updater') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-body">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" value="{{ Auth::guard('admin')->user()->email }}" type="text"
                        class="form-control" id="email" placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <label for="name">name</label>
                    <input name="name" value="{{ Auth::guard('admin')->user()->name }}" type="text"
                        class="form-control" id="name" placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label for="phone">phone</label>
                    <input name="phone" value="{{ Auth::guard('admin')->user()->phone }}" type="text"
                        class="form-control" id="phone" placeholder="Enter phone">
                </div>
                <div class="form-group">
                    <label for="photo">photo</label>
                    <input name="photo" value="{{ Auth::guard('admin')->user()->photo }}" type="file"
                        class="form-control" id="photo" placeholder="Enter photo">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@endsection

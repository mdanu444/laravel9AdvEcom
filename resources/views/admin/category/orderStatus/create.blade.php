@extends('templates.admin.master')


@section('main_content')
    <div class="card col-md-6">
        <div class="card-header bg-primary">Add Order Status</div>
        <div class="card-body">
            <form action="{{ route('admin.order_status.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" name="title" id="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <input type="submit" value="Add" class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection

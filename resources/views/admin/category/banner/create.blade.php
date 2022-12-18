@extends('templates.admin.master')


@section('main_content')
<div class="card col-md-6">
    <div class="card-header bg-primary">Add New Banner</div>
    <div class="card-body">
        <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" type="text" name="title" id="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input class="form-control" type="file" name="image" id="image">
                <p>[File Size should be; width: 1170 and Height: 480]</p>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="url">Url</label>
                <input class="form-control" type="text" name="url" id="url">
                @error('url')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <input type="submit" value="Add" class="btn btn-block btn-primary">
        </form>
    </div>
</div>
@endsection

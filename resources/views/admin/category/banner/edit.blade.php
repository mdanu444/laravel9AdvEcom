@extends('templates.admin.master')


@section('main_content')
    <div class="card col-md-6">
        <div class="card-header bg-primary">Edit Banner</div>
        <div class="card-body">
            <form action="{{ route('admin.banner.update', Crypt::encryptString($item->id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input value="{{ $item->title }}" class="form-control" type="text" name="title" id="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <p><strong>Current Image</strong></p>
                <img style="height: 100px" src="{{ url('images/banner/' . $item->image) }}" alt="">
                <br><br>
                <div class="form-group">
                    <label for="image">Change Image</label>
                    <input value="{{ $item->image }}" class="form-control" type="file" name="image" id="image">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="url">Title</label>
                    <input value="{{ $item->url }}" class="form-control" type="text" name="url" id="url">
                    @error('url')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <input type="submit" value="Update" class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection

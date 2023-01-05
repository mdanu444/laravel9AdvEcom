@extends('templates.admin.master')


@section('main_content')
    <div class="card col-md-6">
        <div class="card-header bg-primary">Product Section</div>
        <div class="card-body">
            <form action="{{ route('admin.productbrands.update', Crypt::encryptString($item->id)) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input value="{{ $item->title }}" class="form-control" type="text" name="title" id="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <input type="submit" value="Update" class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection

@extends('templates.admin.master')


@section('main_content')
    <div class="card col-md-6">
        <div class="card-header bg-primary">Edit Shipping Charge</div>
        <div class="card-body">
            <form action="{{ route('admin.shippingcharge.update', Crypt::encryptString($item->id)) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-group">
                    <label>District</label>
                    <input disabled value="{{ $item->districts->name }}" class="form-control" type="text" name="districts_name">
                </div>
                <div class="form-group">
                    <label for="title">0 To 500g</label>
                    <input value="{{ $item->weight_0_500g }}" class="form-control" type="number" name="weight_0_500g">
                </div>
                <div class="form-group">
                    <label for="title">501 To 1000g</label>
                    <input value="{{ $item->weight_501_1000g }}" class="form-control" type="number" name="weight_501_1000g">
                </div>
                <div class="form-group">
                    <label for="title">1001 To 2000g</label>
                    <input value="{{ $item->weight_1001_2000g }}" class="form-control" type="number" name="weight_1001_2000g">
                </div>
                <div class="form-group">
                    <label for="title">2001 To 5000g</label>
                    <input value="{{ $item->weight_2001_5000g }}" class="form-control" type="number" name="weight_2001_5000g">
                </div>
                <div class="form-group">
                    <label for="title">5001g To above</label>
                    <input value="{{ $item->weight_5001g_above }}" class="form-control" type="number" name="weight_5001g_above">
                </div>
                <input type="submit" value="Update" class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection

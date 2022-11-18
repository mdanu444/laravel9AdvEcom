@extends('templates.admin.master')

@section('main_content')

<div class="card">
    <div class="card-header bg-primary">
      <h3 class="card-title">Product Category List</h3>
      <a href="{{ route('admin.productcategory.create') }}" class="btn btn-light float-right" style="color: black !important;">+ Add New</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Id</th>
          <th>Title</th>
          <th>Section</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ !empty($item->product_sections->title)?$item->product_sections->title:"Other" }}</td>
                <td>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input type="checkbox"  class="custom-control-input statuschanger" status="productsubcategory" id="customSwitch{{$item->id}}" {{ $item->status == 1? "checked":"" }}>
                          <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                        </div>
                    </div>
                </td>
                <td class="d-flex">
                    <form method="post" action="{{ route('admin.productcategory.destroy', Crypt::encryptString($item->id)) }}">
                        @csrf
                        @method('delete')
                        <button class="border-0 bg-primary p-3" type="submit"><i class="fa fa-trash "></i></button>
                    </form>
                    <a class="bg-primary p-3 ml-2"  href="{{ route('admin.productcategory.edit', Crypt::encryptString($item->id)) }}"><i class="fa fa-pen"></i></a>
                </td>
              </tr>
            @endforeach

        </tbody>
        <tfoot>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Section</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
<style>
  #example1_filter, #example1_paginate{
    float: right;
  }
</style>

@endsection

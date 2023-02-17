@extends('templates.admin.master')

@section('main_content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Product Brand List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th rowspan="2">Id</th>
                        <th rowspan="2">District</th>
                        <th colspan="5">Charges</th>
                        <th rowspan="2">Status</th>
                        <th rowspan="2">Action</th>
                    </tr>
                    <tr>
                        <th>0 To 500g</th>
                        <th>501 To 1000g</th>
                        <th>1001 To 2000g</th>
                        <th>2001 To 5000g</th>
                        <th>5001g To above</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->districts->name }}</td>
                            <td>{{ $item->weight_0_500g	 }}</td>
                            <td>{{ $item->weight_501_1000g }}</td>
                            <td>{{ $item->weight_1001_2000g }}</td>
                            <td>{{ $item->weight_2001_5000g }}</td>
                            <td>{{ $item->weight_5001g_above }}</td>
                            <td>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input statuschanger"
                                            status="productsection" id="customSwitch{{ $item->id }}"
                                            {{ $item->status == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customSwitch{{ $item->id }}"></label>
                                    </div>
                                </div>
                            </td>
                            <td class="d-flex">
                                <a class="bg-primary p-3 ml-2"
                                    href="{{ route('admin.shippingcharge.edit', Crypt::encryptString($item->id)) }}"><i
                                        class="fa fa-pen"></i></a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <style>
        #example1_filter,
        #example1_paginate {
            float: right;
        }
    </style>
@endsection

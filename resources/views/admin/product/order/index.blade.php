@extends('templates.admin.master')

@section('main_content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Order List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Order By</th>
                        <th>Order Amount</th>
                        <th>Coupon Amount</th>
                        <th>Grand Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->users->email }}</td>
                            <td>{{ number_format($item->grand_total + $item->coupon_amount, 2) }}</td>
                            <td>{{ number_format($item->coupon_amount, 2) }}</td>
                            <td>{{ number_format($item->grand_total,2) }}</td>
                            <td>{{ $item->order_status }}</td>
                            <td>
                                <a title="View Order Details" href="{{ route('admin.adminorderdetails',['id' => $item->id]) }}"><i class="fa fa-file"></i></a>
                                @if (($item->order_status == "Shipped") || ($item->order_status == "Delivered"))
                                <a title="Print Order Details" href="{{ route('orderinvoicePrint',['id' => Crypt::encryptString($item->id)]) }}"><i class="fa fa-print"></i></a>
                                <a title="Download Order Details" href="{{ route('orderinvoiceDownload',['id' => Crypt::encryptString($item->id)]) }}"><i class="fa fa-file-pdf"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>Order Id</th>
                        <th>Order By</th>
                        <th>Order Amount</th>
                        <th>Coupon Amount</th>
                        <th>Grand Total</th>
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

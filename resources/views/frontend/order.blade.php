@extends('frontend.master')
@section('mainbody')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ route('frontend.index') }}">Home</a> <span class="divider">/</span></li>
            <li class="active">Orders</li>
        </ul>
        <h3> Orders </h3>
        @if (Session::has('error_msg'))
            <div class="alert alert-danger">
                {{ Session::get('error_msg') }}
            </div>
        @endif
        @if (Session::has('success_msg'))
            <div class="alert alert-success">
                {{ Session::get('success_msg') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <style>
            .orderid{
                color: blue !important;
                font-weight: bold;
            }
            .orderid:hover{
                text-decoration: underline;
                cursor: pointer;

            }
        </style>
        {{--  showing orders  --}}
        <div class="cartLoadable">
            <table class="table table-bordered table-hover">
                <div class="table-header">
                    <tr>
                        <th>Order Id</th>
                        <th>Order Item</th>
                        <th>Total</th>
                        <th>Coupon Discount</th>
                        <th>Grand Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </div>
                <div class="table-body">
                    @foreach ($orders as $order)
                        <tr>
                            <td ><a class="orderid" href="{{ route('frontend.orderdetails', ['id' => Crypt::encryptString($order->id)]) }}"># {{ $order->id }}</a></td>
                            <td>
                                @foreach ($order->order_items as $item)
                                    <span class="orderitem">{{ $item->product_name .' [ '. $item->product_size .' ]' }}</span><br>
                                @endforeach
                            </td>
                            <td>{{ number_format(($order->grand_total + $order->coupon_amount),2) }}</td>
                            <td>{{ number_format(($order->coupon_amount),2) }}</td>
                            <td>{{ number_format($order->grand_total,2) }}</td>
                            <td>{{ $order->order_status }}</td>
                            <td >
                                <a class="orderid" href="{{ route('frontend.orderdetails', ['id' => Crypt::encryptString($order->id)]) }}">
                                    Show Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @if (count($orders) < 1)
                    <tr>
                        <td colspan="7">No Order Found.</td>
                    </tr>

                    @endif
                </div>
            </table>
        </div>
    </div>

@endsection

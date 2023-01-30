@extends('frontend.master')
@section('mainbody')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ route('frontend.index') }}">Home</a> <span class="divider">/</span></li>
            <li class="active">Order Details</li>
        </ul>
        <h3> Orders # {{ $order->id }} Details</h3>
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
            .orderid {
                color: blue;
            }

            .orderid:hover {
                text-decoration: underline;
                cursor: pointer;
            }
            .fifty{
                padding: 10px;
                width: 50% !important;
            }
            .card{
                box-shadow: 0 0 3px lightgray;
                padding: 10px;
                border-radius: 5px;
            }
            .card-header{
                padding: 5px;
                font-weight: bold;
                font-size: 1.2rem;
            }
        </style>
        {{--  showing orders  --}}
        <div class="container"  style="width: 100% !important; display: flex; box-sizing: border-box;">
            <div class="fifty">
                <div class="card">
                    <div class="card-header">Delivery Details</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>Order Date</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                            <tr>
                                <td>Order Status</td>
                                <td>{{ $order->order_status }}</td>
                            </tr>
                            <tr>
                                <td>Order Total</td>
                                <td>{{ $order->grand_total }}</td>
                            </tr>
                            <tr>
                                <td>Shipping Charge</td>
                                <td>{{ $order->shipping_charge }}</td>
                            </tr>
                            <tr>
                                <td>Coupon Code</td>
                                <td>{{ $order->coupon_code }}</td>
                            </tr>
                            <tr>
                                <td>Coupon Amount</td>
                                <td>{{ $order->coupon_amount }}</td>
                            </tr>
                            <tr>
                                <td>Payment Method</td>
                                <td>{{ $order->payment_method }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="fifty">
                <div class="card">
                    <div class="card-header">Delivery Address</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>Name</td>
                                <td>{{ $order->shipping->name }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ $order->shipping->address }}</td>
                            </tr>
                            <tr>
                                <td>Upazila</td>
                                <td>{{ $order->shipping->upazilas->name }}</td>
                            </tr>
                            <tr>
                                <td>District</td>
                                <td>{{ $order->shipping->districts->name }}</td>
                            </tr>
                            <tr>
                                <td>Division</td>
                                <td>{{ $order->shipping->divisions->name }}</td>
                            </tr>
                            <tr>
                                <td>Mobile</td>
                                <td>{{ $order->shipping->mobile }}</td>
                            </tr>

                        </table>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
        <div  style="padding: 10px;">
            <div class="card">
                <div class="card-header">Order Items</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Product Image</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Size</th>
                            <th>Product Color</th>
                            <th>Product Qty</th>
                        </tr>
                        @foreach ($order->order_items as $item)
                            <tr>
                                <td style="text-align: center"><img style="height: 80px" src="{{ url('images/product_image/small/'. $item->product->image) }}" alt="Product Image"></td>
                                <td>{{ $item->product_code }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->product_size }}</td>
                                <td>{{ $item->product_color }}</td>
                                <td>{{ $item->product_quantity }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

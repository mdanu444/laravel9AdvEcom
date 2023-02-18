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
            .paymentBtn{
                padding:3px 8px; border-radius: 5px; background:rgb(253, 194, 0); border: 1px solid lightgray; text-decoration: none; font-weight: bold;
            }
            .paymentBtn:hover{
                text-decoration: none;
                outline: 1px solid red;
            }
        </style>
        {{--  showing orders  --}}
        <div class="container"  style="width: 100% !important; display: flex; box-sizing: border-box;">
            <div class="fifty">
                <div class="card">
                    <div class="card-header">Order Details</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>Order Date</td>
                                <td>{{ date_format($order->created_at, 'dS F, Y - h:i A ') }}</td>
                            </tr>
                            <tr>
                                <td>Order Status</td>
                                <td>{{ $order->order_status }}</td>
                            </tr>
                            <tr>
                                <td>Order Total</td>
                                <td>{{ number_format((($order->grand_total + $order->coupon_amount) - $order->shipping_charge),2) }}</td>
                            </tr>
                            <tr>
                                <td>Coupon Amount</td>
                                <td>{{ number_format($order->coupon_amount ,2)}}</td>
                            </tr>
                            <tr>
                                <td>Shipping Charge</td>
                                <td>{{ number_format($order->shipping_charge,2) }}</td>
                            </tr>
                            <tr>
                                <td><strong> Grand Total</strong></td>
                                <td><strong> {{ number_format($order->grand_total,2) }}</strong></td>
                            </tr>
                            <tr>
                                <td>Coupon Code</td>
                                <td>{{ $order->coupon_code == 0 ? "-":$order->coupon_code }}</td>
                            </tr>
                            <tr>
                                <td>Courier Name</td>
                                <td>{{ !empty($order->courier_name) ? $order->courier_name : "-" }}</td>
                            </tr>
                            <tr>
                                <td>Tracking Number</td>
                                <td>{{ !empty($order->tracking_number) ? $order->tracking_number : "-" }}</td>
                            </tr>
                            <tr>
                                <td>Payment Method</td>
                                <td>{{ $order->payment_method }} &nbsp;&nbsp;&nbsp;
                                    @if($order->order_status == "Un-Paid")
                                    <a class="paymentBtn"
                                        @if ($order->payment_method == 'Paypal')
                                        href="{{ route('frontend.paypal.index',['paypal' => Crypt::encryptString($order->id)]) }}"
                                        @endif
                                        @if ($order->payment_method == 'bkash')
                                        href="{{ route('frontend.bkash.index',['bkash' => Crypt::encryptString($order->id)]) }}"
                                        @endif
                                        @if ($order->payment_method == 'Nagad')
                                        href="{{ route('frontend.nagad.index',['nagad' => Crypt::encryptString($order->id)]) }}"
                                        @endif
                                        @if ($order->payment_method == 'SSLCommerz')
                                        href="{{ route('frontend.SSLCommerz.index',['SSLCommerz' => Crypt::encryptString($order->id)]) }}"
                                        @endif

                                    >Make Payment</a>
                                    @endif
                                </td>
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
                <div class="card-header">Order Product Items</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Product Image</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Size</th>
                            <th>Product Color</th>
                            <th>Order Qty</th>
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

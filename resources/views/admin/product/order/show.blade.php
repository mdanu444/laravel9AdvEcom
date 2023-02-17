@extends('templates.admin.master')

@section('main_content')


    <h3 class="text-bold">Showing Details of Order Number <span># {{ $data->id }}</span>. </h3>


    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info">Order Details</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Order Date</td>
                            <td>{{ date_format($data->created_at, 'dS F, Y-h:i:s A') }}</td>
                        </tr>
                        <tr>
                            <td>Sub Total</td>
                            <td>{{ $data->grand_total + $data->coupon_amount - $data->shipping_charge }}</td>
                        </tr>
                        <tr>
                            <td>Coupon Amount</td>
                            <td> ({{ number_format($data->coupon_amount,2) }}) </td>
                        </tr>
                        <tr>
                            <td>Shipping Charge</td>
                            <td>{{ number_format($data->shipping_charge,2) }} </td>
                        </tr>
                        <tr>
                            <td>Grand Total</td>
                            <td>{{ $data->grand_total }}</td>
                        </tr>
                        <tr>
                            <td>Coupon Code</td>
                            <td>{{ $data->coupon_code }} </td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td>{{ $data->payment_method }} </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info">Customer Details & Billing Address</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Name</td>
                            <td>{{ $data->users->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $data->users->email }}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{ $data->users->mobile }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ $data->users->address }}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{ $data->users->city }}</td>
                        </tr>
                        <tr>
                            <td>Division</td>
                            <td>{{ $data->users->state }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ $data->users->country }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info">Update Order Status</div>
                <div class="card-body">
                    <form action="{{ route('admin.updateorderstatus', ['id' => $data->id]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="row mb-1">
                            <div class="col-md-3">
                                <select class="form-control" name="order_status" id="order_status">
                                    <option value="">Status</option>
                                    @foreach ($statuses as $status)
                                            <option value="{{ $status->title }}">{{ $status->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" type="text" placeholder="Courier" name="courier_name"
                                    id="courier">
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" type="text" placeholder="Tracking" name="tracking_number"
                                    id="tracking">
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" type="number" placeholder="Charge" name="shipping_charge"
                                    id="shipping_charge">
                            </div>

                        </div>

                        <table class="table table-bordered">
                            <tr>
                                <td>Current Status</td>
                                <td>{{ $data->order_status }}</td>
                            </tr>
                            <tr>
                                <td>Previous Status</td>
                                <td>{{ $previouslog }}</td>
                            </tr>

                        </table>
                        <input class="btn btn-block btn-primary ml-2" type="submit" value="Update">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info">Status Logs</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        @if (count($statuslogs) == 0)
                            No Log Found !
                        @else
                            @foreach ($statuslogs as $log)
                                Order updated as <b>{{ $log->status }}</b> at
                                {{ date_format($log->updated_at, 'd F, Y-h:i:s A') }}.
                                <hr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header bg-info">Order Items</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Product Image</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Size</th>
                            <th>Product Color</th>
                            <th>Order Quantity</th>
                        </tr>
                        @foreach ($data->order_items as $item)
                            <tr>
                                <td class="text-center"><a target="_blank"
                                        href="{{ url('images/product_image/larg/' . $item->product->image) }}"><img
                                            style="max-height: 100px; max-width: 100px; "
                                            src="{{ url('images/product_image/small/' . $item->product->image) }}"
                                            alt="Product Image"></a></td>
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

    <script>
        $("#order_status").on('change', shippedchecker);

        function shippedchecker() {
            if ($("#order_status").val() != "Shipped") {
                $("#courier").hide();
                $("#tracking").hide();
                $("#shipping_charge").hide();
            } else {
                $("#courier").show();
                $("#tracking").show();
                $("#shipping_charge").show();
            }
        }
        shippedchecker();
    </script>
@endsection

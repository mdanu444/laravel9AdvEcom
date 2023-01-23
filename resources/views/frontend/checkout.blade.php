@php
    use App\Models\Cart;
@endphp

@extends('frontend.master')
@section('mainbody')
    <style>
        th,
        td {
            vertical-align: center !important;
            line-height: 1;
        }
    </style>
    <div class="span9">
        @if (Session::has('error_msg'))
            <div class="alert alert-danger">{{ Session::get('error_msg') }}</div>
        @endif
        @if (Session::has('success_msg'))
            <div class="alert alert-success">{{ Session::get('success_msg') }}</div>
        @endif
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active"> Checkout</li>
        </ul>
        <style>
            .shippingaddresses table{
                background: white; padding: 5px;
            }
            .shippingaddresses table th{
                font-weight: bolder; background: lightgray;
                text-transform: uppercase;
            }
            .shippingaddresses table td, .shippingaddresses table th{
                padding: 10px; border: 1px solid black;
            }
            .shippingaddresses table td{
                padding: 0;
            }
            .addEdit, .addDel{
                width: 45%; box-sizing: border-box;
                display: inline-block; padding: 5px;
                border-radius: 3px; font-weight: bold;
            }
            .addEdit{
                background: rgb(0, 185, 0);
            }
            .addEdit:hover{
                background: rgb(32, 255, 32);
            }
            .addDel{
                background: rgb(198, 0, 0);
            }
            .addDel:hover{
                background: rgb(251, 75, 21);
            }
            label{
                padding: 12px;
                margin-top: 4px;
            }
            label:hover, label:hover td{
                background: rgb(240, 240, 240);
            }
        </style>
        <div class="shippingaddresses">
            <table style="width: 100%;">
                <tr>
                    <th style="width: 80%">Shipping Addresss
                        <a href="{{ route('frontend.user.addnewshippingaddress') }}">
                            <div class="btn btn-success">Add New </div>
                        </a>
                    </th>
                    <th style="width: 20%; text-align: center;">Action</th>
                </tr>
                @if (count($shippingaddress) > 0)
                @foreach ($shippingaddress as $address)
                <tr>
                    <td style="width: 80%">
                        <label >
                            <input style="margin-top: -2px;" type="radio" name="address" value="{{ Crypt::encryptString($address->id) }}" id="{{ Crypt::encryptString($address->id) }}">

                            {{ $address->address }}
                        </label>
                    </td>
                    <td style="width: 20%; text-align: center;">
                        <a href="{{ route('frontend.user.addnewshippingaddress.edit', ['id'=>Crypt::encryptString($address->id)]) }}"><span class="addEdit">Edit</span></a>
                        <a href="{{ route('frontend.user.addnewshippingaddress.delete', ['id'=>Crypt::encryptString($address->id)]) }}"><span class="addDel">Delete</span></a>
                    </td>
                </tr>
                @endforeach
                @else
                    <td colspan="2" style="text-align: center; padding: 10px">No Data Found</td>
                @endif
            </table>
        </div>
        <h3> Checkout [ <small>
                <span class="cartitem">
                    @if (Session::has('numberOfCartItem'))
                        {{ Session::get('numberOfCartItem') }}
                    @else
                        0
                    @endif
                </span>
                Item(s) </small>]<a href="{{ route('frontend.cart.index') }}" class="btn btn-large pull-right"><i
                    class="icon-arrow-left"></i> Back to cart </a></h3>
        <hr class="soft" />
        @guest


            <table class="table table-bordered">
                <tr>
                    <th> I AM ALREADY REGISTERED </th>
                </tr>
                <tr>
                    <td>
                        <form class="form-horizontal" action="{{ route('frontend.user.login') }}" method="post">@csrf
                            <div class="control-group">
                                <label class="control-label" for="email">Email Address</label>
                                <div class="controls">
                                    <input type="text" name="email" id="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="password">Password</label>
                                <div class="controls">
                                    <input type="password" name="password" id="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <button type="submit" class="btn">Sign in</button> OR <a
                                        href="{{ route('frontend.logreg.index') }}" class="btn">Register Now!</a>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <a href="{{ route('frontend.user.forgotpassview') }}"
                                        style="text-decoration:underline">Forgot password ?</a>
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
            </table>
        @endguest
        <div id="cartLoadable">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Quantity/Update</th>
                        <th>Price <br>Per Unit</th>
                        <th>Discount <br> Per Unit</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalAmount = 0;
                        $total_quantity = 0;
                        $productDiscount = 0;
                        $grandTotal = 0;
                    @endphp
                    @foreach ($cartitems as $cartitem)
                        @php
                            // product attribute discount
                            $total_quantity += $cartitem->quantity;
                            $CartProduct = Cart::getCartProducts($cartitem->products_id, $cartitem->attributes_id);
                        @endphp
                        <tr>
                            <td> <img width="60" src="{{ url('images/product_image/small/' . $CartProduct['product']->image) }}"
                                    alt="" /></td>
                            <td>{{ $CartProduct['product']->title }}({{ $CartProduct['attribute']->sku }})<br />Color :
                                {{ $CartProduct['product']->color }}
                                <br>Size : {{ $CartProduct['attribute']->size }}
                            </td>
                            <td>
                                {{ $cartitem->quantity }}
                            </td>
                            @php
                                $totalAmount += $cartitem->quantity * ($cartitem->price - $cartitem->price * ($CartProduct['discount'] / 100));
                                $productDiscount = $cartitem->price * ($CartProduct['discount'] / 100);
                                $grandTotal = $totalAmount - $productDiscount;
                            @endphp

                            <td>Rs.{{ number_format($cartitem->price, 2) }}</td>
                            <td>Rs.{{ number_format($cartitem->price * ($CartProduct['discount'] / 100), 2) }}</td>
                            <td>Rs.{{ number_format($cartitem->quantity * ($cartitem->price - $cartitem->price * ($CartProduct['discount'] / 100)), 2) }}
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="5" style="text-align:right">Total Price: </td>
                        <td> Rs. {{ number_format($totalAmount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align:right">Coupon Discount: </td>
                        <td> Rs.
                            @if (Session::has('coupon_amount'))
                                {{ number_format(Session::get('coupon_amount'),2) }}
                            @else
                                {{ number_format(0, 2) }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align:right"><strong>GRAND TOTAL (Total Price - Coupon Discount) =</strong>
                        </td>
                        <td class="label label-important" style="display:block"> <strong> Rs.
                                @if (Session::has('grandTotal'))
                                    {{ number_format(Session::get('grandTotal'),2) }}
                                @else
                                {{ number_format(0,2) }}
                                @endif

                            </strong></td>
                    </tr>
                </tbody>
            </table>





        </div>


        <!-- <table class="table table-bordered">
           <tr><th>ESTIMATE YOUR SHIPPING </th></tr>
           <tr>
           <td>
            <form class="form-horizontal">
            <div class="control-group">
             <label class="control-label" for="inputCountry">Country </label>
             <div class="controls">
             <input type="text" id="inputCountry" placeholder="Country">
             </div>
            </div>
            <div class="control-group">
             <label class="control-label" for="inputPost">Post Code/ Zipcode </label>
             <div class="controls">
             <input type="text" id="inputPost" placeholder="Postcode">
             </div>
            </div>
            <div class="control-group">
             <div class="controls">
             <button type="submit" class="btn">ESTIMATE </button>
             </div>
            </div>
            </form>
           </td>
           </tr>
                    </table> -->
        <a href="{{ route('frontend.cart.index') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Back to cart </a>
        <a href="{{ route('frontend.logreg.index') }}" class="btn btn-large pull-right">Next <i
                class="icon-arrow-right"></i></a>

    </div>
@endsection



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
            .shippingaddresses table {
                background: white;
                padding: 5px;
            }
            .shippingaddresses{
                border-radius: 5px;
            }

            .shippingaddresses table th {
                font-weight: bolder;
                background: rgb(255, 255, 255);
                text-transform: uppercase;
            }

            .shippingaddresses table td,
            .shippingaddresses table th {
                padding: 10px;
                border: 1px solid lightgray;

            }

            .shippingaddresses table td {
                padding: 0;
            }

            .addEdit,
            .addDel {
                width: 45%;
                box-sizing: border-box;
                display: inline-block;
                padding: 5px;
                border-radius: 3px;
                font-weight: bold;
            }

            .addEdit {
                background: rgb(0, 185, 0);
            }

            .addEdit:hover {
                background: rgb(32, 255, 32);
            }

            .addDel {
                background: rgb(198, 0, 0);
            }

            .addDel:hover {
                background: rgb(251, 75, 21);
            }

            label {
                padding: 12px;
                margin-top: 4px;
            }

            label:hover,
            label:hover td {
                background: rgb(255, 255, 255);
            }
        </style>

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
        @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
        <form action="{{ route('frontend.placeorder') }}" method="post">
            @csrf
            <div class="shippingaddresses">
                <table style="width: 100%;">
                    <tr>
                        <th style="width: 80%; text-align: left;">Shipping Addresss
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
                                    <label class="shippingaddress" data="{{ $address->id }}">
                                        <input style="margin-top: -2px;" type="radio" name="address"
                                            value="{{ Crypt::encryptString($address->id) }}" id="">
                                        {{ $address->address }}
                                        , Division: {{ $address->divisions->name }}
                                        , District: {{ $address->districts->name }}
                                        , Upazila: {{ $address->upazilas->name }}.
                                    </label>
                                </td>
                                <td style="width: 20%; text-align: center;">
                                    <a
                                        href="{{ route('frontend.user.addnewshippingaddress.edit', ['id' => Crypt::encryptString($address->id)]) }}"><span
                                            class="addEdit">Edit</span></a>
                                    <a
                                        href="{{ route('frontend.user.addnewshippingaddress.delete', ['id' => Crypt::encryptString($address->id)]) }}"><span
                                            class="addDel">Delete</span></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td colspan="2" style="text-align: center; padding: 10px">No Data Found</td>
                    @endif
                </table>
            </div>
            <br>

            <div id="cartLoadable" >

            @include('frontend.ajax_checkout')
            </div>
            <div style="padding: 10px; border-radius: 5px; border: 1px solid lightgray;">
                <h4>Payment Option</h4>
                <table>
                    <tr>
                        <td>
                            <fieldset style="border:2px solid lightgray; padding: 10px;">
                                <legend style="text-align: center;font-size: 14px; line-height: 1; background: lightgray; padding: 3px; border-radius: 3px; font-weight: bolder; text-align: center;">Off Line Payment</legend>
                                <label style="font-weight: bolder">
                                    <img style="width: 50px; height: 50px; cursor: pointer; margin-left: 15px;" src="{{ asset('images/payment_image/cod.png') }}" alt="PayPal Payment"> <br>
                                    <input style="margin-top: -2px;" name="payment_method" type="radio" value="COD"> Cash on delivery
                                </label>
                            </fieldset>
                        </td>
                        <td>
                            <fieldset style="border:2px solid lightgray; padding: 10px;">
                                <legend style="text-align: center;font-size: 14px; line-height: 1; background: lightgray; padding: 3px; border-radius: 3px; font-weight: bolder;">Online Payment/Prepaid</legend>
                                <div class="prepaid" style="display: flex">
                                    <label style="font-weight: bolder">
                                        <img style="width: 50px; height: 50px; cursor: pointer; margin-left: 15px;" src="{{ asset('images/payment_image/paypal.png') }}" alt="PayPal Payment"> <br>
                                        <input style="margin-top: -2px;" name="payment_method" type="radio" value="Prepaid"> Paypal
                                    </label>
                                    <label style="font-weight: bolder">
                                        <img style="width: 50px; height: 50px; cursor: pointer; margin-left: 15px;" src="{{ asset('images/payment_image/bkash.png') }}" alt="bKash  Payment"> <br>
                                        <input style="margin-top: -2px;" name="payment_method" type="radio" value="bkash"> bKash
                                    </label>
                                    <label style="font-weight: bolder">
                                        <img style="width: 50px; height: 50px; cursor: pointer; margin-left: 15px;" src="{{ asset('images/payment_image/nagad.svg') }}" alt="Nagad Payment"> <br>
                                        <input style="margin-top: -2px;" name="payment_method" type="radio" value="Nagad"> Nagad
                                    </label>
                                    <label style="font-weight: bolder">
                                        <img style="width: 50px; height: 50px; cursor: pointer; margin-left: 15px;" src="{{ asset('images/payment_image/sslcommerze.png') }}" alt="SSL Commerz Payment"> <br>
                                        <input style="margin-top: -2px;" name="payment_method" type="radio" value="SSLCommerz"> SSL Commerz
                                    </label>
                                </div>
                            </fieldset>

                        </td>
                    </tr>
                    </table>
            </div>
            <br>
            <a href="{{ route('frontend.cart.index') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Back to cart
            </a>
            <button type="submit" class="btn btn-large pull-right">Place Order <i class="icon-arrow-right"></i></button>
    </div>
    </form>
    <script>
        let cartLoadable = document.querySelector('#cartLoadable');
        let addressess = document.querySelectorAll('.shippingaddress');
        for(let address of addressess){
            address.addEventListener('click', ()=>{
                let id = address.getAttribute('data');
                let url = "{{ route('frontend.UpdateCheckout') }}";
                formData = new FormData();
                formData.append('district', id);
                fetch(url, {
                    headers:{
                        "X-CSRF-Token": "{{ csrf_token() }}",
                    },
                    method: 'post',
                    body: formData
                }).then(res => res.json())
                .then(data =>{
                    {{--  console.log(data)
                    return;  --}}
                    loading();
                    if(data.status == true){
                        cartLoadable.innerHTML = data.html;
                    }else{
                        alert(data.message)
                    }
                });
                loading();
                return 0;
            });
        }
    </script>
@endsection

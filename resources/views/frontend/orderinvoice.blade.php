<?php

use App\Models\Cart;

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Invoice</title>
    <style>
        html {
            font-size: 14px;
        }

        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        body {
            padding: 10px;
        }

        .a4 {
            width: 8.27in;
            display: flex;
            justify-content: center;
            z-index: 2;
        }
        .container {
            border-radius: 5px;
            padding: 20px;
            width: 100%;
        }

        .addresses {
            display: flex;
            justify-content: space-between;
        }

        .heading {
            display: flex;
            justify-content: space-between;
        }



        table {
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 4px lightgray;
        }

        table * {
            padding-top: 10px;
            padding-right: 10px;
            color: gray;
        }

        .itemstable {
            width: 100%;
            border-collapse: collapse;
        }

        .itemstable td,
        th {
            padding: 5px;
            border: .5px solid lightgray;
        }

        .watermark {
            position: fixed;
            font-size: 70px;
            color: gray;
            opacity: .15;
            z-index: 1;
            top: 40%;
            left: 0;
            transform: rotate(-45deg);
            display: none;
        }

        h4,
        th {
            color: black;
        }

        h3 {
            background-color: lightgray;
            padding: 10px;
            border-radius: 5px 5px 0 0;
            margin-bottom: -15px;
            box-shadow: 0 0 4px lightgray;
        }

        .print-button {
            border: 0;
            padding: 5px;
            border-radius: 2px;
            background: red;
            font-size: 18px;
            cursor: pointer;
        }


        @media print {
            .notprintable {
                display: none;
            }

            .container {
                border: none;
            }

            .watermark {
                display: block;
            }
        }
    </style>

</head>

<body>
    <div class='a4'>
        <div class='container'>
            <div class='heading'>
                <div>
                    <h1 style='color: red;'>Advanced <span style='color:black'>Ecommerce</span></h1>
                    <br>
                    <h1 style='background: rgb(255, 0, 0); padding: 10px; color: #fff; display: inline-block;'>Invoice No#
                        {{ $data->id }}</h1>
                    <p style='margin-top: 10px; color: gray;'>Order Date: <?php echo date_format($data->created_at, 'd M, Y'); ?></p>
                    <p style='margin-top: 10px; color: gray;'>Invoice Date: <?php echo date('d M, Y'); ?></p>
                </div>
                <div>
                    <span style='width: 100px'><?php
                    echo DNS2D::getBarcodeHTML(route('orderinvoicePrint', ['id' => Crypt::encryptString($data->id)]), 'QRCODE', 2, 2);
                    ?></span>
                    <p style='margin-top: 5px; color: black; font-size: 16px;'>Scane to verify.</p>
                </div>
            </div>
            <div style='border-top: 1px solid rgb(182, 182, 182); margin-top: 5px;'></div>
            <div class='addresses'>
                <div class='billingaddress'>
                    <br>
                    <h3>Billing Details:</h3>
                    <table>
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td>{{ $data->users->name }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td>{{ $data->users->address }}</td>
                        </tr>
                        <tr>
                            <td>District</td>
                            <td>:</td>
                            <td>{{ $data->users->city }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>{{ $data->users->email }}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>:</td>
                            <td>{{ $data->users->mobile }}</td>
                        </tr>
                    </table>
                </div>
                <div class='shippingaddress'>
                    <br>
                    <h3>Shipping Details:</h3>
                    <table>
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td>{{ $data->shipping->name }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td>{{ $data->shipping->address }}</td>
                        </tr>
                        <tr>
                            <td>Upazila</td>
                            <td>:</td>
                            <td> {{ $data->shipping->upazilas->name }}</td>
                        </tr>
                        <tr>
                            <td>District</td>
                            <td>:</td>
                            <td> {{ $data->shipping->districts->name }}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>:</td>
                            <td>{{ $data->shipping->mobile }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <br><br>
            <br><br>
            <div class='items'>
                <h3>Order Items:</h3>
                <br>
                <table class='itemstable'>
                    <tr>
                        <th>Sl No</th>
                        <th>Product Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Sub Total</th>
                    </tr>
                    @foreach ($data->order_items as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}.</td>
                            <td>
                                <h4>{{ $item->product_name }}</h4>
                                Color: {{ $item->product_color }} <br>
                                Size: {{ $item->product_size }} <br>
                                Code: {{ $item->product_code }} <br>
                            </td>
                            <td style='text-align: center;'>{{ $item->product_quantity }} Unit</td>
                            <td style='text-align: center;'>BDT {{ number_format($item->product_price, 2) }}</td>
                            <?php
                            $totalAmount = $item->product_price * $item->product_quantity;
                            ?>
                            <td style='text-align: center;'>BDT
                                {{ number_format($totalAmount * (Cart::getdiscount($item->product_id)/100), 2) }}
                            </td>
                            <td style='text-align: center;'>BDT

                                {{ number_format(
                                    // total amount
                                    $totalAmount - $totalAmount * (Cart::getdiscount($item->product_id) / 100),
                                    2,
                                ) }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan='5' style='text-align: right; font-weight: bold;' >Total</td>
                        <td style='font-weight: bold; text-'>BDT
                            {{ number_format($data->grand_total + $data->coupon_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan='5' style='text-align: right; font-weight: bold;' >Coupon Discount</td>
                        <td style='font-weight: bold; text-'>BDT {{ number_format($data->coupon_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan='5' style='text-align: right; font-weight: bold;' >Coupon Discount</td>
                        <td style='font-weight: bold; '>BDT {{ number_format($data->grand_total, 2) }}</td>
                    </tr>
                </table>
                <!--# // please dont remove it #}} -->
                <br><br><br><br>
                <!--# // please dont remove it #}} -->
            </div>
        </div>
    </div>
    <div class='watermark'>
        Advanced Ecommerce
    </div>
</body>

</html>

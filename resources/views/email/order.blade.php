<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Confirmation</title>
    <style>
        body{

        }
        table{
            border-radius: 8px;
            display: inline-block;
            width: 300px !important;
        }
        .container{
            width: 300px; padding: 10px; background-color: lightblue;
        }
        table td{
            border: 1px solid black;
            padding: 10px;
        }
    </style>
</head>
<body style="padding: 20px;">
    <div class="container">



    <h1 style="color: red">Advanced <span style="color: black">Ecommerce</span></h1>

    Dear, {{ Auth::user()->name }}, Thanks for order us. Your order has been placed successfully. We will confirm about the order by email. Plese stay with us.
    <h3 style="background: lightgray; padding: 5px; border-radius: 8px 8px 0 0">Order Details is as below:-</h3>
    <table style="border-collapse:collapse; ">
        <tr>

            <td>Order Id</td>
            <td>:</td>
            <td>{{ $order->id }}</td>
        </tr>
<tr>

    <td>Order Status</td>
    <td>:</td>
    <td>{{ $order->order_status }}</td>
</tr>
<tr>

    <td>Payment Method</td>
    <td>:</td>
    <td>{{ $order->payment_method }}</td>
</tr>
<tr>

    <td>Coupon Amount</td>
    <td>:</td>
    <td>{{ $order->coupon_amount }}</td>
</tr>
<tr>

    <td>Grand Total</td>
    <td>:</td>
    <td>{{ $order->grand_total }}</td>
</tr>
<tr>

    <td>Order Date</td>
    <td>:</td>
    <td>{{ $order->created_at }}</td>
</tr>
    </table>
<br>
If any query, please contact us. Cell: 8801629400986. <br>
Thank you!
</div>
</body>
</html>

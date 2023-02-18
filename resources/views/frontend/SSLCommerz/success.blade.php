<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paypal Payment </title>
    <style>
        .container{
            padding: 20px;
            margin: auto;
            box-shadow: 0 0 5px lightgray;
            border-radius: 8px;
            margin-top: 50px;
            width: 700px;
            font-family: arial;
        }
        table{
            border-collapse: collapse;
            border-radius: 5px;
            width: 100%;
        }
        table td{
            padding: 10px;
            font-size: 20px;
            border: 1px solid lightgray;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 style="text-align: center;">Payment Success !</h1>
    <p>Thank for payment.</p>

    <div style="border-radius: 20px;">
        <table>
            <tr style="background: lightblue; font-weight: bolder;">
                <td>Transection Id</td>
                <td>:</td>
                <td>{{$order_details->transaction_id }}</td>
            </tr>
            @auth
            <tr style="font-weight: bolder;">
                <td>Customer Name</td>
                <td>:</td>
                <td>{{ Auth::user()->name }}</td>
            </tr>
            @endauth
            <tr style="font-weight: bolder;">
                <td>Payment Amount</td>
                <td>:</td>
                <td>{{$order_details->amount }}</td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <a href="{{ route('frontend.orders') }}">See Orders.</a>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Confirmation</title>

</head>

<body>
    <div class="container" style="width: 400px;padding: 10px;">

        <h1 style="color: red">Advanced <span style="color: black">Ecommerce</span></h1>

        Below given your payment confirmation. <br> <br>
        <h3 style="background: lightgray; padding: 10px; padding-bottom: 0; margin: 0; border-radius: 8px 8px 0 0; box-shadow: 0 0 5px lightgray">Order Details is as below:-</h3>
        <table style="border-collapse:collapse; background: white; width: 100%;; box-shadow: 0 0 5px lightgray ">
            <tr>
                <td style="border: 1px solid lightgray; padding: 10px;">Payment Amount</td>
                <td style="border: 1px solid lightgray; padding: 10px;">:</td>
                <td style="border: 1px solid lightgray; padding: 10px;">{{ $payment->amount }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid lightgray; padding: 10px;">Payment Status</td>
                <td style="border: 1px solid lightgray; padding: 10px;">:</td>
                <td style="border: 1px solid lightgray; padding: 10px;">{{ $status }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid lightgray; padding: 10px;">Payment Method</td>
                <td style="border: 1px solid lightgray; padding: 10px;">:</td>
                <td style="border: 1px solid lightgray; padding: 10px;">{{ $method }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid lightgray; padding: 10px;">Transection Id</td>
                <td style="border: 1px solid lightgray; padding: 10px;">:</td>
                <td style="border: 1px solid lightgray; padding: 10px;">{{ $payment->transaction_id }}</td>
            </tr>
        </table>
        <br>
        If any query, please contact us. Cell: 8801629400986. <br>
        Thank you!
    </div>
</body>

</html>
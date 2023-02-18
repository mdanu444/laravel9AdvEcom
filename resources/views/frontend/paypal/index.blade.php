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
    <script src="https://www.paypal.com/sdk/js?client-id=AbdLTXEYOXTTZVhECZKs_HwK8QSLtKMxTB428O_bWfqOnG3XMW_QcUyU6a5rcA7yItd9zLNfu-6wlKqF"></script>
</head>
<body>
<div class="container">
    <h1 style="text-align: center;">Payment With Paypal</h1>

    <div style="border-radius: 20px;">
        <table>
            <tr style="background: lightblue; font-weight: bolder;">
                <td>Customer Name</td>
                <td>:</td>
                <td>{{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <td>Order Id</td>
                <td>:</td>
                <td>{{ Session::get('order')->id }}</td>
            </tr>
            <tr>
                <td>Sub Total</td>
                <td>:</td>
                <td>{{ number_format(Session::get('order')->grand_total + Session::get('order')->coupon_amount - Session::get('order')->shipping_charge,2) }}</td>
            </tr>
            <tr>
                <td>Coupon Amount</td>
                <td>:</td>
                <td>({{ number_format(Session::get('order')->coupon_amount,2) }})</td>
            </tr>
            <tr>
                <td>Shipping Charge</td>
                <td>:</td>
                <td>{{ number_format(Session::get('order')->shipping_charge,2) }}</td>
            </tr>
            <tr style="background: lightblue; font-weight: bolder;">
                <td>Grand Total/Payment Amount</td>
                <td>:</td>
                <td>{{ number_format(Session::get('order')->grand_total,2) }}</td>
            </tr>
        </table>
    </div>
    <br>
    <br>

    <div id="paypal-button-container"></div>
</div>

    <script>
      // Render the PayPal button
      paypal.Buttons({
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: "{{ Session::get('order')->grand_total }}",
                currency_code: 'INR'
              },
              description: 'My Product',
              invoice_number: "{{ Session::get('order')->id }}",
              shipping: {
                name: {
                  full_name: "{{ Auth::user()->name }}"
                },
              }
            }],
          });
        },
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
            // all data is in details variable
            console.log('Transaction completed by ' + details.payer.name.given_name + '!');
          });
        }
      }).render('#paypal-button-container');

    </script>

</body>
</html>

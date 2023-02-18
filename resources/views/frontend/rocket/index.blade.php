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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
</head>
<body>
<div class="container">
    <h1 style="text-align: center;">Payment With Rocket</h1>

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

    <button id="bKash_button">Pay With bKash</button>
</div>

<script>
    let paymentID;

    let username = "Your username";
    let password = "Your password";
    let app_key = "Your app key";
    let app_secret = "Your app secret";

    let grantTokenUrl = 'https://checkout.sandbox.bka.sh/v1.2.0-beta/checkout/token/grant';
    let createCheckoutUrl = 'https://checkout.sandbox.bka.sh/v1.2.0-beta/checkout/payment/create';
    let executeCheckoutUrl = 'https://checkout.sandbox.bka.sh/v1.2.0-beta/checkout/payment/execute';

    $(document).ready(function () {
      getAuthToken();
    });

    function getAuthToken() {
      let body = {
        "app_key": app_key,
        "app_secret": app_secret
      };

      $.ajax({
        url: grantTokenUrl,
        headers: {
          "username": username,
          "password": password,
          "Content-Type": "application/json"
        },
        type: 'POST',
        data: JSON.stringify(body),
        success: function (result) {

          let headers = {
            "Content-Type": "application/json",
            "Authorization": result.id_token, // Contains access token
            "X-APP-Key": app_key
          };

          let request = {
            "amount": "85.50",
            "intent": "sale",
            "currency": "BDT",
            "merchantInvoiceNumber": "123456"
          };

          initBkash(headers, request);
        },
        error: function (error) {
          console.log(error);
        }
      });
    }

    function initBkash(headers, request) {
      bKash.init({
        paymentMode: 'checkout',
        paymentRequest: request,

        createRequest: function (request) {
          $.ajax({
            url: createCheckoutUrl,
            headers: headers,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(request),
            success: function (data) {

              if (data && data.paymentID != null) {
                paymentID = data.paymentID;
                bKash.create().onSuccess(data);
              }
              else {
                bKash.create().onError(); // Run clean up code
                alert(data.errorMessage + " Tag should be 2 digit, Length should be 2 digit, Value should be number of character mention in Length, ex. MI041234 , supported tags are MI, MW, RF");
              }

            },
            error: function () {
              bKash.create().onError(); // Run clean up code
              alert(data.errorMessage);
            }
          });
        },
        executeRequestOnAuthorization: function () {
          $.ajax({
            url: executeCheckoutUrl + '/' + paymentID,
            headers: headers,
            type: 'POST',
            contentType: 'application/json',
            success: function (data) {

              if (data && data.paymentID != null) {
                // On success, perform your desired action
                alert('[SUCCESS] data : ' + JSON.stringify(data));
                window.location.href = "/success_page.html";

              } else {
                alert('[ERROR] data : ' + JSON.stringify(data));
                bKash.execute().onError();//run clean up code
              }

            },
            error: function () {
              alert('An alert has occurred during execute');
              bKash.execute().onError(); // Run clean up code
            }
          });
        },
        onClose: function () {
          alert('User has clicked the close button');
        }
      });

      $('#bKash_button').removeAttr('disabled');

    }
  </script>

</body>
</html>

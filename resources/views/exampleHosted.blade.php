<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="SSLCommerz">
    <title>Example - Hosted Checkout | SSLCommerz</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .container {
            padding: 20px;
            margin: auto;
            box-shadow: 0 0 5px lightgray;
            border-radius: 8px;
            margin-top: 50px;
            width: 700px;
            font-family: arial;
        }

        table {
            border-collapse: collapse;
            border-radius: 5px;
            width: 100%;
        }

        table td {
            padding: 10px;
            font-size: 20px;
            border: 1px solid lightgray;
        }
    </style>
</head>

<body class="bg-light">
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
                    <td>{{ number_format(Session::get('order')->grand_total + Session::get('order')->coupon_amount - Session::get('order')->shipping_charge, 2) }}
                    </td>
                </tr>
                <tr>
                    <td>Coupon Amount</td>
                    <td>:</td>
                    <td>({{ number_format(Session::get('order')->coupon_amount, 2) }})</td>
                </tr>
                <tr>
                    <td>Shipping Charge</td>
                    <td>:</td>
                    <td>{{ number_format(Session::get('order')->shipping_charge, 2) }}</td>
                </tr>
                <tr style="background: lightblue; font-weight: bolder;">
                    <td>Grand Total/Payment Amount</td>
                    <td>:</td>
                    <td>{{ number_format(Session::get('order')->grand_total, 2) }}</td>
                </tr>
            </table>
        </div>
        <br>
        <br>
        <div class="row">
            <form action="{{ url('/pay') }}" method="POST" class="needs-validation">
                <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>
</html>

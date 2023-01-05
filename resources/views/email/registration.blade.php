<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
</head>

<body>
    <h2>Hi {{ $name }} ! Welcome to your website.</h2>
    <h3>Your Data is-</h3>
    <table>
        <tr>
            <td>Name :</td>
            <td>{{ $name }}</td>
        </tr>
        <tr>
            <td>Phone :</td>
            <td>{{ $mobile }}</td>
        </tr>
        <tr>
            <td colspan="2">To verefy your account, please <a
                    style="background-color: lightgreen; padding: 5px; border-radius: 3px; font-weight: bold; "
                    href="{{ url('accountverify/' . Crypt::encryptString($id)) }}"> click here</a> </td>
        </tr>
    </table>
    <h2>Thank You for stay with us !</h2>
</body>

</html>

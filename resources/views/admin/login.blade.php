<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body>
    <div class="container">
        <div class="col-md-4 offset-4 mt-4">
            <h1>Admin Login</h1><hr>
            @if ($errors->any())
                <div class="alert alert-danger p-2">
                    @foreach ($errors->all() as $error)
                    <ul>
                        <li>{{$error}}</li>
                    </ul>
                    @endforeach
                </div>
            @endif
            <form action="{{route('admin.check')}}" method="post">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>

                <div class="d-flex justify-content-between">
                    <p>Click the button to login.</p>
                    <input type="submit" class="btn btn-info" value="Login">
                </div>
            </form>
        </div>
    </div>
</body>
</html>

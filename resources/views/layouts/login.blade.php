<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>testio</title>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #000;
                font-family: 'Arial', sans-serif;
                padding: 0;
                margin: 0;
            }
            .content {
                width: 90%;
                margin: 0 auto;
            }
            .login-wrap {
                padding: 20px 0;
                text-align: center;
            }
            .btn {
                display: inline-block;
                padding: 10px;
                text-decoration: none;
                margin: 0;
                color: #fff;
                background-color: #337ab7;
                border-color: #2e6da4;
                font-size: 14px;
                min-width: 70px;
                text-align: center;
                border: 1px solid transparent;
                border-radius: 4px;
            }
            .btn:hover {
                color: #fff;
                background-color: #286090;
                border-color: #204d74;
            }
        </style>
    </head>
    <body>
        <div class="content login-wrap">
            <a href="{{ $loginUrl }}" class="btn">Login with Github</a>
            @if (session()->has('error'))
                <p>{{ session('error') }}</p>
            @endif
        </div>
    </body>
</html>
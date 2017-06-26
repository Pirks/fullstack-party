<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/bootstrap.min.css">


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
            h1 {
                text-align: center;
                font-size: 26px;
                color: #2b542c;
            }
            .content {
                width: 90%;
                margin: 0 auto;
            }
            .table {
                border: 1px solid #ddd;
                border-spacing: 0;
                border-collapse: collapse;
            }
            .table th,
            .table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            .table th a {
                color: #2b542c;
                text-decoration: none;
            }
            .table th a:hover {
                color: #2ab27b;
            }
            .block-wrap {
                margin: 40px 0;
                padding: 20px;
                border: 1px solid #eee;
                border-radius: 4px;
            }
            .issue-info {
                display: inline-block;
                padding-left: 25px;
            }
            .count {
                color: #666;
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
            .state {
                display: inline-block;
                padding: 10px;
                color: #fff;
                background-color: #337ab7;
                border-color: #2e6da4;
                font-size: 14px;
                min-width: 70px;
                text-align: center;
                border: 1px solid transparent;
                border-radius: 4px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="pull-right clearfix">
                        <a href="{{ route('git.logout') }}">Logout</a>
                    </div>                   
                </div>
            </div>
            @yield('content')
        </div>
    </body>
</html>
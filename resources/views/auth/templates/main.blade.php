<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="fonts/icomoon/style.css">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/login.css">

        <title>Laravel</title>
    
    </head>
    <body>
        <div class="d-lg-flex half">
            <div class="bg order-1 order-md-2" style="background-image: url('/img/laptop.jpg');"></div>
                <div class="contents order-2 order-md-1">

                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-7">
                            @include('inc.errors')

                            @yield('main')
                        </div>
                    </div>
                </div>
            </div>            
        </div>

        @yield('js')
    </body>
</html>
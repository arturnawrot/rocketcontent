<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/customer.css">

        <link href="/fontawesome/css/all.css" rel="stylesheet">
    </head>
    <body class="min-vh-100">


        <div class="container-fluid">
            <div class="row">
                
                @include('customer.inc.sidebar')

                <main class="main">
                    <div class="col-sm-12 pt-4 px-4">
                        @include('customer.inc.navbar')

                    </div>

                    <div class="col-sm-12 pt-5 px-4">
                        @include('inc.errors')
                        
                        @yield('content')
                    </div>
                </main>
                
            </div>
        </div>

        <script src="/js/jquery-3.6.0.min.js"></script>
        <script src="/js/bootstrap.bundle.min.js"></script>

        @yield('js')
    </body>
</html>
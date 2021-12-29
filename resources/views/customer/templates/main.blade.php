<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/customer.css">
    </head>
    <body class="min-vh-100">


        <div class="container-fluid">
            <div class="row">
                
                @include('customer.inc.sidebar')

                <main class="px-md-5">
                    <div class="col-md-9 ms-sm-auto col-lg-10 pt-4 px-4">
                        @include('customer.inc.navbar')

                    </div>

                    <div class="col-md-9 ms-sm-auto col-lg-10 pt-md-5 px-4">
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
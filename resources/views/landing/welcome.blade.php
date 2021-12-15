<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/landing.css">

        <title>Laravel</title>

    </head>
    <body>
        @include('inc.navbar')

        <div class="gap-between-hero-and-navbar">
            @include('landing/landing-page-sections.hero-section')
        </div>

        <div class="mt-5">
            @include('landing/landing-page-sections.2-section')
        </div>

        <div class="mt-5">
            @include('landing/landing-page-sections.3-section')
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="admin/images/favicon.svg"
      type="image/x-icon"
    />
    <title>Blank Page | PlainAdmin Demo</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="/admin/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/admin/css/lineicons.css" />
    <link rel="stylesheet" href="/admin/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="/admin/css/fullcalendar.css" />
    <link rel="stylesheet" href="/admin/css/main.css" />
  </head>
  <body>

    @include('admin.inc.sidebar')

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">

      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="titlemb-30">
                  <h2>@yield('page_title')</h2>
                </div>
              </div>
              <!-- end col -->
              <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="#0">Dashboard</a>
                        @yield('breadcrumbs')
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        @yield('breadcrumbs.current_page')
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
              <!-- end col -->
            </div>
            @yield('content')
            <!-- end row -->
          </div>
          <!-- ========== title-wrapper end ========== -->
        </div>
        <!-- end container -->
      </section>
      <!-- ========== section end ========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="/admin/js/bootstrap.bundle.min.js"></script>
    <script src="/admin/js/Chart.min.js"></script>
    <script src="/admin/js/dynamic-pie-chart.js"></script>
    <script src="/admin/js/moment.min.js"></script>
    <script src="/admin/js/fullcalendar.js"></script>
    <script src="/admin/js/jvectormap.min.js"></script>
    <script src="/admin/js/world-merc.js"></script>
    <script src="/admin/js/polyfill.js"></script>
    <script src="/admin/js/main.js"></script>
  </body>
</html>

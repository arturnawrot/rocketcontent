<nav class="navbar navbar-expand-lg">
  <div class="container navbar-container">
    <!-- <a class="navbar-brand" href="#">rocketcontent.io</a> -->
    <a href="/">
      <img src="/svg/logo.svg" id="logo" />
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Resources</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Jobs</a>
        </li>
      </ul>
      <ul class="navbar-nav d-none d-lg-flex ml-2 order-3">
          <li class="nav-item"><a class="nav-link button" href="{{ route('auth.login.view') }}">Sign In</a></li>
      </ul>
    </div>
  </div>
</nav>
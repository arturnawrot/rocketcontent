<header class="navbar flex-md-nowrap pt-4">
  <h1 id="page-title">Dashboard</h1>

    <div class="d-flex">
      <button id="collapse-button" class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

    <div class="d-flex">
        <img src="{{ auth()->user()->getAvatarUrl() }}" id="avatar">
        <span id="name">{{ auth()->user()->name }}</span>
    </div>



    <!-- <div id="navbar-elements-that-disappear-on-mobile" class="d-flex">
      <button id="request-content-button" type="button">Request new content</button>
    </div> -->
  <!-- <img src="/svg/logo.svg" class="navbar-brand col-md-3 col-lg-2 me-0 px-3"/> -->

  <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="#">Sign out</a>
    </div>
  </div> -->
</header>
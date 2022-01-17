<nav id="sidebarMenu" class="navbar-collapse collapse col-md-3 col-lg-2 d-md-block bg-light sidebar">
      <div class="sidebar-sticky text-center text-md-start">
        <ul class="nav flex-column">
          
          <div class="d-block mx-auto mt-4">
            <img src="/svg/logo.svg" id="logo"/>
          </div>


          <div class="nav-item mx-auto d-block mt-5">
            <img src="{{ auth()->user()->getAvatarUrl() }}" id="avatar">
          </div>

          <div class="nav-item text-center mt-3">
            <span id="name">{{ auth()->user()->name }}</span>
          </div>

          @if(auth()->user()->isOnTrial())
          <div class="nav-item text-center mt-3">
            <span id="trial-message">
                Worry-Free Trial: <br/>
                {{ auth()->user()->present()->daysBeforeTrialEnds() }} Days Remaining
            </span>
          </div>
          @endif


          <li id="sidebar-elements-that-show-up-on-mobile">
            <div class="m-0 my-4 mx-auto d-block">
              <button id="request-content-button" type="button">Request new content</button>
            </div>
          </li>
          

          <div id="sidebar-navigation-links" class="mt-md-3 d-block mx-auto">
              <li class="nav-item mt-md-4">
                <a class="nav-link active" aria-current="page" href="#">
                  <span data-feather="home"></span>
                  Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file"></span>
                  Content
                </a>
              </li>              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file"></span>
                  Resources
                </a>
              </li>              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file"></span>
                  Information
                </a>
              </li>              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file"></span>
                  Orders
                </a>
              </li>
          </div>

        </ul>
      </div>
</nav>
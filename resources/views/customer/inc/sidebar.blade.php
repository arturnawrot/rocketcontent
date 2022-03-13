<nav id="sidebarMenu" class="navbar-collapse collapse d-md-block bg-light sidebar">
      <div class="sidebar-sticky text-center text-sm-start ">
        <ul class="nav flex-column">
          
          <div class="my-4 d-block mx-auto">
            <img src="/svg/logo.svg" id="logo"/>
          </div>


          <!-- <div class="nav-item mx-auto d-block mt-5">
            <img src="{{ auth()->user()->getAvatarUrl() }}" id="avatar">
          </div>

          <div class="nav-item text-center mt-3">
            <span id="name">{{ auth()->user()->name }}</span>
          </div> -->

          <!-- @if(auth()->user()->isOnTrial())
          <div class="nav-item text-center mt-3">
            <span id="trial-message">
                Worry-Free Trial: <br/>
                {{ auth()->user()->present()->daysBeforeTrialEnds() }} Days Remaining
            </span>
          </div>
          @endif -->

          

          <div class="mt-md-3 d-block mx-auto">
              <!-- <li id="sidebar-elements-that-show-up-on-mobile"> -->
              <li>
                <div class="m-0 mb-4">
                  <button id="request-content-button" type="button">Request Content</button>
                </div>
              </li>

              <div id="sidebar-navigation-links" class="mt-5">
                <li class="nav-item mt-md-4">
                  <a class="nav-link active" aria-current="page" href="#">
                    <i class="far fa-copy"></i>
                    Dashboard
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="far fa-life-ring"></i>
                    Content
                  </a>
                </li>              
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="far fa-address-card"></i>
                    Resources
                  </a>
                </li>              
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="far fa-folder-open"></i>                    
                    Information
                  </a>
                </li>              
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="far fa-trash-alt"></i>
                    Orders
                  </a>
                </li>
              </div>

          </div>

          <div class="d-block mx-auto">
              <div class="progress blue"> <span class="progress-left"> <span class="progress-bar"></span> </span> <span class="progress-right"> <span class="progress-bar"></span> </span>
                  <div class="progress-value">90%</div>
              </div>
          </div>


        </ul>
      </div>
</nav>
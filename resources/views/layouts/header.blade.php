<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div  class="navbar-brand-inner-wrapper-dark d-flex justify-content-center">
            {{-- <a class="navbar-brand brand-logo" href="index.html"><img src="images/logo.svg" alt="logo"/></a>
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"/></a> --}}
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="typcn typcn-th-menu"></span>


            </button>
        </div>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
                    {{-- <img src="asset/images/faces/face5.jpg" alt="profile"/>
              <span class="nav-profile-name">Eugenia Mullins</span> --}}
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item">
                        <i class="typcn typcn-cog-outline text-primary"></i>
                        Settings
                    </a>



                    <!-- <a class="dropdown-item">
                <i class="typcn typcn-eject text-primary"></i>
                Logout
              </a> -->
                </div>
            </li>
            {{-- <li class="nav-item nav-user-status dropdown">
              <p class="mb-0">Last login was 23 hours ago.</p>
          </li> --}}
        </ul>
        <ul>


        </ul>
        <h3> Syafana Jaya Motor</h3>

        <ul class="navbar-nav navbar-nav-right">
      
            <li class="nav-item nav-date dropdown">
                <a class="nav-link d-flex justify-content-center align-items-center" href="javascript:;">
                    <h6 class="date mb-0">{{Auth::user()->name}}</h6> &nbsp;
                    @if (Auth::user()->karyawan)(Karyawan) @elseif(Auth::user()->admin)({{Auth::user()->admin->role}}) @endif
                </a>
            </li>
            <li class="nav-item dropdown">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a class="dropdown-item" onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    <i class="typcn typcn-eject text-primary"></i>
                    Logout
                </a>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
</nav>
<!-- partial -->
{{-- <nav class="navbar-breadcrumb col-xl-12 col-12 d-flex flex-row p-0">
    <div class="navbar-links-wrapper d-flex align-items-stretch" style="opacity: 0">
        <div class="nav-link">
            <a href="javascript:;"><i class="typcn typcn-calendar-outline"></i></a>
        </div>
        <div class="nav-link">
            <a href="javascript:;"><i class="typcn typcn-mail"></i></a>
        </div>
        <div class="nav-link">
            <a href="javascript:;"><i class="typcn typcn-folder"></i></a>
        </div>
        <div class="nav-link">
            <a href="javascript:;"><i class="typcn typcn-document-text"></i></a>
        </div>
    </div> --}}
    {{-- <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item ml-0">
                <h4 class="mb-0">Dashboard</h4>
            </li>
            <li class="nav-item">
            <div class="d-flex align-items-baseline">
              <p class="mb-0">Home</p>
              <i class="typcn typcn-chevron-right"></i>
              <p class="mb-0">Main Dahboard</p>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-search d-none d-md-block mr-0">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search..." aria-label="search" aria-describedby="search">
              <div class="input-group-prepend">
                <span class="input-group-text" id="search">
                  <i class="typcn typcn-zoom"></i>
                </span>
              </div>
            </div>
          </li>
        </ul>
    </div> --}}
{{-- </nav> --}}

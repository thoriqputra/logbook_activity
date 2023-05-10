<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl position-sticky blur shadow-blur my-4 left-auto z-index-1 bg-white" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                @if(Request::segment(1) == 'home')
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Home</li>
                @elseif(Request::segment(1) == 'logbook')
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Logbook</li>
                @endif
            </ol>
            @if(Request::segment(1) == 'home')
            <h6 class="font-weight-bolder mb-0">Home</h6>
            @elseif(Request::segment(1) == 'logbook')
            <h6 class="font-weight-bolder mb-0">Logbook</h6>
            @endif
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item dropdown me-5 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer fa-xl ">
                            <div class="pulse"></div>
                            <div class="marker"></div>
                        </i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-1 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <div id="data-notification" style="height: 250px;overflow-x: hidden; overflow-y: auto;"></div>
                    </ul>
                </li>
                <li class="nav-item dropdown d-flex align-items-center" id="account">
                    <a href="javascript:;" class="nav-link text-body font-weight-bold p-0" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-3 me-5">
                                <li class="breadcrumb-item text-sm" aria-current="page">
                                    <i class="fa-solid fa-user"></i>
                                    <span class="ms-2 d-sm-inline d-none">{{ Auth::user()->profile->name }}</span>
                                </li>
                            </ol>
                            <h6 class="fw-normal mb-0">{{ Auth::user()->role->name }}</h6>
                        </nav>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 m-n4" aria-labelledby="dropdownUser">
                        <li>
                            <a class="dropdown-item border-radius-md" href="{{ url('home/edit-profile') }}">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                        Edit Profile
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                        Logout
                                        </h6>
                                    </div>
                                </div>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            </form>   
                        </li>
                    </ul>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
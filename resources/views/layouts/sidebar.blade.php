<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3  bg-white" id="sidenav-main">
  <div class="sidenav-header" style="text-align: center;">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="{{ url('home') }}" target="_blank">
      <img src="{{ asset('assets/img/logot-agit.png') }}" class="navbar-brand-img h-100" alt="main_logo">
      <!-- <span class="ms-3 fs-5 font-weight-bold">AGIT</span> -->
    </a>
  </div>
  
  <hr class="horizontal dark mt-0">
  
  <div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav" >
      <li class="nav-item">
        <a class="nav-link <?php echo (Request::segment(1) === 'home' ? 'active' : '') ?>" href="{{ url('home') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg version="1.2" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF" fill-rule="nonzero">
                  <g transform="translate(1716.000000, 291.000000)">
                    <g transform="translate(0.000000, 148.000000)">
                    <path class="color-background opacity-6" d="M12,3c0,0-6.186,5.34-9.643,8.232C2.154,11.416,2,11.684,2,12c0,0.553,0.447,1,1,1h2v7c0,0.553,0.447,1,1,1h3  c0.553,0,1-0.448,1-1v-4h4v4c0,0.552,0.447,1,1,1h3c0.553,0,1-0.447,1-1v-7h2c0.553,0,1-0.447,1-1c0-0.316-0.154-0.584-0.383-0.768  C18.184,8.34,12,3,12,3z"/>
                    <path class="color-background" d="M12,3c0,0-6.186,5.34-9.643,8.232C2.154,11.416,2,11.684,2,12c0,0.553,0.447,1,1,1h2v7c0,0.553,0.447,1,1,1h3  c0.553,0,1-0.448,1-1v-4h4v4c0,0.552,0.447,1,1,1h3c0.553,0,1-0.447,1-1v-7h2c0.553,0,1-0.447,1-1c0-0.316-0.154-0.584-0.383-0.768  C18.184,8.34,12,3,12,3z"/>
                    </g>
                  </g>
                </g>
              </g>
            </svg>
          </div>
          <span class="nav-link-text ms-1">Home</span>
        </a>
      </li>
      @if(\Auth::user()->role_id === 1)
      <li class="nav-item">
        <a class="nav-link <?php echo (Request::segment(1) === 'user_management' ? 'active' : '') ?>" href="{{ url('user_management') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg enable-background="new 0 0 32 32" height="32px" id="svg2" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg">
              <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF" fill-rule="nonzero">
                <g transform="translate(1716.000000, 291.000000)">
                  <g transform="translate(0.000000, 148.000000)">
                    <path class="color-background opacity-6" d="M32,23c-0.002-4.973-4.029-9-9-9c-0.025,0-0.049,0.003-0.074,0.004C23.608,12.826,24,11.459,24,10c0-4.418-3.582-8-8-8   c-4.418,0-8,3.582-8,8c0,4.26,3.332,7.732,7.531,7.977c-0.419,0.622-0.753,1.304-1.008,2.023H4c-4,0-4,4-4,4v8h32v-8   C32,24,32,23.207,32,23z M29.883,23c-0.009,3.799-3.084,6.874-6.883,6.883c-3.801-0.009-6.876-3.084-6.885-6.883   c0.009-3.801,3.084-6.876,6.885-6.884C26.799,16.124,29.874,19.199,29.883,23z"/>
                    <path class="color-background opacity-6" d="M28,24v-2.001h-1.663c-0.063-0.212-0.145-0.413-0.245-0.606l1.187-1.187l-1.416-1.415l-1.165,1.166   c-0.22-0.123-0.452-0.221-0.697-0.294V18h-2v1.662c-0.229,0.068-0.446,0.158-0.652,0.27l-1.141-1.14l-1.415,1.415l1.14,1.14   c-0.112,0.207-0.202,0.424-0.271,0.653H18v2h1.662c0.073,0.246,0.172,0.479,0.295,0.698l-1.165,1.163l1.413,1.416l1.188-1.187   c0.192,0.101,0.394,0.182,0.605,0.245V28H24v-1.665c0.229-0.068,0.445-0.158,0.651-0.27l1.212,1.212l1.414-1.416l-1.212-1.21   c0.111-0.206,0.201-0.423,0.27-0.651H28z M22.999,24.499c-0.829-0.002-1.498-0.671-1.501-1.5c0.003-0.829,0.672-1.498,1.501-1.501   c0.829,0.003,1.498,0.672,1.5,1.501C24.497,23.828,23.828,24.497,22.999,24.499z"/>
                    <path class="color-background" d="M32,23c-0.002-4.973-4.029-9-9-9c-0.025,0-0.049,0.003-0.074,0.004C23.608,12.826,24,11.459,24,10c0-4.418-3.582-8-8-8   c-4.418,0-8,3.582-8,8c0,4.26,3.332,7.732,7.531,7.977c-0.419,0.622-0.753,1.304-1.008,2.023H4c-4,0-4,4-4,4v8h32v-8   C32,24,32,23.207,32,23z M29.883,23c-0.009,3.799-3.084,6.874-6.883,6.883c-3.801-0.009-6.876-3.084-6.885-6.883   c0.009-3.801,3.084-6.876,6.885-6.884C26.799,16.124,29.874,19.199,29.883,23z"/>
                    <path class="color-background" d="M28,24v-2.001h-1.663c-0.063-0.212-0.145-0.413-0.245-0.606l1.187-1.187l-1.416-1.415l-1.165,1.166   c-0.22-0.123-0.452-0.221-0.697-0.294V18h-2v1.662c-0.229,0.068-0.446,0.158-0.652,0.27l-1.141-1.14l-1.415,1.415l1.14,1.14   c-0.112,0.207-0.202,0.424-0.271,0.653H18v2h1.662c0.073,0.246,0.172,0.479,0.295,0.698l-1.165,1.163l1.413,1.416l1.188-1.187   c0.192,0.101,0.394,0.182,0.605,0.245V28H24v-1.665c0.229-0.068,0.445-0.158,0.651-0.27l1.212,1.212l1.414-1.416l-1.212-1.21   c0.111-0.206,0.201-0.423,0.27-0.651H28z M22.999,24.499c-0.829-0.002-1.498-0.671-1.501-1.5c0.003-0.829,0.672-1.498,1.501-1.501   c0.829,0.003,1.498,0.672,1.5,1.501C24.497,23.828,23.828,24.497,22.999,24.499z"/>
                  </g>
                </g>
              </g>
            </svg>
          </div>
          <span class="nav-link-text ms-1">User Management</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo (Request::segment(1) === 'configuration' ? 'active' : 'collapsed') ?>" href="#sub-menu" data-bs-toggle="collapse" id="parent-menu">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
          <svg baseProfile="tiny" height="24px" id="Layer_1" version="1.2" viewBox="2 0 18 24" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF" fill-rule="nonzero">
                  <g transform="translate(1716.000000, 291.000000)">
                    <g transform="translate(0.000000, 148.000000)">
                    <path class="color-background opacity-6" d="M9.387,17.548l0.371,1.482C9.891,19.563,10.45,20,11,20h1c0.55,0,1.109-0.437,1.242-0.97l0.371-1.482  c0.133-0.533,0.675-0.846,1.203-0.694l1.467,0.42c0.529,0.151,1.188-0.114,1.462-0.591l0.5-0.867  c0.274-0.477,0.177-1.179-0.219-1.562l-1.098-1.061c-0.396-0.383-0.396-1.008,0.001-1.39l1.096-1.061  c0.396-0.382,0.494-1.084,0.22-1.561l-0.501-0.867c-0.275-0.477-0.933-0.742-1.461-0.591l-1.467,0.42  c-0.529,0.151-1.07-0.161-1.204-0.694l-0.37-1.48C13.109,5.437,12.55,5,12,5h-1c-0.55,0-1.109,0.437-1.242,0.97l-0.37,1.48  C9.254,7.983,8.713,8.296,8.184,8.145l-1.467-0.42C6.188,7.573,5.529,7.839,5.255,8.315l-0.5,0.867  c-0.274,0.477-0.177,1.179,0.22,1.562l1.096,1.059c0.395,0.383,0.395,1.008,0,1.391l-1.098,1.061  c-0.395,0.383-0.494,1.085-0.219,1.562l0.501,0.867c0.274,0.477,0.933,0.742,1.462,0.591l1.467-0.42  C8.712,16.702,9.254,17.015,9.387,17.548z M11.5,10.5c1.104,0,2,0.895,2,2c0,1.104-0.896,2-2,2s-2-0.896-2-2  C9.5,11.395,10.396,10.5,11.5,10.5z"/>
                    <path class="color-background" d="M9.387,17.548l0.371,1.482C9.891,19.563,10.45,20,11,20h1c0.55,0,1.109-0.437,1.242-0.97l0.371-1.482  c0.133-0.533,0.675-0.846,1.203-0.694l1.467,0.42c0.529,0.151,1.188-0.114,1.462-0.591l0.5-0.867  c0.274-0.477,0.177-1.179-0.219-1.562l-1.098-1.061c-0.396-0.383-0.396-1.008,0.001-1.39l1.096-1.061  c0.396-0.382,0.494-1.084,0.22-1.561l-0.501-0.867c-0.275-0.477-0.933-0.742-1.461-0.591l-1.467,0.42  c-0.529,0.151-1.07-0.161-1.204-0.694l-0.37-1.48C13.109,5.437,12.55,5,12,5h-1c-0.55,0-1.109,0.437-1.242,0.97l-0.37,1.48  C9.254,7.983,8.713,8.296,8.184,8.145l-1.467-0.42C6.188,7.573,5.529,7.839,5.255,8.315l-0.5,0.867  c-0.274,0.477-0.177,1.179,0.22,1.562l1.096,1.059c0.395,0.383,0.395,1.008,0,1.391l-1.098,1.061  c-0.395,0.383-0.494,1.085-0.219,1.562l0.501,0.867c0.274,0.477,0.933,0.742,1.462,0.591l1.467-0.42  C8.712,16.702,9.254,17.015,9.387,17.548z M11.5,10.5c1.104,0,2,0.895,2,2c0,1.104-0.896,2-2,2s-2-0.896-2-2  C9.5,11.395,10.396,10.5,11.5,10.5z"/>
                    </g>
                  </g>
                </g>
              </g>
            </svg>
          </div>
          <span class="nav-link-text ms-1">Configuration</span>
        </a>
        <ul class="collapse nav ms-6" id="sub-menu" >
          <li class="nav-item">
            <a href="{{ url('configuration/activity') }}" class="nav-link <?php echo (Request::segment(2) === 'activity' ? 'active' : '') ?>"> <span class="d-none d-sm-inline">Activity</a>
          </li>
          <li class="nav-item">
            <a href="{{ url('configuration/activity_type') }}" class="nav-link <?php echo (Request::segment(2) === 'activity_type' ? 'active' : '') ?>"> <span class="d-none d-sm-inline">Activity Type</a>
          </li>
          <li class="nav-item">
            <a href="{{ url('configuration/channel_requestor') }}" class="nav-link <?php echo (Request::segment(2) === 'channel_requestor' ? 'active' : '') ?>"> <span class="d-none d-sm-inline">Channel Requestor</a>
          </li>
          <li class="nav-item">
            <a href="{{ url('configuration/requestor') }}" class="nav-link <?php echo (Request::segment(2) === 'requestor' ? 'active' : '') ?>"> <span class="d-none d-sm-inline">Requestor</a>
          </li>
          <li class="nav-item">
            <a href="{{ url('configuration/role') }}" class="nav-link <?php echo (Request::segment(2) === 'role' ? 'active' : '') ?>"> <span class="d-none d-sm-inline">Role</a>
          </li>
          <li class="nav-item">
            <a href="{{ url('configuration/support_department') }}" class="nav-link <?php echo (Request::segment(2) === 'support_department' ? 'active' : '') ?>"> <span class="d-none d-sm-inline">Support Department</a>
          </li>
        </ul>
      </li>
      @endif
      <li class="nav-item">
        <a class="nav-link <?php echo (Request::segment(1) === 'logbook' ? 'active' : '') ?>" href="{{ url('logbook') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg height="18px" version="1.1" viewBox="0 0 18 18" width="18px" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink">
              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF" fill-rule="nonzero">
                  <g transform="translate(1716.000000, 291.000000)">
                    <g transform="translate(0.000000, 148.000000)">
                      <path class="color-background opacity-6" d="M16,0 L2,0 C0.9,0 0,0.9 0,2 L0,16 C0,17.1 0.9,18 2,18 L16,18 C17.1,18 18,17.1 18,16 L18,2 C18,0.9 17.1,0 16,0 L16,0 Z M6,14 L4,14 L4,12 L6,12 L6,14 L6,14 Z M6,10 L4,10 L4,8 L6,8 L6,10 L6,10 Z M6,6 L4,6 L4,4 L6,4 L6,6 L6,6 Z M14,14 L7,14 L7,12 L14,12 L14,14 L14,14 Z M14,10 L7,10 L7,8 L14,8 L14,10 L14,10 Z M14,6 L7,6 L7,4 L14,4 L14,6 L14,6 Z" id="Shape"/>
                      <path class="color-background" d="M16,0 L2,0 C0.9,0 0,0.9 0,2 L0,16 C0,17.1 0.9,18 2,18 L16,18 C17.1,18 18,17.1 18,16 L18,2 C18,0.9 17.1,0 16,0 L16,0 Z M6,14 L4,14 L4,12 L6,12 L6,14 L6,14 Z M6,10 L4,10 L4,8 L6,8 L6,10 L6,10 Z M6,6 L4,6 L4,4 L6,4 L6,6 L6,6 Z M14,14 L7,14 L7,12 L14,12 L14,14 L14,14 Z M14,10 L7,10 L7,8 L14,8 L14,10 L14,10 Z M14,6 L7,6 L7,4 L14,4 L14,6 L14,6 Z" id="Shape"/>
                    </g>
                  </g>
                </g>
              </g>
            </svg>
          </div>
          <span class="nav-link-text ms-1">Logbook</span>
        </a>
      </li>
    </ul>
  </div>
</aside>
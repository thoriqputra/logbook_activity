<!DOCTYPE html>
<html lang="en">

<head>
    <title>Logbook | @yield('title')</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/icon_telkomsel.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logot-agit.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-svg.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-svg.css') }}"/>
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
    <!-- Sweet Alert CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}" />
    <!-- DataTable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/css/datatables.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.1/css/fixedHeader.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css" />
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2-bootstrap-5-theme.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/dropify/dist/css/dropify.min.css') }}" />
    
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.css' rel='stylesheet'>

    <style>
        .required {
            display: inline-block;
            color: #d2322d;
            font-size: 0.8em;
            font-weight: bold;
            position: relative;
            top: -0.2em;
        }
        .btn {
            padding: 0.575rem 0.75rem !important;
        }
        .pulse {
            position: relative;
            top: -15px;
            left: 6.5px;
            height: 15px;
            width: 15px;    
            z-index: 10;  
            border: 5px solid #ef5350;
            border-radius: 70px;
            animation: pulse 1s ease-out infinite;
        }
        .marker {
            position: relative;
            top: -25px;
            left: 11px;
            height: 6px;
            width: 6px;  
            border-radius: 70px;
            background: red;
        }
        @keyframes pulse {
            0% {
                -webkit-transform: scale(0);
                opacity: 0.0;
            }

            25% {
                -webkit-transform: scale(0.1);
                opacity: 0.1;
            }

            50% {
                -webkit-transform: scale(0.5);
                opacity: 0.3;
            }

            75% {
                -webkit-transform: scale(0.8);
                opacity: 0.5;
                }

            100% {
                -webkit-transform: scale(1);
                opacity: 0.0;
            }
        } 
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    @include('layouts.sidebar')

    <main class="main-content position-relative border-radius-lg">
        @include('layouts.navbar')

        @yield('content')

        <script>
            window.laravel_echo_port    = '{{ env("LARAVEL_ECHO_PORT") }}';
        </script>
        
        <!--   Core JS Files   -->
        <script src="//{{ Request::getHost() }}:{{ env("LARAVEL_ECHO_PORT") }}/socket.io/socket.io.js"></script>
        <script src="{{ asset('js/laravel-echo-setup.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/export-html-to-excel/src/jquery.table2excel.js') }}"></script>
        <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.min.js') }}"></script>
        <!-- DataTables JS -->
        <script src="{{ asset('assets/vendor/datatables/js/datatables.min.js') }}"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.3.1/js/dataTables.fixedHeader.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
        <!-- Select2 JS -->
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
        <!-- Sweet Alert CSS -->
        <script src="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.js') }}"></script>
        <script src="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/dropify/dist/js/dropify.min.js') }}"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js"></script>
        <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.4') }}"></script>

        <script type="text/javascript">
            window.Echo.channel('notification').listen('NotificationEvent', (e) => {
                getAllNotification()
            });

            let authId = {{ Auth::user()->id }};

            $(document).ready(function() {
                getAllNotification()

                let segment_1 = "{{ Request::segment(1) }}",
                    segment_2 = "{{ Request::segment(2) }}";

                if(segment_1 === "configuration" && segment_2 !== ""){
                    $("#sub-menu").addClass('show')
                    $("#parent-menu").attr("aria-expanded","true");
                }
            });

            const getAllNotification = () => {
                let	url	= "{{ url('notification') }}";

                $.ajax({
                    type    : "GET",
                    url     : url,
                    beforeSend: function() {
                        
                    },
                    success: function (response){
                        let html	= `
                            <div class="row">
                                <div class="justify-content-center text-center py-2">
                                    <p>You have `+response.count+`  out of `+response.total+` unread messages</p>
                                </div>  
                                <div class="justify-content-center text-center">
                                    <button class="btn btn-sm btn-danger" onclick="markAllAsRead()">Mark All as read</button>
                                </div>
                            </div>`;
                        
                        response['data'].forEach((value, index) => {
                            if(value.notification_data !== null){
                                let decode_message	= JSON.parse(value.notification_data);
                
                                let new_message	= "";
                                let timestamp	= "";

                                if(value.read_at === null){
                                    new_message	= '<span class="font-weight-bold badge bg-gradient-danger">New message</span>';

                                    timestamp	= value.created_at;
                                }else{
                                    timestamp	= value.read_at;
                                }

                                let notification_image  = "";
                                if(value.notification_image !== null){
                                    notification_image  = `<img src="{{ asset('') }}`+value.notification_image+`" class="avatar avatar-sm me-3 ">`;
                                }else{
                                    notification_image  = `<img src="{{asset('/assets/img/team-2.jpg')}}" class="avatar avatar-sm me-3 ">`;
                                }
                                html +=
                                `<li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                `+notification_image+`
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                `+new_message+`
                                                `+decode_message['message']+`
                                                </h6>
                                                <p class="text-xs text-secondary mb-0 ">
                                                    <i class="fa fa-clock me-1"></i>
                                                    `+timestamp+`
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>`;
                            }
                        })

                        $('#data-notification').html(html)
                    },
                    complete: function() {

                    }
                });
            }

            const markAllAsRead = () => {
                let	url	= "{{ url('notification/markAllAsRead') }}";

                $.ajax({
                    type    : "GET",
                    url     : url,
                    beforeSend: function() {
                        
                    },
                    success: function (response){
                        let html	= `
                            <div class="row">
                                <div class="justify-content-center text-center py-2">
                                    <p>You have `+response.count+`  out of `+response.total+` unread messages</p>
                                </div>  
                                <div class="text-center">
                                    <button class="btn btn-sm btn-danger" onclick="markAllAsRead()">Mark All as read</button>
                                </div>
                            </div>`;
                        
                        response['data'].forEach((value, index) => {
                            let decode_message	= JSON.parse(value.notification_data);
                            
                            html +=
                            `<li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{asset('/assets/img/team-2.jpg')}}" class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                        `+decode_message['message']+`
                                        </h6>
                                        <p class="text-xs text-secondary mb-0 ">
                                        <i class="fa fa-clock me-1"></i>
                                        `+value.read_at+`
                                        </p>
                                    </div>
                                    </div>
                                </a>

                            </li>`;
                        })

                        $('#data-notification').html(html)
                    },
                    complete: function() {

                    }
                });
            }
        </script>
        @include('layouts.template_js')
        
    </main>
</body>
</html>
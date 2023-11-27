<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Version: 5.0.5
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>@lang("alnkel.ASFAR")</title>
    <meta name="description" content="Latest updates and statistic charts">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Montserrat:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <!--begin::Page Vendors -->
    <link href="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet"
          href="{{ asset('front-assets/bower_components/jquery-confirm2/dist/jquery-confirm.min.css') }}">
    <!--end::Page Vendors -->
    <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/demo/demo3/base/style.bundle.css') }}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/dt-1.10.18/fc-3.2.5/r-2.2.2/datatables.min.css"/>
    <!--end::Base Styles -->
    @yield('styles')
    <link href="{{ asset('custom/style.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="{{ asset('assets/demo/demo3/media/img/logo/favicon.ico') }}"/>
  <style>
       
      /* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
      
    </style>
  
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
@include('includes.header')
<!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        @include('includes.sidebar')
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <!-- BEGIN: Subheader -->
            @hasSection('sub-header')
                <div class="m-subheader ">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h3 class="m-subheader__title ">
                                @yield('sub-header')
                            </h3>
                        </div>
                    </div>
                </div>
            @endif

        <!-- END: Subheader -->
            <div class="m-content">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- end:: Body -->
    @include('includes.footer')
</div>
<!-- end:: Page -->

<!-- begin::Scroll Top -->
<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500"
     data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->
<!--begin::Base Scripts -->
<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/demo3/base/scripts.bundle.js') }}" type="text/javascript"></script>
<!--end::Base Scripts -->
<!--begin::Page Vendors -->
<script src="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
<!--end::Page Vendors -->
<!--begin::Page Snippets -->
<script src="{{ asset('assets/app/js/dashboard.js') }}" type="text/javascript"></script>
<script src="{{ asset('front-assets/js/confirmation.js') }}" type="text/javascript"></script>
<!--end::Page Snippets -->
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<!-- DataTables -->
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/dt-1.10.18/fc-3.2.5/r-2.2.2/datatables.min.js"></script>

@if(Auth::check())
    <script>
        var pusher = new Pusher('e9733d3e9c86d4be27b3', {
            cluster: 'eu',
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            encrypted: true
        });

        var channel = pusher.subscribe('private-App.User.' + "{{ Auth::user()->id }}");
        channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function (data) {
            $('#no-notifications').addClass('m--hide');
            $('#notification-counter').removeClass('m--hide');
            $('#notification-text').removeClass('m--hide');
            $('#alert').addClass('m-badge--danger');

            $('#notification-counter').text(parseInt($('#notification-counter').text()) + 1);
            $('#notificationsArea').prepend(
                "<div class='m-list-timeline__item'><span class='m-list-timeline__badge -m-list-timeline__badge--state-success'></span>" +
                "<span class='m-list-timeline__text message' data-notification-id='" + data.id + "' data-url='" + data.data.url + "'>" + data.data.message +
                "<span class='m-badge m-badge--danger m-badge--wide'>new</span></span>" +
                "<span class='m-list-timeline__time'>now</span></div>"
            );
        });
    </script>
@endif

<script src="{{ asset('front-assets/bower_components/jquery-confirm2/dist/jquery-confirm.min.js') }}"></script>

<script>
    $(document).on('click', '.message', function () {
        let notification_id = $(this).data('notification-id');
        let url = $(this).data('url');

        let data = {
            'id': notification_id,
            '_token': $('meta[name=csrf-token]').attr("content")
        };

        $.post('{{ route('read-notification') }}', data, function (response) {
            if (response.success) {
                window.location = url;
            }
        });
    });

    $('.confirm').confirm({
        buttons: {
            confirm: function () {
                location.href = this.$target.attr('href');
            }
        }
    });
</script>

@include('includes.confirm')

@yield('scripts')

@yield('footer')
</body>
<!-- end::Body -->
</html>
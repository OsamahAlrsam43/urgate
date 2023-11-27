<!doctype html>
<head>
    <title>
        @if(App::isLocale('en'))
            Al-Nakheel Group for Tourism and Travel
        @elseif(App::isLocale('ar'))
            مجموعة النخيل والتيسير للسياحة والسفر
        @endif
        @yield('title')</title>
    <!-- Start meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=0.1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- End meta -->

    <!-- Start favicon -->
    <link rel="shortcut icon" href="{{ asset('front-assets/images/favicon/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('front-assets/images/favicon/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="72x72"
          href="{{ asset('front-assets/images/favicon/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114"
          href="{{ asset('front-assets/images/favicon/apple-touch-icon-114x114.png') }}">
    <!-- End favicon -->

    <!-- Start CSS -->
    @if(App::isLocale('en'))
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/breakingNews-ltr.css') }}">
    @elseif(App::isLocale('ar'))
        <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/gefont/font.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/breakingNews.css') }}">
    @endif
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <!--<link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">-->

    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/icon8/styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/OwlCarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/mediaqueryes.css?=r2') }}">
    @if(App::isLocale('en'))
        <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/ltr.css') }}">
    @endif
<!-- End CSS -->

    @yield('style')

    <style>
        input{
            text-transform: uppercase;
        }
    </style>

    <!-- Start html5 shiv -->
    <script src="{{ asset('front-assets/js/jquery.modernizr.js') }}"></script>
    <!-- End html5 shiv -->

    {!! NoCaptcha::renderJs() !!}
</head>

<body>
<!-- Start mobile-menu -->
<div class="mobile-menu">
    <ul>
        <li>
            <a href="{{ route('front-home') }}" class="d-flex align-items-center scale-icons-hover">
                <i class="icons8-home-page"></i>
                <span>@lang("alnkel.header-menu-main")</span>
            </a>
        </li>
        <li>
            <a href="{{ route('travels') }}" class="d-flex align-items-center scale-icons-hover">
                <i class="icons8-country"></i>
                <span>@lang("alnkel.header-menu-travel")</span>
            </a>
        </li>
        <li>
            <a href="{{ route('flights') }}" class="d-flex align-items-center scale-icons-hover">
                <i class="icons8-plane"></i>
                <span>@lang("alnkel.header-menu-flight")</span>
            </a>
        </li>
        <li>
            <a href="{{ route('visas') }}" class="d-flex align-items-center scale-icons-hover">
                <i class="icons8-passport"></i>
                <span>@lang("alnkel.header-menu-visa")</span>
            </a>
        </li>
        <li>
            <a href="{{ route('aboutUs') }}" class="d-flex align-items-center scale-icons-hover">
                <i class="icons8-user-groups"></i>
                <span>@lang("alnkel.header-menu-about")</span>
            </a>
        </li>
        <li>
            <a href="{{ route('contactUs') }}" class="d-flex align-items-center scale-icons-hover">
                <i class="icons8-mail"></i>
                <span>@lang("alnkel.header-menu-contact")</span>
            </a>
        </li>
        <li>
            <div class="dropdown">
                <a class="dropdown-toggle d-flex align-items-center" href="#" role="button"
                   id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="icons8-user"></i>
                    <span>{{ App::getLocale()  === 'ar' ? 'اخري' : 'others'}}</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item d-flex align-items-center"
                       href="{{ route('aboutUs') }}"><i
                                class="icons8-view-details"></i><span>@lang("alnkel.header-menu-about")</span></a>
                </div>
            </div>
        </li>
        @if(Auth::check())
            <li>
                <a class="d-flex align-items-center" href="/profile"><i
                            class="icons8-view-details"></i><span>لوحة التحكم</span></a>
            </li>
            <li>
                <a class="d-flex align-items-center" href="{{ route('front-logout') }}"><i
                            class="icons8-enter"></i><span>تسجيل خروج</span></a>
            </li>
        @else
            <li>
                <a class="scale-icons-hover d-flex align-items-center"
                   href="{{ route('front-login') }}">
                    <i class="icons8-enter"></i>
                    <span>@lang("alnkel.header-sign-in-register")</span>
                </a>
            </li>
        @endif
    </ul>
    <div class="mobile-menu-overlay"></div>
</div>
<!-- End mobile-menu -->
<!-- Start home-intro -->
<div class="home-intro parallax fullscreen background" data-aos="fade-up" data-img-width="1920" data-img-height="1269"
     data-diff="100" data-oriz-pos="100%" style="background-image: url('/front-assets/images/content/slider.jpg');">
    @include('includes.front.header')
    @yield('page-header')
</div>
<!-- End home-intro -->
@include('includes.front.search')

@include('includes.front.news')

@yield('content')

@include('includes.front.footer')

<!--Start JS-->
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
 crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
        crossorigin="anonymous"></script>
<script src="{{ asset('front-assets/OwlCarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('front-assets/js/parallax.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!--<script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>-->
<script src="{{ asset('front-assets/js/jquery.magnific-popup.min.js') }}"></script>

@if(App::isLocale('en'))
    <script src="{{ asset('front-assets/js/breakingNews-ltr.js') }}"></script>
@elseif(App::isLocale('ar'))
    <script src="{{ asset('front-assets/js/breakingNews.js') }}"></script>
@endif
@yield('scripts')
<script src="{{ asset('front-assets/js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('front-assets/js/custom.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

<script>
    $('[name=ticket]').on('change', function () {
        if (this.checked && $(this).val() == "OneWay") {
            $(this).closest('form').find('[name=coming]').closest('.input-gp').hide()
        } else {
            $(this).closest('form').find('[name=coming]').closest('.input-gp').show()
        }
    });

    $('.charter-search-btn').on('click', function (e) {
        e.preventDefault();

        var adult = $('#charter-search-form [name=adult]').val();
        var business = $('#charter-search-form [name=business]').val();
        var children = $('#charter-search-form [name=children]').val();
        var baby = $('#charter-search-form [name=baby]').val();

        if (adult == 0 && business == 0 && children == 0 && baby == 0) {
            alert("{{__("charter.select_min_one")}}");
            return false;
        }

        $('#charter-search-form').submit();
        return true;
    });

    $('.charter-table').each(function () {
        sortTable($(this));
    });


    function sortTable(table) {
        var tbody = table.find('tbody');

        tbody.find('tr').sort(function (a, b) {
            return $('td:first', a).data('time').toString().localeCompare($('td:first', b).data('time').toString());

        }).appendTo(tbody);
    }
</script>
<!--End JS-->
</body>

</html>

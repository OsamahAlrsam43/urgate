<!DOCTYPE html>
<html lang="ar">
<head>
    <title>Al-Nakheel Group for Tourism and Travel @yield("title")</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet"
          href="{{ asset('front-assets/icon8/styles.css') }}">
    
    <link rel="stylesheet" href="{{ asset('front-assets/css/styles.css') }}">
    
    <link rel="stylesheet" href="{{ asset('front-assets/OwlCarousel/assets/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/OwlCarousel/assets/owl.theme.default.css') }}">
    
    
    <link href="https://fonts.googleapis.com/css?family=Cairo&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet"
          href="{{ asset('front-assets/bower_components/jquery-confirm2/dist/jquery-confirm.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="{{asset('public/assets/css/common.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/style.css')}}">

    <link rel="stylesheet" href="{{asset('public/assets/css/select2-bootstrap4.min.css')}}">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    @if(App::getLocale() == "ar")
        <link rel="stylesheet" href="{{asset('public/assets/css/rtl.css')}}">
    @endif
    <style>
        .visa-dropdown {
            @if(App::getLocale() == "en")
 left: -560px !important;
            @else
 right: -560px !important;
            @endif
 transform: translate3d(0, 45px, 0px) !important;
        }

        .visa-dropdown a {
            width: 33%;
            float: right;
            margin-bottom: 10px;
            text-align: right;
            font-size: 13px;
            margin-right: 0 !important;
        }

        a.btn.show-all-visa {
            margin-bottom: 0 !important;
            background: #112740;
            border-color: #112740;
            color: #fff !important;
            float: none;
        }

        .visa-dropdown a img {
            @if(App::getLocale() == "en")
 margin-left: 10px;
            @else
 margin-right: 10px;
        @endif

        }

        .select2-container {
            z-index: 99999999;
        }
    </style>

    @yield('styles')
</head>

@include('web.include.header')
<body>
@yield('content')
</body>

@include('web.include.footer')

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('front-assets/bower_components/jquery-confirm2/dist/jquery-confirm.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

<script src="{{ asset('front-assets/OwlCarousel/owl.carousel.js') }}"></script>
<script src="{{ asset('front-assets/js/custom.js') }}"></script>

@yield('scripts')

<script>
    $('body').on('click', '.charter-reserve', function (e) {
        e.preventDefault();
        var $this = $(this);
        $.confirm({
            title: $this.data('title'),
            columnClass: 'col-md-8 col-md-offset-2',
            buttons: {
                formSubmit: {
                    btnClass: 'btn-blue',
                    text: 'Continue to checkout',
                    action: function () {
                        if (this.$content.find('[name=total_price]').val() > 0) {
                            this.$content.find('#charter-reserve-form')[0].submit();
                        } else {
                            $.alert({
                                title: 'Alert!',
                                content: 'You have to select at least one passenger before continue to checkout!',
                                onClose: function () {
                                    $this.trigger('click');
                                }
                            });
                        }
                    }
                },
                cancel: {}
            },
            content: function () {
                var self = this;
                return $.ajax({
                    url: `{{route('charterReserveForm')}}?id=${$this.data('id')}&adults=${$this.data('adults')}&children=${$this.data('children')}&babies=${$this.data('babies')}&class=${$this.data('class')}`,
                    method: 'get'
                }).done(function (response) {
                    response = response.replace('{form-action}', $this.data('checkout'));
                    self.setContent(response);
                }).fail(function () {
                    self.setContent('Something went wrong.');
                });
            },
            onContentReady: function () {
                // bind to events
            }
        })
    });

    $('.select2').select2({
        theme: 'bootstrap4'
    });

    $('.select2-nosearch').select2({
        theme: 'bootstrap4',
        minimumResultsForSearch: Infinity
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    function checkMessages() {
        return $.ajax({
            url: '{{route('checkMessages')}}',
            method: 'get'
        }).done(function (response) {
            let hasMessages = response.hasMessages,
                lastMessage = response.lastMessage;

            if(hasMessages) {
                $.alert({
                    title: 'You have new message',
                    content: `<h5 class="text-dark">${lastMessage.title}</h5> ${lastMessage.message}`,
                    theme: 'modern',
                    icon: 'fas fa-bell text-danger',
                    buttons: {
                        openMessage: {
                            text: 'Open Message',
                            btnClass: 'btn-blue',
                            action: function(){
                                readMessage();
                                window.location = '{{route('user.messages')}}'
                            }
                        },
                        close: function(){
                            readMessage();
                            $('.top-header .badge-danger').hide();
                        }
                    }
                });

                clearInterval(interval);
            }

            // console.log(response);
        });
    }

    function readMessage() {
        return $.get('{{route('readMessages')}}');
    }

    let interval = setInterval(checkMessages, 10000)
</script>
</html>


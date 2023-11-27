<!DOCTYPE html>
<html lang="ar">
<head>
    <title>مجموعة النخيل</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Cairo&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

    <link rel="stylesheet" href="{{asset('public/assets/css/common.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('front-assets/bower_components/jquery-confirm2/dist/jquery-confirm.min.css') }}">

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
            margin-right: 0!important;
        }

        a.btn.show-all-visa {
            margin-bottom: 0 !important;
            background: #112740;
            border-color: #112740;
            color: #fff!important;
            float: none;
        }

        .visa-dropdown a img {
            @if(App::getLocale() == "en")
margin-left: 10px;
            @else
margin-right: 10px;
        @endif


}
    </style>
</head>

@include('web.include.header')
<body>
@yield('content')
</body>
@include('web.include.footer')

<script src="{{ asset('front-assets/bower_components/jquery-confirm2/dist/jquery-confirm.min.js') }}"></script>
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


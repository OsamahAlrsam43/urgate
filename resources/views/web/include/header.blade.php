<style>
    .alert-bar {
        z-index: 999999999;
        top: 0;
    }
    .btn-group>.btn-group:not(:first-child)>.btn, .btn-group>.btn:not(:first-child) {
    border-top-left-radius: 0;background:gold;color:#000;border:none;
    margin: 0px 12px;}
    .btn-group>.btn-group:not(:last-child)>.btn, .btn-group>.btn:not(:last-child):not(.dropdown-toggle) {
    background: #fe0068;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border:none;
}.card-block:after {
    content: "";
    position: absolute;
    background: rgba(2, 41, 63,0);
    border: none;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    z-index: 1;
    transition: all ease-in-out .5s;
}.mb-3, .my-3 {
    margin-bottom: 0rem !important;
}.home-section-title.travel-title {
    font-size: 33px;
    background: transparent;
    box-shadow: none;
}.garter-offers .slider-box .gartert-btn {
    background-color: transparent;
    margin-bottom: 23px;
    font-size: 33px;
}
.home-section-title.travel-title {
    background: transparent;
    box-shadow: none;
}.home-section-title {
    background: transparent;
    color: #000;
    text-align: center;
    margin: 40px auto;
    display: table;
    padding: 10px;
    font-size: 33px;
    width: 100%;
    border-radius: 30px;
    box-shadow: none;
}
.slider-button {
    width: 100%;
    margin: auto;
    border-radius: 25px;
    color: #fe0068;
    background-color: #fe0068;
    padding: 14px;
    display: inline-block;
    font-weight: 700;
    border: none;
    -webkit-box-shadow: 1px 1px 7px rgba(0, 0, 0, 0.5);
    box-shadow: none;
}@media screen and (max-width: 768px){
.main-header .trips .tipr-box {
    direction: ltr;
    background-color: #f2f2f2;
    width: 94%;
    margin: auto;
    padding: 0px;}
    .btn-group-vertical>.btn, .btn-group>.btn {
    font-size: 12px;}
    
}
</style>

@if($delayedOrder)
    <div class="alert-bar bg-danger position-fixed w-100">
        <div class="container">
            <div class="row">
                <div class="col-md-12 p-2">
                    <a href="{{url("/profile/charter")}}/{{$delayedOrder->id}}" class="btn btn-sm btn-dark float-right">Book
                        Now</a>
                    <div class="text-white mt-1">You have open return flights in 5 days, you should book the return
                        flight
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<nav style="padding:0;" class="main-nv" @if($delayedOrder) style="margin-top: 47px;" @endif>
 
    
           
          
                <div class="nav-options">
                    <ul class="list-unstyled dropdown top-header">
                        @auth
                            <li>
                                <div class="dropdown">
                                    <a class="dropdown-toggle d-flex align-items-center btn btn-outline-dark btn-sm"
                                       href="#" role="button"
                                       id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        <span><i class="fas fa-user"></i> @lang('alnkel.Hello'): {{auth()->user()->name}}</span>
                                        @if(auth()->user()->unreadMessages)
                                            <span class="float-right badge badge-danger ml-3">{{auth()->user()->unreadMessages}}</span>
                                        @endif
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item d-flex align-items-center m-0"
                                           href="{{route('user-profile')}}">
                                            <span class="w-100">@lang('alnkel.Membership ID'):</span>
                                            <span class="float-right badge badge-info">{{auth()->user()->id}}</span>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center m-0"
                                           href="{{route('user.messages')}}">
                                            <span class="w-100">@lang('alnkel.header-messages')</span>
                                            @if(auth()->user()->unreadMessages)
                                                <span class="float-right badge badge-danger">{{auth()->user()->unreadMessages}}</span>
                                            @endif
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center m-0"
                                           href="{{route('reservedSeats')}}"><span>@lang('alnkel.Reserved Seats')</span></a>
                                        <a class="dropdown-item d-flex align-items-center m-0"
                                           href="{{route('user-profile')}}"><span>@lang('alnkel.header-dashboard')</span></a>
                                        <a class="dropdown-item d-flex align-items-center m-0"
                                           href="{{route('history')}}"><span>@lang('alnkel.history')</span></a>
                                        <a class="dropdown-item d-flex align-items-center m-0"
                                           href="{{route('front-logout')}}"><span>@lang('alnkel.header-logout')</span></a>
                                    </div>
                                </div>
                            </li>
                        @else
                      		@if(session()->has('fail'))
                                <div class="alert m-alert m-alert--default alert-success" role="alert">
                                    {{session()->get('fail') }}
                                </div>
                            @endif
                            @if ($message = Session::get('register-success'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <p>{{ $error }}</p>
                                    </div>
                                @endforeach
                            @endif
                            <li class="login" data-toggle="modal" data-target="#login_modal">
                                <i class="fas fa-user"></i>@lang('alnkel.login-login')
                            </li>
                            <li class="login" data-toggle="modal" data-target="#register_modal">
                                <i class="fas fa-user"></i> @lang('alnkel.register-register')
                            </li>
                        @endauth

                        <li class="float-right">
                            <a href="{{ url('/' )}}{{ App::getLocale() == 'ar' ? "/en$url" : "/ar$url"}}"
                               class="btn btn-outline-dark btn-sm"><i
                                        class="fas fa-globe mr-1"></i>{{ App::getLocale() == 'ar' ? 'English' : 'عربي' }}
                            </a>
                        </li>
                      
                       <li class="float-right">
                            <a href="{{ route('raload') }}"
                               class="btn btn-outline-dark btn-sm">
                         <i class="fas fa-retweet mr-1" aria-hidden="true"></i>
                            {{ App::getLocale() == 'ar' ? 'تحديث' : 'update' }}
                            </a>
                        </li>
                        @auth
                            <li class="float-right">
                                <span class="btn btn-danger btn-sm">@lang('alnkel.Balance'): ${{number_format(auth()->user()->balance, 2)}}</span>
                            </li>
                        @endauth
                    </ul>
                </div>   
  
  				    <div id="marqueeFour"  style="width:100% ; overflow:hidden ; position:relative; top:-20px">
						@foreach(\App\News::all() as $new)
                      		{{$new->content[App::getLocale()]." | * | "}}
                      	@endforeach
        			</div>
                   <div class="container">
                        <div class="row aligen-items">
                 <div class="col-md-2  col-6">
                <div class="site-logo text-center">
                    <a href="{{ url('/') }}" >
                    <img src="{{asset('public/assets/img/logo-header.png')}}" height="90" alt="logo">
                        </a>
                </div>
            </div> <div class="col-md-10  col-6">
                <div class="site-links navbar-expand-lg">
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#collapsibleNavbar"><i class="fas fa-bars"></i></button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul class="list-unstyled ">
                            <li class="homes">
                                <a href="{{ route('front-home') }}">
                                    <i class="fas fa-home"></i><span>@lang("alnkel.header-menu-main")</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('travels') }}">
                                    <i class="fas fa-globe-americas"></i><span>@lang("alnkel.header-menu-travel")</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('flights') }}">
                                    <i class="fas fa-plane"></i><span>@lang("alnkel.header-menu-flight")</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('charter') }}">
                                    <i class="fas fa-plane-departure"></i><span>@lang("charter.charter")</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pnrSearch') }}">
                                    <i class="fas fa-search"></i><span>@lang("charter.search_pnr")</span>
                                </a>
                            </li>
                            <li>
                                <!-- Start dropdown -->
                                <div class="dropdown">
                                    <a class="dropdown-toggle d-flex align-items-center" href="#" role="button"
                                       id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        <i class="fas fa-passport"></i>
                                        <span>@lang("alnkel.header-menu-visa")</span>
                                    </a>
                                    <div class="dropdown-menu visa-dropdown" aria-labelledby="dropdownMenuLink"
                                         style="width: 720px; padding: 10px;">
										<?php $visas = \App\Visa::where('locked',0)->get(); ?>
                                        @foreach($visas as $visa)
                                            <a href="{{ route('singleVisa',['visa' => $visa->id]) }}">
                                                {{--                                                <img src="{{ Storage::url($visa->thumb) }}" class="rounded-circle"--}}
                                                {{--                                                     style="width: 30px;height: 30px;">--}}
                                                {{$visa->name[App::getLocale()]}}
                                            </a>
                                        @endforeach

                                        <a href="{{ route('visas') }}" class="btn btn-primary btn-sm show-all-visa"><i
                                                    class="icons8-passport"></i><span>@lang("alnkel.showAll")</span></a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown">
                                    <a class="dropdown-toggle d-flex align-items-center" href="#" role="button"
                                       id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                        <span>{{ App::getLocale()  === 'ar' ? 'اخرى' : 'others'}}</span>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item d-flex align-items-center m-0"
                                           href="{{ route('aboutUs') }}"><span>@lang("alnkel.header-menu-about")</span></a>
                                        @foreach(\App\Page::where("page_type", "page")->get() as $page)
                                            <a class="dropdown-item d-flex align-items-center m-0"
                                               href="{{ route('page',['page' => $page->id]) }}"><span>{{ $page->name[App::getLocale()] }}</span></a>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

@if(request()->route()->getName() == 'front-home')
    <header class="main-header" style="background-image: url('{{asset('public/assets/img/header-img.jpeg')}}')">
        <div class="trips">
            <ul class="list-unstyled text-center">
                <li class="active" data-show="plane"><i class="fas fa-plane-departure"></i> @lang("alnkel.Charter")</li>
                <li data-show="garter-plane"><i class="fas fa-plane-departure"></i> @lang("alnkel.Flights")</li>
                <li data-show="trips-form"><i class="fas fa-globe-americas"></i> @lang("alnkel.Travel")</li>
                <li data-show="passports"><i class="fas fa-passport"></i> @lang("alnkel.Visa")</li>
            </ul>
            <div class="tipr-box plane">
                @include('web.include.charter_search')
            </div>
            <div class="tipr-box garter-plane">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="options aligen-items text-right" id="options">
                                            <input type="radio" id="go_back" name="options" checked>
                                            <label for="go_back">ذهاب و عودة</label>
                                            <input type="radio" id="go" name="options">
                                            <label for="go">ذهاب فقط</label>
                                            <input type="radio" id="no_stop" name="options">
                                            <label for="no_stop">بدون توقف </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="container filter">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="d-block text-right" for="choose_country">المغادرة من</label>
                                        <input class="form-control" id="choose_country" type="text"
                                               placeholder="اختار البلد"><i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="d-block text-right" for="go_from">الذهاب من</label>
                                        <input class="form-control" id="go_from" type="text"
                                               placeholder="اختار البلد"><i class="fas fa-map-marker-alt"></i>
                                      <input type="number" name="pl1" class="form-control">
                                      <i class="fas fa-plus " aria-hidden="true" style="position: absolute;top: 79px"></i>

                                    </div>
                                  
                                    <div class="col-md-3">
                                        <label class="d-block text-right" for="go_date">تاريخ المغادرة</label>
                                        <input class="form-control" id="go_date" type="text"
                                               placeholder="اختار التاريخ"><i
                                                class="far fa-calendar-alt"></i>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="d-block text-right" for="back_date">تاريخ العودة</label>
                                        <input class="form-control" id="back_date" type="text"
                                               placeholder="اختار التاريخ"><i class="far fa-calendar-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="container filter">
                                <div class="row">
                                    <div class="col">
                                        <label class="d-block text-right" for="adult">بالغ</label>
                                        <select class="form-control" id="adult">
                                            <option>1 بالغ</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="d-block text-right" for="childs">طفل</label>
                                        <select class="form-control" id="childs">
                                            <option>0 الاطفال</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="d-block text-right" for="baby">رضيع</label>
                                        <select class="form-control" id="baby">
                                            <option>0 رضع</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="d-block text-right" for="business_men">رجل اعمال</label>
                                        <select class="form-control" id="business_men">
                                            <option>0 رجل اعمال</option>
                                        </select>
                                    </div>
                                    <div class="col search-btn">
                                        <button class="main-button"><i class="fas fa-search"> </i>بحث</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tipr-box trips-form">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="options aligen-items text-right" id="options">
                                            <input type="radio" id="go_back" name="options" checked>
                                            <label for="go_back">ذهاب و عودة</label>
                                            <input type="radio" id="go" name="options">
                                            <label for="go">ذهاب فقط</label>
                                            <input type="radio" id="no_stop" name="options">
                                            <label for="no_stop">بدون توقف </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="container filter">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="d-block text-right" for="choose_country">المغادرة من</label>
                                        <input class="form-control" id="choose_country" type="text"
                                               placeholder="اختار البلد"><i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="d-block text-right" for="go_from">الذهاب من</label>
                                        <input class="form-control" id="go_from" type="text"
                                               placeholder="اختار البلد"><i
                                                class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="d-block text-right" for="go_date">تاريخ المغادرة</label>
                                        <input class="form-control" id="go_date" type="text"
                                               placeholder="اختار التاريخ"><i
                                                class="far fa-calendar-alt"></i>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="d-block text-right" for="back_date">تاريخ العودة</label>
                                        <input class="form-control" id="back_date" type="text"
                                               placeholder="اختار التاريخ"><i class="far fa-calendar-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="container filter">
                                <div class="row">
                                    <div class="col">
                                        <label class="d-block text-right" for="adult">بالغ</label>
                                        <select class="form-control" id="adult">
                                            <option>1 بالغ</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="d-block text-right" for="childs">طفل</label>
                                        <select class="form-control" id="childs">
                                            <option>0 الاطفال</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="d-block text-right" for="baby">رضيع</label>
                                        <select class="form-control" id="baby">
                                            <option>0 رضع</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="d-block text-right" for="business_men">رجل اعمال</label>
                                        <select class="form-control" id="business_men">
                                            <option>0 رجل اعمال</option>
                                        </select>
                                    </div>
                                    <div class="col search-btn">
                                        <button class="main-button"><i class="fas fa-search"> </i>بحث</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tipr-box passports">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="options aligen-items text-right" id="options">
                                            <input type="radio" id="go_back" name="options" checked>
                                            <label for="go_back">ذهاب و عودة</label>
                                            <input type="radio" id="go" name="options">
                                            <label for="go">ذهاب فقط</label>
                                            <input type="radio" id="no_stop" name="options">
                                            <label for="no_stop">بدون توقف </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="container filter">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="d-block text-right" for="choose_country">المغادرة من</label>
                                        <input class="form-control" id="choose_country" type="text"
                                               placeholder="اختار البلد"><i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="d-block text-right" for="go_from">الذهاب من</label>
                                        <input class="form-control" id="go_from" type="text"
                                               placeholder="اختار البلد"><i
                                                class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="d-block text-right" for="go_date">تاريخ المغادرة</label>
                                        <input class="form-control" id="go_date" type="text"
                                               placeholder="اختار التاريخ"><i
                                                class="far fa-calendar-alt"></i>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="d-block text-right" for="back_date">تاريخ العودة</label>
                                        <input class="form-control" id="back_date" type="text"
                                               placeholder="اختار التاريخ"><i class="far fa-calendar-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="container filter">
                                <div class="row">
                                    <div class="col">
                                        <label class="d-block text-right" for="adult">بالغ</label>
                                        <select class="form-control" id="adult">
                                            <option>1 بالغ</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="d-block text-right" for="childs">طفل</label>
                                        <select class="form-control" id="childs">
                                            <option>0 الاطفال</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="d-block text-right" for="baby">رضيع</label>
                                        <select class="form-control" id="baby">
                                            <option>0 رضع</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="d-block text-right" for="business_men">رجل اعمال</label>
                                        <select class="form-control" id="business_men">
                                            <option>0 رجل اعمال</option>
                                        </select>
                                    </div>
                                    <div class="col search-btn">
                                        <button class="main-button"><i class="fas fa-search"> </i>بحث</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endif
<script>
var Marquee = function (element, defaults) {
  var elem = document.getElementById(element),
    options = (defaults === undefined) ? {} : defaults,
    continuous = options.continuous || true,	// once or continuous
    direction = options.direction || 'ltr', 	// ltr or rtl
    loops = options.loops || -1,
    speed = options.speed || 0.5,
    milestone = 0,
    marqueeElem = null,
    elemWidth = null,
    self = this,
    ltrCond = 0,
    loopCnt = 0,
    start = 0,
    textcolor = options.textcolor || '#000000', // Define the text color
    bgcolor = options.bgcolor || '#ffffff', // Define the background color
    opacity = options.opacity || 1.0,
    process = null,
    constructor = function (elem) {

      // Build html
      var elemHTML = elem.innerHTML;
      var elemNode = elem.childNodes[1] || elem;
      elemWidth = elemNode.offsetWidth;
      marqueeElem = '<div>' + elemHTML + '</div>';
      elem.innerHTML = marqueeElem;
      marqueeElem = elem.getElementsByTagName('div')[0];
      elem.style.overflow = 'hidden';
      marqueeElem.style.whiteSpace = 'nowrap';
      marqueeElem.style.position = 'relative';
      marqueeElem.style.color = textcolor;
      marqueeElem.style.backgroundColor = bgcolor;
      marqueeElem.style.opacity = opacity;

      if (continuous) {
        marqueeElem.innerHTML += elemHTML;
        marqueeElem.style.width = '200%';

        if (direction === 'ltr') {
          start = -elemWidth;
        }
      } else {
        ltrCond = elem.offsetWidth;

        if (direction === 'rtl') {
          milestone = ltrCond;
        }
      }

      if (direction === 'ltr') {
        milestone = -elemWidth;
      } else if (direction === 'rtl') {
        speed = -speed;
      }

      self.start();

      return marqueeElem;
    }

  this.start = function () {
    process = window.setInterval(function () {
      self.play();
    });
  };

  this.play = function () {
    // beginning
    marqueeElem.style.left = start + 'px';
    start = start + speed;

    if (start > ltrCond || start < -elemWidth) {
      start = milestone;
      loopCnt++;

      if (loops !== -1 && loopCnt >= loops) {
        marqueeElem.style.left = 0;
      }
    }
  }

  this.end = function () {
    window.clearInterval(process);
  }

  // Init plugin
  marqueeElem = constructor(elem);
}

</script>
  <script>
    
        new Marquee('marqueeFour', {
            bgcolor: 'black',
            textcolor: 'white',
            opacity: .7,
            speed: .2 ,
           loops:"1"
          

        });
    </script>
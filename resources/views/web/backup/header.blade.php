<!--
**********************************
    Template: navigation bar
    Created at: 8/19/2019
    Author: Mohammed Hamouda
    **********************************

    -->
<nav class="main-nv">
    <div class="container">
        <div class="row aligen-items">
            <div class="col-md-3 col-6">
                <div class="site-logo text-center">
                    <img src="{{asset('public/assets/img/logo-header.png')}}" height="90" alt="logo">
                </div>
            </div>
            <div class="col-md-9 col-6">
                <div class="nav-options">
                    <ul class="list-unstyled dropdown">
                        <li class="login" data-toggle="modal" data-target="#login_modal">
                            <i class="fas fa-user"></i>تسجيل الدخول
                        </li>
                        <li class="langs dropdown-toggle" id="lang_dropdown" data-toggle="dropdown" aria-expanded="false">
                            <a href="{{ App::getLocale() == 'ar' ? "/en$url" : "/ar$url"}}"><i class="fas fa-globe"></i>{{ App::getLocale() == 'ar' ? 'English' : 'عربي' }}</a>
                        </li>
                    </ul>
                </div>
                <div class="site-links navbar-expand-lg">
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#collapsibleNavbar"><i class="fas fa-bars"></i></button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul class="list-unstyled ">
                            <li>
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
                                       id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-passport"></i>
                                        <span>@lang("alnkel.header-menu-visa")</span>
                                    </a>
                                    <div class="dropdown-menu visa-dropdown" aria-labelledby="dropdownMenuLink"
                                         style="width: 720px; padding: 10px;">
										<?php $visas = \App\Visa::all(); ?>
                                        @foreach($visas as $visa)
                                            <a href="{{ route('singleVisa',['visa' => $visa->id]) }}">
                                                <img src="{{ Storage::url($visa->thumb) }}" class="rounded-circle"
                                                     style="width: 30px;height: 30px;">
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
                                        <span>{{ App::getLocale()  === 'ar' ? 'اخري' : 'others'}}</span>
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

<!--
    **********************************
    Template:  header
    Created at: 8/19/2019
    Author: Mohammed Hamouda
    **********************************

    -->
<header class="main-header" style="background-image: url('{{asset('public/assets/img/header-img.jpeg')}}')">
    <div class="trips">
        <ul class="list-unstyled text-center">
            <li class="active" data-show="plane"><i class="fas fa-plane-departure"></i>الطيران</li>
            <li data-show="garter-plane"><i class="fas fa-plane-departure"></i>رحلات الجارتير</li>
            <li data-show="trips-form"><i class="fas fa-globe-americas"></i>الرحلات</li>
            <li data-show="passports"><i class="fas fa-passport"></i>التاشيرات</li>
        </ul>
        <div class="tipr-box plane">
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
                                    <label class="d-block text-right" for="choose_country">المغدرة من</label>
                                    <input class="form-control" id="choose_country" type="text"
                                           placeholder="اختار البلد"><i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="col-md-3">
                                    <label class="d-block text-right" for="go_from">الذهاب من</label>
                                    <input class="form-control" id="go_from" type="text" placeholder="اختار البلد"><i
                                            class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="col-md-3">
                                    <label class="d-block text-right" for="go_date">تاريخ المغادرة</label>
                                    <input class="form-control" id="go_date" type="text" placeholder="اختار التاريخ"><i
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
                                    <label class="d-block text-right" for="choose_country">المغدرة من</label>
                                    <input class="form-control" id="choose_country" type="text"
                                           placeholder="اختار البلد"><i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="col-md-3">
                                    <label class="d-block text-right" for="go_from">الذهاب من</label>
                                    <input class="form-control" id="go_from" type="text" placeholder="اختار البلد"><i
                                            class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="col-md-3">
                                    <label class="d-block text-right" for="go_date">تاريخ المغادرة</label>
                                    <input class="form-control" id="go_date" type="text" placeholder="اختار التاريخ"><i
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
                                    <label class="d-block text-right" for="choose_country">المغدرة من</label>
                                    <input class="form-control" id="choose_country" type="text"
                                           placeholder="اختار البلد"><i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="col-md-3">
                                    <label class="d-block text-right" for="go_from">الذهاب من</label>
                                    <input class="form-control" id="go_from" type="text" placeholder="اختار البلد"><i
                                            class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="col-md-3">
                                    <label class="d-block text-right" for="go_date">تاريخ المغادرة</label>
                                    <input class="form-control" id="go_date" type="text" placeholder="اختار التاريخ"><i
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
                                    <label class="d-block text-right" for="choose_country">المغدرة من</label>
                                    <input class="form-control" id="choose_country" type="text"
                                           placeholder="اختار البلد"><i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="col-md-3">
                                    <label class="d-block text-right" for="go_from">الذهاب من</label>
                                    <input class="form-control" id="go_from" type="text" placeholder="اختار البلد"><i
                                            class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="col-md-3">
                                    <label class="d-block text-right" for="go_date">تاريخ المغادرة</label>
                                    <input class="form-control" id="go_date" type="text" placeholder="اختار التاريخ"><i
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
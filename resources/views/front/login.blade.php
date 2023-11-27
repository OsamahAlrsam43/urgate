@extends('layouts.master-front')

@section('title')
    @lang("alnkel.header-sign-in-register")

@endsection
@section('page-header')
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-enter"></i>
                <span>@lang("alnkel.header-sign-in-register")</span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
@endsection

@section('content')
    <!-- Start visa-inner -->
    <div class="visa-inner">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-md-6">
                    <!-- Start inner-head-gp -->
                    <div class="inner-head-gp d-flex align-items-center justify-content-center">
                        <!-- Start inner-head -->
                        <div class="inner-head d-flex align-items-center">
                            <i class="icons8-password"></i>
                            <div>
                                <span>@lang("alnkel.login-login")</span>
                            </div>
                        </div>
                        <!-- End inner-head -->
                    </div>
                    <!-- End inner-head-gp -->

                    <!-- Start custom-form -->
                    <form class="custom-form" method="post" action="{{ route('user-login') }}">
                        <!-- Start form-row -->
                        <div class="form-row">

                            @if(session()->has('fail'))
                                <div class="m-alert m-alert--icon alert alert-danger" role="alert"
                                     id="m_form_1_msg">
                                    <div class="m-alert__icon">
                                        <i class="la la-warning"></i>
                                    </div>
                                    <div class="m-alert__text">
                                        {{ session()->get('fail') }}
                                    </div>
                                    <div class="m-alert__close">
                                        <button type="button" class="close" data-close="alert"
                                                aria-label="Close"></button>
                                    </div>
                                </div>
                        @endif

                                @if(session()->has('success'))
                                    <div class="m-alert m-alert--icon alert-success p-3 w-100" role="alert"
                                         id="m_form_1_msg">
                                        <div class="m-alert__icon">
                                            <i class="la la-warning"></i>
                                        </div>
                                        <div class="m-alert__text">
                                            {{ session()->get('success') }}
                                        </div>
                                        <div class="m-alert__close">
                                            <button type="button" class="close" data-close="alert"
                                                    aria-label="Close"></button>
                                        </div>
                                    </div>
                            @endif

                        <!-- Start form-group -->
                            <div class="form-group col-12 custom-form-group">
                                <label for="inputEmail5">@lang("alnkel.login-email")
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <input type="email" class="form-control" name="email" id="inputEmail6"
                                           placeholder="@lang("alnkel.login-enter-email")..."
                                           value="{{ old('email') }}">
                                    @if(isset($errors->messages()['email']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            {{  $errors->messages()['email'][0] }}
                                        </div>
                                    @endif
                                </div>
                                <!-- End custom-input -->
                            </div>
                            <!-- End form-group -->
                            <!-- Start form-group -->
                            <div class="form-group col-12 custom-form-group">
                                <label for="inputEmail7">@lang("alnkel.login-password")
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <input type="password" class="form-control" name="password" id="inputEmail8"
                                           placeholder="@lang("alnkel.login-enter-password")...">
                                    @if(isset($errors->messages()['password']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            {{  $errors->messages()['password'][0] }}
                                        </div>
                                    @endif
                                </div>
                                <!-- End custom-input -->
                            </div>
                            <!-- End form-group -->
                        </div>
                        <!-- End form-row -->
                    {!! csrf_field() !!}
                    <!-- Start action-btns -->
                        <div class="action-btns d-flex align-items-center justify-content-center">
                            <button type="submit"
                                    class="btn-reset submit-btn d-flex align-items-center justify-content-center">
                                <i class="icons8-done"></i>
                                <span>@lang("alnkel.login-login")</span>
                            </button>
                        </div>
                        <!-- End action-btns -->

                        <a href="{{route('forgetPassword')}}">{{__('alnkel.forget_password')}}</a>
                    </form>
                    <!-- End custom-form -->
                </div>
                <!-- End col -->
                <!-- Start col -->
                <div class="col-md-6">
                    <!-- Start inner-head-gp -->
                    <div class="inner-head-gp d-flex align-items-center justify-content-center">
                        <!-- Start inner-head -->
                        <div class="inner-head d-flex align-items-center">
                            <i class="icons8-add-user-male"></i>
                            <div>
                                <span>@lang("alnkel.register-register")</span>
                            </div>
                        </div>
                        <!-- End inner-head -->
                    </div>
                    <!-- End inner-head-gp -->

                    <!-- Start custom-form -->
                    <form class="custom-form" action="{{ route('user-register') }}" method="post">
                        <!-- Start form-row -->
                        <div class="form-row">
                            @if(session()->has('register-fail'))
                                <div class="m-alert m-alert--icon alert alert-danger" role="alert"
                                     id="m_form_1_msg">
                                    <div class="m-alert__icon">
                                        <i class="la la-warning"></i>
                                    </div>
                                    <div class="m-alert__text">
                                        {{ session()->get('register-fail') }}
                                    </div>
                                    <div class="m-alert__close">
                                        <button type="button" class="close" data-close="alert"
                                                aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                            @if(session()->has('register-success'))
                                <div class="m-alert m-alert--icon alert alert-success" role="alert"
                                     id="m_form_1_msg">
                                    <div class="m-alert__icon">
                                        <i class="la la-warning"></i>
                                    </div>
                                    <div class="m-alert__text">
                                        {{ session()->get('register-success') }}
                                    </div>
                                    <div class="m-alert__close">
                                        <button type="button" class="close" data-close="alert"
                                                aria-label="Close"></button>
                                    </div>
                                </div>
                        @endif
                        <!-- Start form-group -->
                            <div class="form-group col-md-6 custom-form-group">
                                <label for="inputEmail9">@lang("alnkel.register-name")
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <input type="text" name="name" class="form-control" id="inputEmail10"
                                           placeholder="@lang("alnkel.register-enter-name")..."
                                           value="{{ old('name') }}">
                                    @if(isset($errors->messages()['name']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            {{  $errors->messages()['name'][0] }}
                                        </div>
                                    @endif
                                </div>
                                <!-- End custom-input -->
                            </div>
                            <!-- End form-group -->
                            <!-- Start form-group -->
                            <div class="form-group col-md-6 custom-form-group">
                                <label for="inputEmail11">@lang("alnkel.login-email")
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <input type="email" name="register_email" class="form-control" id="inputEmail12"
                                           placeholder="@lang("alnkel.login-enter-email") ..."
                                           value="{{ old('register_email') }}">
                                    @if(isset($errors->messages()['register_email']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            {{  $errors->messages()['register_email'][0] }}
                                        </div>
                                    @endif
                                </div>
                                <!-- End custom-input -->
                            </div>
                            <!-- End form-group -->

                            <!-- Start form-group -->
                            <div class="form-group col-md-6 custom-form-group">
                                <label for="inputEmail9">@lang("alnkel.register-company")
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <input type="text" name="company" class="form-control" id="inputEmail10"
                                           placeholder="@lang("alnkel.register-company")..."
                                           value="{{ old('company') }}">
                                </div>
                                <!-- End custom-input -->
                            </div>
                            <!-- End form-group -->

                            <!-- Start form-group -->
                            <div class="form-group col-md-6 custom-form-group">
                                <label for="inputEmail9">@lang("alnkel.register-phone")
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <input type="text" name="phone" class="form-control" id="inputEmail10"
                                           placeholder="@lang("alnkel.register-phone")..."
                                           value="{{ old('phone') }}">
                                </div>
                                <!-- End custom-input -->
                            </div>
                            <!-- End form-group -->

                            <!-- Start form-group -->
                            <div class="form-group col-md-12 custom-form-group">
                                <label for="inputEmail9">@lang("alnkel.register-address")
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <input type="text" name="address" class="form-control" id="inputEmail10"
                                           placeholder="@lang("alnkel.register-address")..."
                                           value="{{ old('address') }}">
                                </div>
                                <!-- End custom-input -->
                            </div>
                            <!-- End form-group -->

                            <!-- Start form-group -->
                            <div class="form-group col-md-6 custom-form-group">
                                <label for="inputEmail13">@lang("alnkel.login-password")
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <input type="password" name="register_password" class="form-control"
                                           id="inputEmail14"
                                           placeholder="@lang("alnkel.login-enter-password") ...">
                                    @if(isset($errors->messages()['register_password']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            {{  $errors->messages()['register_password'][0] }}
                                        </div>
                                    @endif
                                </div>
                                <!-- End custom-input -->
                            </div>
                            <!-- End form-group -->
                            <!-- Start form-group -->
                            <div class="form-group col-md-6 custom-form-group">
                                <label for="inputEmail15">@lang("alnkel.register-password-confirmation")
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <input type="password" name="register_password_confirmation" class="form-control"
                                           id="inputEmail16"
                                           placeholder="@lang("alnkel.login-enter-password")...">
                                    @if(isset($errors->messages()['register_password_confirmation']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            {{  $errors->messages()['register_password_confirmation'][0] }}
                                        </div>
                                    @endif
                                </div>
                                <!-- End custom-input -->
                            </div>
                            <!-- End form-group -->
                            <!-- Start form-group -->
                            <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                <label for="inputEmail4">Capatcha
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input2 custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <div class="custom-file">
                                        {!! NoCaptcha::display() !!}
                                        @if(isset($errors->messages()['g-recaptcha-response']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['g-recaptcha-response'][0] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- End custom-input -->
                            </div>
                            <!-- End form-group -->
                        </div>
                        <!-- End form-row -->
                    {!! csrf_field() !!}
                    <!-- Start action-btns -->
                        <div class="action-btns d-flex align-items-center justify-content-center">
                            <button type="submit"
                                    class="btn-reset submit-btn d-flex align-items-center justify-content-center">
                                <i class="icons8-done"></i>
                                <span>@lang("alnkel.register-register")</span>
                            </button>
                        </div>
                        <!-- End action-btns -->
                    </form>
                    <!-- End custom-form -->
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->

        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End visa-inner -->

    <!-- Start fly-section -->
    <div class="fly-section section-bg section parallax fullscreen background" data-aos="fade-up" data-img-width="1920"
         data-img-height="1269" data-diff="100"
         data-oriz-pos="100%" style="background-image: url('/front-assets/images/content/slider.jpg');">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start section-header -->
            <div class="section-header section-header-light d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span>@lang("alnkel.latestFlights")</span>
            </div>
            <!-- End section-header -->
            <!-- Start travelSection -->
            <div id="flySection" class="owl-carousel">
                @foreach($latest_flights as $flight)
                    <div class="item">
                        @include('includes.front.cards.flights',compact('flight'))
                    </div>
                @endforeach
            </div>
            <!-- End travelSection -->

            <!-- Start section-footer -->
            <div class="section-footer d-flex align-items-center justify-content-between">
                <!-- Start section-carousel-controls -->
                <div class="section-carousel-controls d-flex align-items-center">
                    <!-- Start homeCarouselPrev -->
                    <div id="flySectionPrev" class="custom-carousel-prev scale-icons-hover">
                        <i class="icons8-drop-down-arrow"></i>
                    </div>
                    <!-- End homeCarouselPrev -->

                    <!-- Start homeCarouselDots -->
                    <div id="flySectionDots" class="custom-carousel-dots d-flex align-items-center">
                        <button role="button" class="owl-dot active">
                            <span></span>
                        </button>
                        <button role="button" class="owl-dot">
                            <span></span>
                        </button>
                        <button role="button" class="owl-dot">
                            <span></span>
                        </button>
                    </div>
                    <!-- End homeCarouselDots -->

                    <!--Start homeCarouselNext -->
                    <div id="flySectionNext" class="custom-carousel-next scale-icons-hover">
                        <i class="icons8-drop-down-arrow"></i>
                    </div>
                    <!--End premiumCarouselNext -->
                </div>
                <!-- End section-carousel-controls -->
                <a href="{{ route('flights') }}" class="view-all d-flex align-items-center">
                    <i class="icons8-grid"></i>
                    <span>@lang("alnkel.showAll")</span>
                </a>
            </div>
            <!-- End section-footer -->

        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End fly-section -->
@endsection
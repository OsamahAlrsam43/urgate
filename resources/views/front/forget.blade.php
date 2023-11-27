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
                                <span>@lang("alnkel.forget_password")</span>
                            </div>
                        </div>
                        <!-- End inner-head -->
                    </div>
                    <!-- End inner-head-gp -->

                    <!-- Start custom-form -->
                    <form class="custom-form" method="post" action="{{ route('resetPassword') }}">
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
                                           value="{{ old('email', session()->get("email")) }}">
                                    @if(isset($errors->messages()['email']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            {{  $errors->messages()['email'][0] }}
                                        </div>
                                    @endif
                                </div>
                                <!-- End custom-input -->
                            </div>
                            <!-- End form-group -->
                            @if(session()->get("email"))
                            <!-- Start form-group -->
                                <div class="form-group col-12 custom-form-group">
                                    <label for="inputEmail7">@lang("alnkel.reset_code")
                                        <b>*</b>
                                    </label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <input type="text" class="form-control" name="verification" id="inputEmail8"
                                               placeholder="@lang("alnkel.reset_code")...">
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
                            @endif
                        </div>
                        <!-- End form-row -->
                    {!! csrf_field() !!}
                    <!-- Start action-btns -->
                        <div class="action-btns d-flex align-items-center justify-content-center">
                            <button type="submit"
                                    class="btn-reset submit-btn d-flex align-items-center justify-content-center">
                                <i class="icons8-done"></i>
                                <span>@lang("alnkel.reset_password")</span>
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

@endsection
@extends('layouts.master-front')

@section('title')
{{ App::getLocale() == 'ar' ? 'اتصل بنا' : 'Contact Us' }}
@endsection

@section('page-header')
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span>{{ App::getLocale() == 'ar' ? 'اتصل بنا' : 'Contact Us' }}</span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
@endsection

@section('content')
    <div class="travel-inner">
        <!-- Start container-fluid -->
        <div class="container-fluid">
        {!! \App\Setting::first()->contact[App::getLocale()] !!}
        <!-- Start inner-head-gp -->
            <div class="inner-head-gp d-flex align-items-center justify-content-between">
                <!-- Start inner-head -->
                <div class="inner-head d-flex align-items-center">
                    <i class="icons8-view-details"></i>
                    <div>
                        <span>{{ App::getLocale() === 'ar' ? 'اتصل بنا' : 'Contact Form' }}:</span>
                    </div>
                </div>
                <!-- End inner-head -->
            </div>
            <!-- End inner-head-gp -->
            <!-- Start travel-post -->
            <div class="travel-post">
                <!-- Start travel-post-text -->
                <div class="travel-post-text">
                    <!-- Start custom-form -->
                    <form class="custom-form" action="{{ route('contact-form') }}" method="post">
                        <!-- Start form-row -->
                        <div class="form-row">
                            <!-- Start form-group -->
                            <div class="form-group col-md-6 custom-form-group">
                                <label for="inputEmail4">@lang("alnkel.register-name")
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <input type="text" name="name" class="form-control" id="inputEmail4"
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
                                <label for="inputEmail4">@lang("alnkel.login-email")
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <input type="email" name="email" class="form-control" id="inputEmail4"
                                           placeholder="@lang("alnkel.login-enter-email") ..."
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
                            <div class="form-group col-md-6 custom-form-group">
                                <label for="inputEmail4">{{ App::getLocale() == 'ar' ? 'الموضع' : 'Subject' }}
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <input type="text" name="subject" class="form-control"
                                           id="inputEmail4"
                                           placeholder="{{ App::getLocale() == 'ar' ? 'ادخل الموضع' : 'enter subject' }} ...">
                                </div>
                                <!-- End custom-input -->
                            </div>
                            <!-- End form-group -->
                            <!-- Start form-group -->
                            <div class="form-group col-md-6 custom-form-group">
                                <label for="inputEmail4">{{ App::getLocale() == 'ar' ? 'الرسالة' : 'Message' }}
                                    <b>*</b>
                                </label>
                                <!-- Start custom-input -->
                                <div class="custom-input d-flex align-items-stretch">
                                    <!-- Start input-icon -->
                                    <div class="input-icon d-flex align-items-center">
                                        <i class="icons8-edit-file"></i>
                                    </div>
                                    <!-- End input-icon -->
                                    <textarea name="message" class="form-control"
                                              id="inputEmail4"
                                              placeholder="{{ App::getLocale() == 'ar' ? 'ادخل الرسالة' : 'enter message' }}..."></textarea>
                                    @if(isset($errors->messages()['message']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            {{  $errors->messages()['message'][0] }}
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
                            <button type="button"
                                    class="btn-reset submit-btn d-flex align-items-center justify-content-center">
                                <i class="icons8-done"></i>
                                <span>{{ App::getLocale() == 'ar' ? 'ارسال' : 'send'}}</span>
                            </button>
                        </div>
                        <!-- End action-btns -->
                    </form>
                    <!-- End custom-form -->
                </div>
                <!-- End  travel-post-text -->
            </div>
            <!-- End travel-post -->
        </div>
        <!-- End container-fluid -->
    </div>
@endsection
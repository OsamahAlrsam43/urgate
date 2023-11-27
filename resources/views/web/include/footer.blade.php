<!--
    **********************************
    Template:  footer
    Created at: 8/20/2019
    Author: Mohammed Hamouda
    **********************************

    -->
<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="site-logo text-center">
                     <img height="100px" src="{{asset('public/assets/img/logo.png')}}" alt="logo"></div>
            </div>
            <div class="col-md-3">
                <div class="about">
                    <h5>@lang("alnkel.About Us")</h5>
                    <p>{!! nl2br(e(\App\Setting::first()->about_content[App::getLocale()])) !!}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="newslette">
                    <h5>@lang("alnkel.Newsletter")</h5>
                    <p>@lang("Write your email and we will send the latest offers to your mail")</p>
                    <div class="input-email">
                        <input class="form-control" type="text" placeholder="@lang("alnkel.Write your email")"><i class="fas fa-envelope"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact">
                    <h5>@lang("alnkel.Contact Us")</h5>
                    <div class="whatsapp"><i class="fab fa-whatsapp"></i> {{ \App\Setting::first()->phone }}</div> 
                    <div class="email"> <i class="fas fa-envelope"></i>  {{ \App\Setting::first()->mail }} </div>
                    <div class="email"> <i class="fas fa-map-pin"></i> {{ \App\Setting::first()->address }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="info">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copy text-center">
                        
                        @lang('alnkel.copyRight')
                        {{ date("Y") }}
                        
                        </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="modal fade" id="login_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="login form-control">@lang('alnkel.login-login') </button>
                        </div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="container add-new">
                    <form action="{{route('front_login')}}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                                <div class="col-md-12">
                                    <input class="login form-control" name="email" type="text" placeholder=" @lang('alnkel.register-email') "><i class="fas fa-user"></i>

                                </div>
                                <div class="col-md-12">
                                    <input class="login form-control" name="password" type="password" placeholder=" @lang('alnkel.register-password')"><i class="fas fa-lock"> </i>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="log form-control" value="@lang('alnkel.login-login')">

                                </div>
                        </div>
                    </form>
                </div>
                <div class="container rig-options">
                    <div class="row aligen-items">
{{--                        <div class="col-md-6 text-right small-center">--}}
{{--                            <label for="remember">@lang('alnkel.login-login')</label>--}}
{{--                            <input type="radio" id="remember" checked>--}}
{{--                        </div>--}}
                        <div class="col-md-6 text-left small-center">
                            <a href="#">@lang('alnkel.forget_password')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="register_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container actions">

                    <div class="row">

                        <div class="col-md-12">
                            <button class="login form-control">@lang('alnkel.register-register')</button>
                        </div>
                        
                        @if ($message = Session::get('register-success'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                    </div>
                    </form>
                </div>
                <form action="{{route('user-register')}}" method="post">

                <div class="container add-new">
                    <div class="row">
                        {{ method_field('PUT') }}
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="col-md-12">
                            <input class="login form-control" type="text" name="name" placeholder="@lang('alnkel.register-name')"><i class="fas fa-user"></i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="text" name="register_email" placeholder=" @lang('alnkel.register-email')"><i class="fas fa-envelope"> </i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="text" name="company" placeholder=" @lang('alnkel.register-company')"><i class="fas fa-building"> </i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="text" name="phone" placeholder="  @lang('alnkel.register-phone')"><i class="fas fa-phone"> </i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="text" name="address" placeholder="  @lang('alnkel.register-address')"><i class="fas fa-address-book"> </i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="password" name="register_password" placeholder="  @lang('alnkel.register-password')"><i class="fas fa-lock"> </i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="password" name="register_password_confirmation" placeholder=" @lang('alnkel.register-password-confirmation')"><i class="fas fa-lock"> </i>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" class="log form-control" value="@lang('alnkel.register-register')">
                        </div>
                    </div>
                </div></form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('public/assets/js/main.js')}}"></script>
</body>
</html>
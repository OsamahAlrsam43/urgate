<!--
@lang("@lang(" ")")   **********************************
    Template:  footer
    Created at: 8/20/2019
    Author: Mohammed Hamouda
    **********************************
    
    -->
<footer class="main-footer text-right">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="site-logo text-center"> <img src="{{asset('public/assets/img/logo.png')}}" alt="logo"></div>
            </div>
            <div class="col-md-3">
                <div class="about">
                    <h4>عن مجموعة النخيل</h4>
                    <p>مجموعة النخيل تساعدك على ان تجد افضل عروض للرحلات و افضل الناشيرات</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="newslette">
                    <h4>النشرة البريدية</h4>
                    <p>@lang("alnkel.footer-email")</p>
                    <div class="input-email">
                        <input class="form-control" type="text" placeholder="@lang("alnkel.footer-write-email")"><i class="fas fa-envelope"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact">
                    <h4>تواصل معنا</h4>
                    <div class="whatsapp"><i class="fab fa-whatsapp"></i>{{ \App\Setting::first()->phone }}</div>
                    <div class="email"> <i class="fas fa-envelope"></i>info@alnkhel.com</div>
                    <div class="email"> <i class="fas fa-map-pin"></i>{{ \App\Setting::first()->address }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="info">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="copy">جميع الحقوق محفوظة 2019</div>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled site-map text-center">
                        <li><a href="#">سياسة الخصوصية</a></li>
                        <li><a href="#">من نحن</a></li>
                        <li><a href="#">اتصل بنا</a></li>
                        <li><a href="#">الشروط و التحكم</a></li>
                    </ul>
                </div>
                <div class="col-md-3 last">
                    <div class="follow text-left">تابعنا    <a href="#"><i class="fab fa-facebook-square">@lang("                                   ")</i></a><a href="#"> <i class="fab fa-instagram"></i></a><a href="#"> <i class="fab fa-twitter"> </i></a></div>
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
                        <div class="col-md-6">
                            <button class="login form-control">تسجيل دخول </button>
                        </div>
                        <div class="col-md-6">
                            <button class="rig form-control">انشاء حساب</button>
                        </div>
                    </div>
                </div>
                <div class="container add-new">
                    <div class="row">
                        <div class="col-md-12">
                            <input class="login form-control" type="text" placeholder="اسم المستخدم"><i class="fas fa-user"></i>
                        </div>
                        <div class="col-md-12">
                            <input class="login form-control" type="password" placeholder="كلمة المرور"><i class="fas fa-lock"> </i>
                        </div>
                        <div class="col-md-12">
                            <button class="log form-control">دخول</button>
                        </div>
                    </div>
                </div>
                <div class="container rig-options">
                    <div class="row aligen-items">
                        <div class="col-md-6 text-right small-center">
                            <label for="remember">تذكر كلمة المرور</label>
                            <input type="radio" id="remember" checked>
                        </div>
                        <div class="col-md-6 text-left small-center"><a href="#">لقد نسيت كلمة المرور                                              </a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('public/assets/js/main.js')}}"></script>


<!-- Messenger المكون الإضافي "دردشة" Code -->
    <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v10.0'
          });
        };

        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/ar_AR/sdk/xfbml.customerchat.js';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
      </script>

      <!-- Your المكون الإضافي "دردشة" code -->
      <div class="fb-customerchat"
        attribution="biz_inbox"
        page_id="2444940492200410">
      </div>
</body>
</html>
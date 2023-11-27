<!-- Start subscribe -->
<div class="subscribe">
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <!-- Start d-flex -->
        <div class="d-flex align-items-center justify-content-between">
            <!-- Start subscribe-title -->
            <div class="subscribe-title d-flex align-items-center">
                <i class="icons8-origami-airplane"></i>
                <span>@lang("alnkel.footer-email")</span>
            </div>
            <!-- End subscribe-title -->
            <!-- Start input-gp -->
            <div class="input-gp">
                <i class="icons8-mail"></i>
                <input type="text" placeholder="@lang("alnkel.footer-write-email")">
            </div>
            <!-- End input-gp -->
        </div>
        <!-- End d-flex -->
    </div>
    <!-- End container-fluid -->
</div>
<!-- End subscribe -->
<!-- Start contact-us -->
<div class="contact-us section-bg section parallax fullscreen background" data-aos="fade-up" data-img-width="1920"
     data-img-height="1269"
     data-diff="100" data-oriz-pos="100%" style="background-image: url('/front-assets/images/content/footer.jpg');">
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <!-- Start contact-info -->
        <ul class="contact-info d-flex align-items-center justify-content-center flex-wrap">
            <li class="d-flex align-items-center">
                <i class="icons8-phone"></i>
                <span>{{ \App\Setting::first()->phone }}</span>
            </li>
            <li class="d-flex align-items-center">
                <i class="icons8-location-marker"></i>
                <span>{{ \App\Setting::first()->address }}</span>
            </li>
            <li class="d-flex align-items-center">
                <i class="icons8-mail-open"></i>
                <span>info@alnkhel.com</span>
            </li>
        </ul>
        <!-- End contact-info -->
        <!-- Start socail-media -->
        <ul class="social-media d-flex align-items-center justify-content-center">
            <li>
                <a class="scale-icons-hover d-flex" href="{{ \App\Setting::first()->facebook }}">
                    <i class="icons8-facebook"></i>
                </a>
            </li>
            <li>
                <a class="scale-icons-hover d-flex" href="{{ \App\Setting::first()->instagram }}">
                    <i class="icons8-instagram"></i>
                </a>
            </li>
            <li>
                <a class="scale-icons-hover d-flex" href="{{ \App\Setting::first()->twitter }}">
                    <i class="icons8-twitter"></i>
                </a>
            </li>
            <li>
                <a class="scale-icons-hover d-flex" href="{{ \App\Setting::first()->youtube }}">
                    <i class="icons8-youtube-squared"></i>
                </a>
            </li>
            <li>
                <a class="scale-icons-hover d-flex" href="{{ \App\Setting::first()->linked }}">
                    <i class="icons8-linkedin"></i>
                </a>
            </li>
        </ul>
        <!-- End social-media -->
    </div>
    <!-- End container-fluid -->
</div>
<!-- End contact-us -->

<!-- Start footer -->
<footer>
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <!-- Start d-flex -->
        <div class="d-flex align-items-center justify-content-between">
            <span>@lang("alnkel.footer-developed")</span>
            {{--<a href="#" class="oncloud">@lang("alnkel.footer-developed-by"): Oncloudeg.com</a>--}}
        </div>
        <!-- End d-flex -->
    </div>
    <!-- End container-fluid -->
</footer>
<!-- End footer -->
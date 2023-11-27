@extends('layouts.master-front')

@section('page-header')
    <!-- Start latest-offers -->
    <div class="latest-offers">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start section-header -->
            <div class="section-header section-header-light d-flex align-items-center justify-content-center">
                <i class="icons8-travel"></i>
                <span>@lang("alnkel.bestOffers")</span>
            </div>
            <!-- End section-header -->
            <!-- Start latestOffers -->
            <div id="latestOffers" class="owl-carousel">
                @foreach($best_travels as $travel)
                    <div class="item">
                        @include('includes.front.cards.travels',compact('travel'))
                    </div>
                @endforeach
                @foreach($best_flights as $flight)
                    <div class="item">
                        @include('includes.front.cards.flights',compact('flight'))
                    </div>
                @endforeach
                @foreach($best_visas as $visa)
                    <div class="item">
                        @include('includes.front.cards.visa',compact('visa'))
                    </div>
                @endforeach
            </div>
            <!-- End latestOffers -->
            <!-- Start home-carousel-controls -->
            <div class="home-carousel-controls d-flex align-items-center justify-content-center">
                <!-- Start homeCarouselPrev -->
                <div id="latestOffersPrev" class="custom-carousel-prev scale-icons-hover">
                    <i class="icons8-drop-down-arrow"></i>
                </div>
                <!-- End homeCarouselPrev -->

                <!-- Start homeCarouselDots -->
                <div id="latestOffersDots" class="custom-carousel-dots d-flex align-items-center">
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
                <div id="latestOffersNext" class="custom-carousel-next scale-icons-hover">
                    <i class="icons8-drop-down-arrow"></i>
                </div>
                <!--End premiumCarouselNext -->
            </div>
            <!-- End home-carousel-controls -->
        </div>
        <!-- End container-fluid -->

    </div>
    <!-- End latest-offers -->
@endsection

@section('content')
    <!-- Start travel-section -->
    <div class="travel-section section" data-aos="fade-up">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start section-header -->
            <div class="section-header d-flex align-items-center justify-content-center">
                <i class="icons8-country"></i>
                <span>@lang("alnkel.latestTravels")</span>
            </div>
            <!-- End section-header -->
            <!-- Start travelSection -->
            <div id="travelSection" class="owl-carousel">
                @foreach($travels as $travel)
                    <div class="item">
                        @include('includes.front.cards.travels',compact('travel'))
                    </div>
                @endforeach
            </div>
            <!-- End travelSection -->

            <!-- Start section-footer -->
            <div class="section-footer d-flex align-items-center justify-content-between">
                <!-- Start section-carousel-controls -->
                <div class="section-carousel-controls d-flex align-items-center">
                    <!-- Start homeCarouselPrev -->
                    <div id="travelSectionPrev" class="custom-carousel-prev scale-icons-hover">
                        <i class="icons8-drop-down-arrow"></i>
                    </div>
                    <!-- End homeCarouselPrev -->

                    <!-- Start homeCarouselDots -->
                    <div id="travelSectionDots" class="custom-carousel-dots d-flex align-items-center">
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
                    <div id="travelSectionNext" class="custom-carousel-next scale-icons-hover">
                        <i class="icons8-drop-down-arrow"></i>
                    </div>
                    <!--End premiumCarouselNext -->
                </div>
                <!-- End section-carousel-controls -->
                <a href="{{ route('travels') }}" class="view-all d-flex align-items-center">
                    <i class="icons8-grid"></i>
                    <span>@lang("alnkel.showAll")</span>
                </a>
            </div>
            <!-- End section-footer -->

        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End travel-section -->
    <!-- Start fly-section -->
    <div class="fly-section section-bg section parallax fullscreen background" data-aos="fade-up" data-img-width="1920"
         data-img-height="1269" data-diff="100"
         data-oriz-pos="100%" style="background-image: url('/front-assets/images/content/section.jpg');">
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
                @foreach($flights as $flight)
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
    <!-- Start visa-section -->
    <div class="visa-section section" data-aos="fade-up">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start section-header -->
            <div class="section-header d-flex align-items-center justify-content-center">
                <i class="icons8-passport"></i>
                <span>@lang("alnkel.latestVisas")</span>
            </div>
            <!-- End section-header -->
            <!-- Start travelSection -->
            <div id="visaSection" class="owl-carousel">
                @foreach($visas as $visa)
                    <div class="item">
                        @include('includes.front.cards.visa',compact('visa'))
                    </div>
                @endforeach
            </div>
            <!-- End travelSection -->

            <!-- Start section-footer -->
            <div class="section-footer d-flex align-items-center justify-content-between">
                <!-- Start section-carousel-controls -->
                <div class="section-carousel-controls d-flex align-items-center">
                    <!-- Start homeCarouselPrev -->
                    <div id="visaSectionPrev" class="custom-carousel-prev scale-icons-hover">
                        <i class="icons8-drop-down-arrow"></i>
                    </div>
                    <!-- End homeCarouselPrev -->

                    <!-- Start homeCarouselDots -->
                    <div id="visaSectionDots" class="custom-carousel-dots d-flex align-items-center">
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
                    <div id="visaSectionNext" class="custom-carousel-next scale-icons-hover">
                        <i class="icons8-drop-down-arrow"></i>
                    </div>
                    <!--End premiumCarouselNext -->
                </div>
                <!-- End section-carousel-controls -->
                <a href="{{ route('visas') }}" class="view-all d-flex align-items-center">
                    <i class="icons8-grid"></i>
                    <span>@lang("alnkel.showAll")</span>
                </a>
            </div>
            <!-- End section-footer -->

        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End visa-section -->
@endsection
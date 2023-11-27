@extends('layouts.master-front')

@section('page-header')
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span>{{ $visa->name[App::getLocale()] }}</span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
@endsection

@section('content')
    @if(session()->has('fail'))
        <div class="alert m-alert m-alert--default alert-danger" role="alert">
            {{ session()->get('fail') }}
        </div>
    @elseif(session()->has('success'))
        <div class="alert m-alert m-alert--default alert-success" role="alert">
            {{session()->get('success') }}
        </div>
    @endif
    <!-- Start visa-inner -->
    <div class="visa-inner">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start inner-head-gp -->
            <div class="inner-head-gp d-flex align-items-center justify-content-between">
                <!-- Start inner-head -->
                <div class="inner-head d-flex align-items-center">
                    <i class="icons8-view-details"></i>
                    <div>
                        <span>@lang("alnkel.visa-order-confirmation"):</span>
                    </div>
                </div>
                <!-- End inner-head -->
            </div>
            <!-- End inner-head-gp -->

            <?php
            $commission = 0;
            if ( $visa->commission > 0 ) {
	            $commissionObject = getCommission($visa);
//	            dd($commissionObject);
	            $commission = $commissionObject->commission;
	            if ( $commissionObject->is_percent ) {
		            $commission = ( $price * $commissionObject->commission ) / 100;
	            }
            }
            ?>

            <!-- Start checkout-table -->
            <table class="table checkout-table">
                <thead>
                <tr>
                    <th scope="col">@lang("alnkel.visa-current-balance")</th>
                    <th scope="col">@lang("alnkel.visa-cost-per-person")</th>
                    <th scope="col">@lang("alnkel.visa-passengers-number")</th>
                    <th scope="col">@lang("alnkel.visa-final-price")</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>
                        <span class="Allowed">{{ Auth::user()->balance }} @lang("alnkel.visa-dollar")</span>
                    </th>
                    <th>
                        <span class="someInfo">{{ $visa->price['adult'] }} @lang("alnkel.visa-dollar")</span>
                    </th>
                    <th>
                        <span class="someInfo">
                            @if($travelers === 1)
                                @lang("alnkel.visa-person")
                            @else
                                {{ $travelers }} @lang("alnkel.visa-people")
                            @endif
                        </span>
                    </th>
                    <th>
                        <span class="notAllowed">{{ ($price - $commission) }} @lang("alnkel.visa-dollar")</span>
                    </th>
                </tr>
                </tbody>
            </table>
            <!-- End checkout-table -->
            <!-- Start action-btns -->
            <div class="action-btns d-flex align-items-center justify-content-center">
                <a href="{{ route('visa-checkout-form',['visa' => $visa->id]) }}" id="blockButton"
                   class="btn-reset submit-btn d-flex align-items-center justify-content-center">
                    <i class="icons8-done"></i>
                    <span>@lang("alnkel.visa-final-price")</span>
                </a>
            </div>
            <!-- End action-btns -->
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
                <span>@lang("alnkel.latestVisas")</span>
            </div>
            <!-- End section-header -->
            <!-- Start visaSection -->
            <div id="flySection" class="owl-carousel">
                @foreach($latest_visas as $visa)
                    <div class="item">
                        @include('includes.front.cards.visa',compact('visa'))
                    </div>
                @endforeach
            </div>
            <!-- End visaSection -->

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
                <a href="#" class="view-all d-flex align-items-center">
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

@section('scripts')
    <script src="{{ asset('front-assets/js/jquery.blockUI.js') }}"></script>
    <script>
        $('#blockButton').click(function () {
            $.blockUI({
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                }
            });
        });
    </script>
@endsection
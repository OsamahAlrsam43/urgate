@extends('layouts.master-front')

@section('title')
    {{ $flight->name[App::getLocale()] }}  
@endsection

@section('page-header')
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span>{{ $flight->name[App::getLocale()] }}</span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
@endsection

@section('content')
    <!-- Start fly-inner -->
    <div class="fly-inner">

        <!-- Start fly-ticket -->
        <div class="fly-ticket">
            <!-- Start container-fluid -->
            <div class="container-fluid">
                <!-- Start inner-head -->
                <div class="inner-head d-flex align-items-center">
                    <i class="icons8-view-details"></i>
                    <span>@lang("alnkel.flight-data")</span>
                </div>
                <!-- End inner-head -->
            </div>
            <!-- End container-fluid -->
            <!-- Start fly-ticket-gp -->
            <div class="fly-ticket-gp d-flex align-items-stretch">
                <!-- Start fly-ticket-company -->
                <div class="fly-ticket-company d-flex align-items-center justify-content-center">
                    <img src="{{ Storage::url($flight->aircraft_logo) }}" alt="test">
                    <ul>
                        <li><span>{{ $flight->aircraft_operator[App::getLocale()] }}</span></li>
                        <li><p>@lang("alnkel.flight-class"): {{$flight->class[App::getLocale()]  }}</p></li>
                        <li><p>{{ $flight->airplane_type[App::getLocale()] }}</p></li>
                    </ul>
                </div>
                <!-- End fly-ticket-company -->
                <!-- Start fly-ticket-destinations -->
                <div class="fly-ticket-destinations d-flex align-items-center  justify-content-center flex-wrap">
                    <!-- Start fly-ticket-destination -->
                    <div class="fly-ticket-destination d-flex align-items-center justify-content-between">
                        <ul>
                            <li>
                                <span>{{ \App\Country::find($flight->trip_information['common']['going']['from_country'])->name[App::getLocale()] }}</span>
                            </li>
                            @php
                                $start_date = \Carbon\Carbon::parse($flight->trip_information['common']['going']['start_date']);
                                $end_date = \Carbon\Carbon::parse($flight->trip_information['common']['going']['end_date']);
                            @endphp
                            <li><p>{{ $start_date->format('h:i a') }},
                                    {{ __('alnkel.'.$start_date->format('D')) }} {{ $start_date->format('d') }} {{ __('alnkel.'.$start_date->format('M')) }} {{ $start_date->format('Y') }}</p>
                            </li>
                            <li><p>{{ $flight->trip_information[App::getLocale()]['going']['from_airport'] }},
                                    {{ $flight->trip_information[App::getLocale()]['going']['from_city'] }}
                                    , {{ $flight->trip_information[App::getLocale()]['going']['from_lounge'] }}</p>
                            </li>
                        </ul>
                        <img src="{{ asset('front-assets/images/basic/icons8-arrow.png') }}" alt="arrow">
                        <ul>
                            <li>
                                <span>{{ \App\Country::find($flight->trip_information['common']['going']['to_country'])->name[App::getLocale()] }}</span>
                            </li>
                            <li><p>{{ $end_date->format('h:i a') }},
                                    {{ __('alnkel.'.$end_date->format('D')) }} {{ $end_date->format('d') }} {{ __('alnkel.'.$end_date->format('M')) }} {{ $end_date->format('Y') }}</p>
                            </li>
                            <li><p>{{ $flight->trip_information[App::getLocale()]['going']['to_airport'] }},
                                    {{ $flight->trip_information[App::getLocale()]['going']['to_city'] }}
                                    , {{ $flight->trip_information[App::getLocale()]['going']['to_lounge'] }}</p>
                            </li>
                        </ul>
                    </div>
                    <!-- End fly-ticket-destination -->
                    @if($flight->ticket === 'RoundTrip')
                        <div class="fly-ticket-destination d-flex align-items-center justify-content-between">
                            <ul>
                                <li>
                                    <span>{{ \App\Country::find($flight->trip_information['common']['going']['to_country'])->name[App::getLocale()] }}</span>
                                </li>
                                @php
                                    $start_date = \Carbon\Carbon::parse($flight->trip_information['common']['coming']['start_date']);
                                    $end_date = \Carbon\Carbon::parse($flight->trip_information['common']['coming']['end_date']);
                                @endphp
                                <li><p>{{ $start_date->format('h:i a') }},
                                        {{ __('alnkel.'.$start_date->format('D')) }} {{ $start_date->format('d') }} {{ __('alnkel.'.$start_date->format('M')) }} {{ $start_date->format('Y') }}</p>
                                </li>
                                <li><p>{{ $flight->trip_information[App::getLocale()]['coming']['from_airport'] }},
                                        {{ $flight->trip_information[App::getLocale()]['coming']['from_city'] }}
                                        , {{ $flight->trip_information[App::getLocale()]['coming']['from_lounge'] }}</p>
                                </li>
                            </ul>
                            <img src="{{ asset('front-assets/images/basic/icons8-arrow.png') }}" alt="arrow">
                            <ul>
                                <li>
                                    <span>{{ \App\Country::find($flight->trip_information['common']['going']['from_country'])->name[App::getLocale()] }}</span>
                                </li>
                                <li><p>{{ $end_date->format('h:i a') }},
                                        {{ __('alnkel.'.$end_date->format('D')) }} {{ $end_date->format('d') }} {{ __('alnkel.'.$end_date->format('M')) }} {{ $end_date->format('Y') }}</p>
                                </li>
                                <li><p>{{ $flight->trip_information[App::getLocale()]['coming']['to_airport'] }},
                                        {{ $flight->trip_information[App::getLocale()]['coming']['to_city'] }}
                                        , {{ $flight->trip_information[App::getLocale()]['coming']['to_lounge'] }}</p>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
                <!-- End fly-ticket-destinations -->
                <!-- Start fly-ticket-features -->
                <div class="fly-ticket-features d-flex align-items-center  justify-content-center">
                    <ul>
                        <li>
                            <span>@lang("alnkel.flight-amenities")</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="icons8-plane"></i>
                            <p>@lang("alnkel.flight-plane-type"): {{ $flight->airplane_type[App::getLocale()] }}</p>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="icons8-flight-seat"></i>
                            <p>@lang("alnkel.flight-seats-type"): {{ $flight->seat_type[App::getLocale()] }}</p>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="icons8-power-plug"></i>
                            <p>@lang("alnkel.flight-electric-port")
                                : {{ $flight->electric_port[App::getLocale()] }}</p>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="icons8-tv"></i>
                            <p>@lang("alnkel.flight-display"): {{ $flight->display[App::getLocale()] }}</p>
                        </li>
                    </ul>
                </div>
                <!-- End fly-ticket-features -->
                <!-- Start fly-ticket-book -->
                <div class="fly-ticket-book">
                    <!-- Start fly-ticket-price -->
                    <div class="fly-ticket-price d-flex align-items-center justify-content-center">
                        <div>
                            <span>${{ $flight->price['baby'] }} <i>|</i> ${{ $flight->price['children'] }}
                                <i>|</i> ${{ $flight->price['adult'] }}</span>
                            <p>@lang("alnkel.flight-person') }} <i>|</i> {{ __('alnkel.flight-child")
                                <i>|</i> @lang("alnkel.flight-baby")</p>
                        </div>
                    </div>
                    <!-- End fly-ticket-price -->
                    <!-- Start fly-ticket-book-now -->
                    <a href="{{ route('flight-pre-checkout',['flight' => $flight->id]) }}"
                       class="fly-ticket-book-now d-flex align-items-center justify-content-center">
                        <i class="icons8-calendar-with-ok-sign"></i>
                        <span>@lang("alnkel.flight-book-now")</span>
                    </a>
                    <!-- End fly-ticket-book-now -->
                </div>
                <!-- End fly-ticket-book -->
            </div>
            <!-- End fly-ticket-gp -->
        </div>
        <!-- End fly-ticket -->

        <!-- Start cancellation-policy -->
        <div class="cancellation-policy">
            <!-- Start container-fluid -->
            <div class="container-fluid">
                <!-- Start inner-head -->
                <div class="inner-head d-flex align-items-center">
                    <i class="icons8-view-details"></i>
                    <span>@lang("alnkel.flight-book-cancel")</span>
                </div>
                <!-- End inner-head -->
            </div>
            <!-- End container-fluid -->
            <!-- Start table-responsive -->
            <table class="table fly-table">
                <thead>
                <tr>
                    <th scope="col">@lang("alnkel.flight-book-cancel-before")</th>
                    <th scope="col">@lang("alnkel.flight-book-cancel-after")</th>
                    <th scope="col">@lang("alnkel.flight-book-cancel-non")</th>
                    <th scope="col">@lang("alnkel.flight-book-change-before")</th>
                    <th scope="col">@lang("alnkel.flight-book-change-after")</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    
                    <th>
                        <span class="{{ $flight->cancellation_before_departure === '0' ? 'notAllowed' : 'Allowed' }}">
                          {{ $flight->cancellation_before_departure === '0' ? __('alnkel.flight-not-allowed') : __('alnkel.flight-allowed') }}
                        </span>
                        <b>{{ $flight->cancellation_before_departure === '0' ?  '' : "($$flight->cancellation_before_departure_price )"   }}</b>
                    </th>

                    <th>
                        <span class="{{ $flight->cancellation_after_departure === '0' ? 'notAllowed' : 'Allowed' }}">
                          {{ $flight->cancellation_after_departure === '0' ? __('alnkel.flight-not-allowed') : __('alnkel.flight-allowed') }}
                        </span>
                        <b>{{ $flight->cancellation_after_departure === '0' ?  '' : "($$flight->cancellation_after_departure_price )"   }}</b>
                    </th>

                    <th>
                        <span class="{{ $flight->absence === '0' ? 'notAllowed' : 'Allowed' }}">
                          {{ $flight->absence === '0' ? __('alnkel.flight-not-allowed') : __('alnkel.flight-allowed') }}
                        </span>
                        <b>{{ $flight->absence === '0' ?  '' : "($$flight->absence_price )"   }}</b>
                    </th>

                    <th>
                        <span class="{{ $flight->change_before_departure === '0' ? 'notAllowed' : 'Allowed' }}">
                          {{ $flight->change_before_departure === '0' ? __('alnkel.flight-not-allowed') : __('alnkel.flight-allowed') }}
                        </span>
                        <b>{{ $flight->change_before_departure === '0' ?  '' : "($$flight->change_before_departure_price )"   }}</b>
                    </th>

                    <th>
                        <span class="{{ $flight->change_after_departure === '0' ? 'notAllowed' : 'Allowed' }}">
                          {{ $flight->change_after_departure === '0' ? __('alnkel.flight-not-allowed') : __('alnkel.flight-allowed') }}
                        </span>
                        <b>{{ $flight->change_after_departure === '0' ?  '' : "($$flight->change_after_departure_price )"   }}</b>
                    </th>




                </tr>
                </tbody>
            </table>
            <!-- End table-responsive -->
        </div>
        <!-- End cancellation-policy -->
    </div>
    <!-- End fly-inner -->

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
            <!-- Start flightSection -->
            <div id="flySection" class="owl-carousel">
                @foreach($latest_flights as $flight)
                    <div class="item">
                        @include('includes.front.cards.flights',compact('flight'))
                    </div>
                @endforeach
            </div>
            <!-- End flightSection -->

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
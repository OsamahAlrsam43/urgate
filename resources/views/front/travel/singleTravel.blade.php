@extends('layouts.master-front')

@section('title')
    {{ $travel->name[App::getLocale()] }}
@endsection

@section('page-header')
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-country"></i>
                <span>{{ $travel->name[App::getLocale()] }}</span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
@endsection

@section('content')

    <!-- Start travel-inner -->
    <div class="travel-inner">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start inner-head-gp -->
            <div class="inner-head-gp d-flex align-items-center justify-content-between">
                <!-- Start inner-head -->
                <div class="inner-head d-flex align-items-center">
                    <i class="icons8-view-details"></i>
                    <div>
                        <span>@lang("alnkel.travel-details"):</span>
                    </div>
                </div>
                <!-- End inner-head -->
                <!-- Start inner-prices -->
                <div class="inner-prices d-flex align-items-center">
                    <i class="icons8-expensive-price"></i>
                    <span>@lang("alnkel.travel-cost"): ${{ $travel->price[0]['adult'] }}
                        @lang("alnkel.travel-person") <b>|</b> ${{ $travel->price[0]['children'] }}
                        @lang("alnkel.travel-child") <b>|</b> ${{ $travel->price[0]['baby'] }}
                        @lang("alnkel.travel-baby")</span>
                </div>
                <!-- End inner-prices -->
            </div>
            <!-- End inner-head-gp -->
            <!-- Start travel-post -->
            <div class="travel-post">
                <!-- Start travel-post-gallery -->
                <div class="travel-post-gallery">
                    <!-- Start travelCarousel -->
                    <div id="travelCarousel" class="owl-carousel">
                        @foreach($travel->images as $image)
                            <div class="item">
                                <a href="{{ Storage::url($image->image) }}" class="gallery-item">
                                    <img src="{{ Storage::url($image->image) }}" alt="test">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <!-- End travelCarousel -->
                    <!-- Start section-carousel-controls -->
                    <div class="section-carousel-controls d-flex align-items-center justify-content-center">
                        <!-- Start homeCarouselPrev -->
                        <div id="travelCarouselPrev" class="custom-carousel-prev scale-icons-hover">
                            <i class="icons8-drop-down-arrow"></i>
                        </div>
                        <!-- End homeCarouselPrev -->

                        <!-- Start homeCarouselDots -->
                        <div id="travelCarouselDots" class="custom-carousel-dots d-flex align-items-center">
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
                        <div id="travelCarouselNext" class="custom-carousel-next scale-icons-hover">
                            <i class="icons8-drop-down-arrow"></i>
                        </div>
                        <!--End premiumCarouselNext -->
                    </div>
                    <!-- End section-carousel-controls -->
                </div>
                <!-- End travel-post-gallery -->
                <!-- Start travel-post-text -->
                <div class="travel-post-text">
                    {!! $travel->description[App::getLocale()] !!}
                </div>
                <!-- End  travel-post-text -->
                <!-- Start action-btns -->
                <div class="action-btns d-flex align-items-center justify-content-end">
                    {{--<a href="{{ route('travel-pre-checkout',['travel' => $travel->id]) }}"--}}
                    {{--class="btn-reset submit-btn d-flex align-items-center justify-content-center">--}}
                    {{--<i class="icons8-calendar-with-ok-sign"></i>--}}
                    {{--<span>@lang("alnkel.travel-book-now")</span>--}}
                    {{--</a>--}}

                    <a href="#!"
                       class="btn-reset submit-btn d-flex align-items-center justify-content-center reserve"
                       data-toggle="modal"
                       data-target="#m_modal_3"
                       data-id="{{ $travel->id }}"
                       style="margin-top: 35px;">
                        <i class="icons8-calendar-with-ok-sign"></i>
                        <span>@lang("alnkel.travel-book-now")</span>
                    </a>
                </div>
                <!-- End action-btns -->
            </div>
            <!-- End travel-post -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End travel-inner -->

    <!-- Start fly-section -->
    <div class="fly-section section-bg section parallax fullscreen background" data-aos="fade-up" data-img-width="1920"
         data-img-height="1269" data-diff="100"
         data-oriz-pos="100%" style="background-image: url('/front-assets/images/content/section.jpg');">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start section-header -->
            <div class="section-header section-header-light d-flex align-items-center justify-content-center">
                <i class="icons8-country"></i>
                <span>@lang("alnkel.latestTravels")</span>
            </div>
            <!-- End section-header -->
            <!-- Start travelSection -->
            <div id="flySection" class="owl-carousel">
                @foreach($latest_travels as $travel)
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

    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="reserve-form" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{__("charter.select_passengers")}}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="margin-bottom: 20px;">
                            <label class="col-md-8">@lang("travel.room_type"):</label>
                            <div class="col-md-4">
                                <select class="passengers" name="type">
                                    @if($travel->price[0]['reserved_seats'] < $travel->price[0]['seats'])
                                        <option value="0">أحادية</option>@endif
                                    @if($travel->price[1]['reserved_seats'] < $travel->price[1]['seats'])
                                        <option value="1">ثنائية</option>@endif
                                    @if($travel->price[2]['reserved_seats'] < $travel->price[2]['seats'])
                                        <option value="2">ثلاثية</option>@endif
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 20px;">
                            <label class="col-md-8">@lang("travel.adult"):</label>
                            <div class="col-md-4">
                                <select class="passengers" name="adult">
                                    @for($i=0;$i<=9;$i++)
                                        <option value="{{ $i }}" {{ old('adult') == $i or $i == 1 ? 'selected' : ''}}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 20px;">
                            <label class="col-md-8">@lang("travel.children"):</label>
                            <div class="col-md-4">
                                <select class="passengers" name="children">
                                    @for($i=0;$i<=5;$i++)
                                        <option value="{{ $i }}" {{ old('children') == $i ? 'selected' : ''}}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 20px;">
                            <label class="col-md-8">@lang("travel.baby"):</label>
                            <div class="col-md-4">
                                <select class="passengers" name="baby">
                                    @for($i=0;$i<=5;$i++)
                                        <option value="{{ $i }}" {{ old('baby') == $i ? 'selected' : ''}}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="reserve-btn btn btn-warning">
                            {{__('charter.reserve')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal-->
@endsection

@section('scripts')
    <script>
        $('.reserve').on('click', function () {
            var day = $(this).data("day");
            var id = $(this).data("id");
            var action = "{{ route('travel-pre-checkout',['travel' => 'xx']) }}";

            $("[name=day]").val(day);
            $('#reserve-form').attr('action', action.replace("xx", id));
        });

        $('.reserve-btn').on('click', function (e) {
            e.preventDefault();

            var type = parseInt($('#reserve-form [name=type]').val());
            var adult = parseInt($('#reserve-form [name=adult]').val());
            var children = parseInt($('#reserve-form [name=children]').val());
            var baby = parseInt($('#reserve-form [name=baby]').val());

            if (adult == 0 && children == 0 && baby == 0) {
                alert("{{__("charter.select_min_one")}}");
                return false;
            }

            if ((type + 1) < (adult + children)) {
                alert("{{__("travel.max_of")}}" + (type + 1));
                return false;
            }

            $('#reserve-form').submit();
            return true;
        });

        $('[data-toggle="tooltip"]').tooltip();
    </script>
@endsection
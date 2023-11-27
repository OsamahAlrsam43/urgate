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
                <i class="icons8-plane"></i>
                <span>{{ $travel->name[App::getLocale()] }}</span>
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
        <div class="alert m-alert m-alert--default alert-success" role="alert" style="margin: 20px">
            {{session()->get('success') }}
        </div>

        <a href="{{route('download-travel-ticket', ['order' => session()->get('pnr')])}}" class="btn btn-primary"
           style="margin: 0 20px;">{{__('charter.download')}}</a>
    @endif

    <!-- Start visa-inner -->
    <div class="visa-inner">
        <!-- Start container-fluid -->
        <div class="container-fluid">
        @if(Auth::check() and !session()->has('success'))
            <!-- Start inner-head-gp -->
                <div class="inner-head-gp d-flex align-items-center justify-content-between">
                    <!-- Start inner-head -->
                    <div class="inner-head d-flex align-items-center">
                        <i class="icons8-view-details"></i>
                        <div>
                            <span>@lang("alnkel.single-travel-page-title")</span>
                        </div>
                    </div>
                    <!-- End inner-head -->
                </div>
                <!-- End inner-head-gp -->

				<?php
				$day = Request()->get( "type" );
				$adultsCount = Request()->get( "adult" );
				$childrenCount = Request()->get( "children" );
				$babyCount = Request()->get( "baby" );

				$priceDay = $travel->price[ $day ];

				$total_client = 0;
				$total_client += $priceDay['adult'] * $adultsCount;
				$total_client += $priceDay['children'] * $childrenCount;
				$total_client += $priceDay['baby'] * $babyCount;

				$commission = 0;
				if ( $travel->commission > 0 ) {
					$commissionObject = getCommission( $travel );
					$commission       = $commissionObject->commission;
					if ( $commissionObject->is_percent ) {
						$commission = ( $total_client * $commissionObject->commission ) / 100;
					}
				}

				$total_company = $total_client - $commission;

				$adultCommission = $childrenCommission = $babyCommission = $businessCommission = 0;
				if ( $travel->commission > 0 ) {
					$adultCommission = $childrenCommission = $babyCommission = $businessCommission = $commissionObject->commission;
					if ( $commissionObject->is_percent ) {
						$adultCommission    = ( $priceDay['adult'] * $commissionObject->commission ) / 100;
						$childrenCommission = ( $priceDay['children'] * $commissionObject->commission ) / 100;
						$babyCommission     = ( $priceDay['baby'] * $commissionObject->commission ) / 100;
					}
				}

				$adultCompany = $priceDay['adult'] - $adultCommission;
				$childrenCompany = $priceDay['children'] - $childrenCommission;
				$babyCompany = $priceDay['baby'] - $babyCommission;
				?>

                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">@lang("charter.adult_price")</th>
                        <th scope="col">@lang("charter.child_price")</th>
                        <th scope="col">@lang("charter.baby_price")</th>
                        <th scope="col">@lang("charter.total")</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>@lang("charter.client_price")</td>
                        <td>{{ $priceDay['adult'] }}</td>
                        <td>{{ $priceDay['children'] }}</td>
                        <td>{{ $priceDay['baby'] }}</td>
                        <td>{{ $total_client }}</td>
                    </tr>
                    <tr>
                        <td>@lang("charter.company_price")</td>
                        <td>{{ $adultCompany }}</td>
                        <td>{{ $childrenCompany }}</td>
                        <td>{{ $babyCompany }}</td>
                        <td>{{ $total_company }}</td>
                    </tr>
                    </tbody>
                </table>

                <!-- Start inner-head-gp -->
                <div class="inner-head-gp d-flex align-items-center justify-content-between" style="margin-top: 10px;">
                    <!-- Start inner-head -->
                    <div class="inner-head d-flex align-items-center">
                        <i class="icons8-view-details"></i>
                        <div>
                            <span>@lang("alnkel.single-travel-page-title")</span>
                        </div>
                    </div>
                    <!-- End inner-head -->
                </div>
                <!-- End inner-head-gp -->

				<?php
				$requiredSeats = $adultsCount + $childrenCount;
				$available_seats = $travel->price[ $day ]['seats'];

				if ( isset( $travel->price[ $day ]['reserved_seats'] ) ) {
					$available_seats = $travel->price[ $day ]['seats'] - $travel->price[ $day ]['reserved_seats'];
				}
				?>

                <!-- Start custom-form -->
                @if($requiredSeats <= $available_seats)
                    <form class="custom-form" method="post" enctype="multipart/form-data"
                          action="{{ route('travel-pre-checkout-form',['travel' => $travel->id]) }}{{"?day=".Request()->get("type")."&adult=".Request()->get("adult")."&children=".Request()->get("children")."&baby=".Request()->get("baby")}}">
                        <!-- Start form-row -->
						<?php $index = 0; ?>
                        @foreach($travelers as $traveler)
                            <div class="form-row">
                                <h3>{{ __('charter.'.$traveler[1]) }}</h3>
                                <!-- Start form-group -->
                                @if($traveler[1] != "baby")
                                    <div class="form-group col-lg-3 col-md-4 custom-form-group">
                                        <label for="inputEmail4">@lang("charter.title")
                                            <b>*</b>
                                        </label>
                                        <!-- Start custom-input -->
                                        <div class="custom-input d-flex align-items-stretch">
                                            <!-- Start input-icon -->
                                            <div class="input-icon d-flex align-items-center">
                                                <i class="icons8-edit-file"></i>
                                            </div>
                                            <!-- End input-icon -->
                                            <select type="text" name="title[]" class="form-control">
                                                <option @if(old('title.'.$index) == __('charter.mr')) selected @endif>{{__('charter.mr')}}</option>
                                                <option @if(old('title.'.$index) == __('charter.mrs')) selected @endif>{{__('charter.mrs')}}</option>
                                            </select>
                                        </div>
                                        <!-- End custom-input -->
                                    </div>
                            @endif
                            <!-- Start form-group -->
                                <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                    <label for="inputEmail4">@lang("alnkel.single-visa-first-name")
                                        <b>*</b>
                                    </label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <input type="text" name="first_name[]" value="{{ old('first_name.0') }}"
                                               class="form-control"
                                               id="inputEmail4"
                                               placeholder="@lang("alnkel.single-visa-enter-first-name")...">
                                        @if(isset($errors->messages()['first_name.0']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['first_name.0'][0] }}
                                            </div>
                                        @endif
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <!-- End form-group -->
                                <!-- Start form-group -->
                                <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                    <label for="inputEmail4">@lang("alnkel.single-visa-last-name")
                                        <b>*</b>
                                    </label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <input type="text" name="last_name[]" value="{{ old('last_name.0') }}"
                                               class="form-control"
                                               id="inputEmail4"
                                               placeholder="@lang("alnkel.single-visa-enter-last-name")...">
                                        @if(isset($errors->messages()['last_name.0']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['last_name.0'][0] }}
                                            </div>
                                        @endif
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <!-- End form-group -->
                                <!-- Start form-group -->
                                <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                    <label for="inputEmail4">@lang("alnkel.single-visa-birth-place")</label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <input type="text" name="birth_place[]" value="{{ old('birth_place.0') }}"
                                               class="form-control"
                                               id="inputEmail4"
                                               placeholder="@lang("alnkel.single-visa-enter-birth-place")...">
                                        @if(isset($errors->messages()['birth_place.0']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['birth_place.0'][0] }}
                                            </div>
                                        @endif
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <!-- End form-group -->
                                <!-- Start form-group -->
                                <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                    <label for="inputEmail4">@lang("alnkel.single-visa-birth-date")</label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <input type="text" name="birth_date[]" value="{{ old('birth_date.0') }}"
                                               class="form-control birthday-{{$traveler[1]}} date-mask"
                                               placeholder="@lang("alnkel.single-visa-enter-birth-date")ا...">
                                    <!-- @if(isset($errors->messages()['birth_date.0']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
{{  $errors->messages()['birth_date.0'][0] }}
                                                </div>
@endif -->
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <!-- End form-group -->
                                <!-- Start form-group -->
                                <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                    <label for="inputEmail4">@lang("alnkel.single-visa-nationality")</label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <select class="js-example-basic-single" name="nationality[]">
                                            <option></option>
                                            @foreach($nationalities as $country)
                                                <option value="{{ $country->id }}"
                                                        {{ ($country->id == 104 or old('nationality.'.$index) == $country->id) ? 'selected' : ''}}>{{ $country->name["en"] }}</option>
                                            @endforeach
                                        </select>
                                        @if(isset($errors->messages()['nationality.'.$index]))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['nationality.'.$index][0] }}
                                            </div>
                                        @endif
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <!-- End form-group -->
                                <!-- Start form-group -->
                                <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                    <label for="inputEmail4">@lang("alnkel.single-visa-passport-number")
                                        <b>*</b>
                                    </label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <input type="text" name="passport_number[]"
                                               value="{{ old('passport_number.0') }}"
                                               class="form-control" id="inputEmail4"
                                               placeholder="@lang("alnkel.single-visa-enter-passport-number") ...">
                                        @if(isset($errors->messages()['passport_number.0']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['passport_number.0'][0] }}
                                            </div>
                                        @endif
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <!-- End form-group -->
                                <!-- Start form-group -->
                                <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                    <label for="inputEmail4">@lang("alnkel.single-visa-passport-start-date")</label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <input type="text" name="passport_issuance_date[]"
                                               value="{{ old('passport_issuance_date.0') }}"
                                               class="form-control datepicker date-mask"
                                               placeholder="@lang("alnkel.single-visa-enter-passport-start-date") ...">
                                    <!-- @if(isset($errors->messages()['passport_issuance_date.0']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
{{  $errors->messages()['passport_issuance_date.0'][0] }}
                                                </div>
@endif -->
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <!-- End form-group -->
                                <!-- Start form-group -->
                                <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                    <label for="inputEmail4">@lang("alnkel.single-visa-passport-end-date")
                                        <b>*</b>
                                    </label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <input type="text" name="passport_expire_date[]"
                                               value="{{ old('passport_expire_date.0') }}"
                                               class="form-control datepicker date-mask"
                                               placeholder="@lang("alnkel.single-visa-enter-passport-end-date") ...">
                                        @if(isset($errors->messages()['passport_expire_date.0']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['passport_expire_date.0'][0] }}
                                            </div>
                                        @endif
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <!-- End form-group -->
                                <!-- Start form-group -->
                                <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                    <label for="inputEmail4">@lang("alnkel.single-visa-father-name")</label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <input type="text" name="father_name[]" value="{{ old('father_name.0') }}"
                                               class="form-control"
                                               id="inputEmail4"
                                               placeholder="@lang("alnkel.single-visa-enter-father-name") ...">
                                        @if(isset($errors->messages()['father_name.0']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['father_name.0'][0] }}
                                            </div>
                                        @endif
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <!-- End form-group -->
                                <!-- Start form-group -->
                                <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                    <label for="inputEmail4">@lang("alnkel.single-visa-mother-name")</label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <input type="text" name="mother_name[]" value="{{ old('mother_name.0') }}"
                                               class="form-control"
                                               id="inputEmail4"
                                               placeholder="@lang("alnkel.single-visa-enter-mother-name") ...">
                                        @if(isset($errors->messages()['mother_name.0']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['mother_name.0'][0] }}
                                            </div>
                                        @endif
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <!-- End form-group -->
                                <!-- Start form-group -->
                                <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                    <label for="inputEmail4">@lang("alnkel.single-visa-passport-image")
                                        <b>*</b>
                                    </label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <div class="custom-file">
                                            <input type="file" name="passport_image[]" class="custom-file-input"
                                                   id="customFile">
                                            <span class="custom-file-label" for="customFile">@lang("alnkel.single-visa-browse-device")
                                                ...</span>
                                            @if(isset($errors->messages()['passport_image']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['passport_image'][0] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <!-- End form-group -->
                                <!-- Start form-group -->
                                <div class="form-group col-lg-2 col-md-4 custom-form-group">
                                    <label for="inputEmail4">@lang("alnkel.single-visa-personal-image")
                                        <b>*</b>
                                    </label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <div class="custom-file">
                                            <input type="file" name="personal_image[]" class="custom-file-input"
                                                   id="customFile">
                                            <span class="custom-file-label" for="customFile">@lang("alnkel.single-visa-browse-device")
                                                ...</span>
                                            @if(isset($errors->messages()['personal_image']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['personal_image'][0] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <!-- End form-group -->
                            </div>
							<?php $index ++; ?>
                        @endforeach

                    <!-- End form-row -->
                        {!! csrf_field() !!}
                        <div class="action-btns d-flex align-items-center justify-content-end">
                            {{--<a href="#" id="cloneForm"--}}
                            {{--class="btn-reset add-btn d-flex align-items-center justify-content-center"><i--}}
                            {{--class="icons8-add-user-male"></i><span>@lang("alnkel.single-visa-add-another-applicant")</span></a>--}}
                            <button type="submit" id="blockButton"
                                    class="btn-reset submit-btn d-flex align-items-center justify-content-center">
                                <i
                                        class="icons8-done"></i><span>@lang("alnkel.single-visa-finish-application")</span>
                            </button>
                        </div>
                    </form>
                @endif
            <!-- End custom-form -->
            @else
                @if(!Auth::check())
                    <div class="alert m-alert m-alert--default alert-danger" role="alert">
                        @lang("alnkel.single-travel-please"), <a
                                href=""data-toggle="modal" 
    data-target="#login_modal">@lang("alnkel.single-travel-login") </a> {{ __("alnkel.single-travel-for-reservation")}}
                    </div>
                @endif
            @endif
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

        <?php
        $timestamp = strtotime( $travel->from_date );
        $childrenMinDate = date( "m", $timestamp ) . "/" . ( intval( date( "d", $timestamp ) ) + 1 ) . "/" . ( intval( date( "Y", $timestamp ) ) - 6 );
        $babyMinDate = date( "m", $timestamp ) . "/" . ( intval( date( "d", $timestamp ) ) + 1 ) . "/" . ( intval( date( "Y", $timestamp ) ) - 2 );
        ?>

        $('.birthday-adult').datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            maxDate: "+1D"
        });

        $('.birthday-children').datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            minDate: new Date('{{$childrenMinDate}}'),
            maxDate: "+1D"
        }).on('blur', function () {
            var date = $(this).val();
            if (moment(date, "DD/MM/YYYY").isBefore('{{$childrenMinDate}}')) {
                alert("Child age can't be more than 6 years.");
                $(this).val("");
            }
        });

        $('.birthday-baby').datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            minDate: new Date('{{$babyMinDate}}'),
            maxDate: "+1D"
        }).on('blur', function () {
            var date = $(this).val();
            if (moment(date, "DD/MM/YYYY").isBefore('{{$babyMinDate}}')) {
                alert("Child age can't be more than 2 years.");
                $(this).val("");
            }
        });
    </script>
@endsection
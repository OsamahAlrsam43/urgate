@extends('layouts.master-front')

@section('title')
@lang(" ")   @lang("alnkel.flights")
@endsection

@section('page-header')
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span>@lang("charter.charter")</span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
@endsection

@section('content')
    <!-- Start categorylist -->
    <div class="categorylist section" style="padding: 40px 0;">


        <!-- Start container-fluid -->
        <div class="container-fluid">
			<?php $i = 0; ?>
            @foreach($results as $result)
                @if(isset($result['fromToCountries']))
                    <div class="from-to-countries">{!! $result['fromToCountries'] !!}</div>
                @endif

                @if(isset($result['fromToDates']))
                    <div class="from-to-dates">
                        <a href="{{$result['fromToDates'][3]}}" class="btn btn-sm btn-warning"> << </a>
                        <span>{{__( 'charter.from' )}}</span> {{$result['fromToDates'][0]}}
                        <span>{{__( 'charter.to' )}}</span> {{$result['fromToDates'][1]}}
                        <a href="{{$result['fromToDates'][2]}}" class="btn btn-sm btn-warning"> >> </a>
                    </div>
                @endif

                <div class="row" style="margin-bottom: 30px;">
                    <table class="table table-sm charter-table" data-col="1">
                        <thead>
                        <tr>
                            <th scope="col">@lang("charter.reserve")</th>
                            <th scope="col"></th>
                            <th scope="col">@lang("charter.flight_date")</th>
                            <th scope="col">@lang("charter.flight_number")</th>
                            <th scope="col">@lang("charter.airline")</th>
                            <th scope="col">@lang("charter.airplane_type")</th>
                            <th scope="col">@lang("charter.adult_price")</th>
                            <th scope="col">@lang("charter.child_price")</th>
                            <th scope="col">@lang("charter.baby_price")</th>
                            <th scope="col">@lang("charter.business_price")</th>
                            <th scope="col">@lang("charter.status")</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result['items'] as $item)
							<?php $index = 0; ?>
							<?php $listed = 0; ?>
                            @foreach($item->price as $day)
                                @if(isset($allowedDaysGoing[$item->id][$day['date']]) or isset($allowedDaysComing[$item->id][$day['date']]))
									<?php
									$timestamp = strtotime( $day['date'] );
									$date = date( "d/m/Y", $timestamp );
									$day_name = __( 'days.' . date( 'l', $timestamp ) );

									$adult = Request::get( 'adult' );
									$children = Request::get( 'children' );
									$baby = Request::get( 'baby' );
									$business = Request::get( 'business' );

									$ticket = Request::get( 'ticket' );
									if($ticket == "RoundTrip") {
										$day['adult'] = isset($day['adult_2way']) ? $day['adult_2way'] : $day['adult'];
										$day['children'] = isset($day['children_2way']) ? $day['children_2way'] : $day['children'];
										$day['baby'] = isset($day['baby_2way']) ? $day['baby_2way'] : $day['baby'];
										$day['business'] = isset($day['business_2way']) ? $day['business_2way'] : $day['business'];
                                    }

									$requiredSeats = $adult + $children + $business;
									$available_seats = $day['seats'];

									if ( isset( $day['reserved_seats'] ) ) {
										$available_seats = $day['seats'] - $day['reserved_seats'];
									}

									$going = Request::get( 'going' );
									if ( $going ) {
										if ( strtotime( str_replace( "/", "-", $going ) ) > $timestamp ) {
											$available_seats = 0;
										}
									} else {
										if ( time() > $timestamp ) {
											$available_seats = 0;
										}
									}

									$commission = 0;
									if ( $item->commission > 0 ) {
										$commissionObject = getCommission($item);
										$commission = $commissionObject['commission'];
										if ( $commissionObject['is_percent'] ) {
											$commission = ( $day['adult'] * $commissionObject['commission'] ) / 100;
										}
									}

									$total_company = $day['adult'] - $commission;
									?>

                                    @if($requiredSeats <= $available_seats)
                                        @if(Auth::check())
                                            <tr data-toggle="tooltip" data-placement="top"
                                               >
                                        @else
                                            <tr>
                                                @endif
                                                <td data-time="{{$timestamp}}">
                                                    <input type="radio" name="reserve.{{$i}}" data-day="{{$index}}"
                                                           data-flight="{{$item->id}}" data-index="{{$i}}"
                                                           class="reserve-input" @if($i==1) disabled @endif />
                                                </td>
                                                <td>{{$item->ticket}}</td>
                                                <td>{{$day_name. ' ' .$date .' - '. $day['time']}}</td>
                                                <td>{{$item->flight_number}}</td>
                                                <td>{{$item->aircraft_operator[App::getLocale()]}}</td>
                                                <td>{{$item->airplane_type[App::getLocale()]}}</td>
                                                <td>{{$day['adult']}}</td>
                                                <td>{{$day['children']}}</td>
                                                <td>{{$day['baby']}}</td>
                                                <td>{{$day['business']}}</td>
                                                <td>{{$available_seats > 9 ? 9 : $available_seats}}</td>
                                            </tr>
                                        @endif

                                        <?php $listed++; ?>
                                    @endif

									<?php $index ++; ?>
                                    @endforeach
                                    @endforeach
                        </tbody>
                    </table>
                </div>
				<?php $i ++; ?>
            @endforeach
        </div>

        @if(count($results) > 0 and isset($results[0]['items']) and count($results[0]['items']) > 0 and $listed > 0)
            <a style="display: table;margin: 10px auto;" class="btn btn-warning reserve-button"
               data-href="{{ route('charter-pre-checkout',['flight' => 11111]) }}{{"?day={day}&adult=$adult&business=$business&children=$children&baby=$baby&back=noBack&backDay=noBackDay"}}">
                {{__('charter.reserve')}}
            </a>
        @endif

    <!-- End container-fluid -->
    </div>
    <!-- End categorylist -->
@endsection

@section('scripts')
    <script>
        $('#charter-tab').trigger('click');
        $('[data-toggle="tooltip"]').tooltip();

        $('[name="reserve.0"]').on('click', function () {
            var reserveButon = $('.reserve-button'),
                href = reserveButon.data('href');

            href = href.replace('11111', $('[name="reserve.0"]:checked').data('flight'));
            href = href.replace('{day}', $('[name="reserve.0"]:checked').data('day'));

            reserveButon.attr("href", href);
            $('[name="reserve.1"]').removeAttr("disabled");
            $('[name="reserve.1"]:checked').removeAttr("checked");
        });

        $('[name="reserve.1"]').on('click', function () {
            var reserveButon = $('.reserve-button'),
                href = reserveButon.data('href');

            href = href.replace('11111', $('[name="reserve.0"]:checked').data('flight'));
            href = href.replace('{day}', $('[name="reserve.0"]:checked').data('day'));

            href = href.replace('noBack', $('[name="reserve.1"]:checked').data('flight'));
            href = href.replace('noBackDay', $('[name="reserve.1"]:checked').data('day'));

            reserveButon.attr("href", href);
        });

        @if(count($results) > 1)
        $('.reserve-button').on('click', function (e) {
            if ($('[name="reserve.0"]:checked').length === 0 || $('[name="reserve.1"]:checked').length === 0) {
                e.preventDefault();
                alert("يرجي اختيار رحلة للذهاب و رحلة للعودة");
            }
        });
        @endif
    </script>
@endsection
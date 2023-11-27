<!-- Start card-block -->
<a href="{{ route('singleFlight',['flight' => $charter->id]) }}" class="card-block">
    <!-- Start card-block-content -->
    <div class="card-block-content d-flex flex-wrap align-content-between">
        <!-- Start card-block-top -->
        <div class="card-block-top d-flex align-items-center justify-content-between">
                <span class="card-type">{{ __('alnkel.'.$charter->ticket) }}
                    / {{ $charter->class[App::getLocale()] }}</span>
        </div>
        <!-- End card-block-top -->
        <!-- Start card-block-center -->
        <div class="card-block-center">
            <span class="card-title">{{ $charter->name[App::getLocale()] }}</span>
            <!-- Start card-list -->
            <ul class="card-list">
                <li class="d-flex align-items-center">
                    <i class="icons8-calendar"></i>
                    <span>
                                <b>@lang('alnkel.going')</b> {{ \Carbon\Carbon::parse($charter->trip_information['common']['going']['start_date'])->format('d') }}
                        {{ __('alnkel.'.\Carbon\Carbon::parse($charter->trip_information['common']['going']['start_date'])->format('M')) }}
                        {{ \Carbon\Carbon::parse($charter->trip_information['common']['going']['start_date'])->format('Y') }}
                        {{ \Carbon\Carbon::parse($charter->trip_information['common']['going']['start_date'])->format('h:s') }}
                        {{ __('alnkel.'.\Carbon\Carbon::parse($charter->trip_information['common']['going']['start_date'])->format('A')) }}
                        </span>
                </li>
                @if($charter->ticket === 'RoundTrip')
                    <li class="d-flex align-items-center">
                        <i class="icons8-calendar"></i>
                        <span>
                                <b>@lang('alnkel.coming')</b> {{ \Carbon\Carbon::parse($charter->trip_information['common']['coming']['start_date'])->format('d') }}
                            {{ __('alnkel.'.\Carbon\Carbon::parse($charter->trip_information['common']['coming']['start_date'])->format('M')) }}
                            {{ \Carbon\Carbon::parse($charter->trip_information['common']['coming']['start_date'])->format('Y') }}
                            {{ \Carbon\Carbon::parse($charter->trip_information['common']['coming']['start_date'])->format('h:s') }}
                            {{ __('alnkel.'.\Carbon\Carbon::parse($charter->trip_information['common']['coming']['start_date'])->format('A')) }}
                        </span>
                    </li>
                @endif
            </ul>
            <!-- End card-list -->
        </div>
        <!-- End card-block-center -->
        <!-- Start card-block-bottom -->
        <div class="card-block-bottom d-flex align-items-center justify-content-between">
            <span class="card-second-title">{{ __('alnkel.flightsOn')  }} {{ $charter->aircraft_operator[App::getLocale()] }}</span>
            <!-- Start card-section -->
            <div class="card-section d-flex align-items-center">
                <i class="icons8-plane"></i>
                <span>@lang("alnkel.flights")</span>
            </div>
            <!-- End card-section -->
        </div>
        <!-- End card-block-bottom -->
    </div>
    <!-- End card-block-content -->
    <img src="{{ Storage::url($charter->thumb) }}" alt="test"
         class="img-fluid">
</a>
<!-- End card-block -->
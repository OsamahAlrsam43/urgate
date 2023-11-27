@php

	$available_seats=0;
    $price_seats=0;
    foreach($charter->prices as $price){
        if($price->available_seats  > 0){
            $available_seats=$price->available_seats;
            $price_seats=$price->price_adult_1;
			break;
        }
    }
$p = $charter->commission / 100 ;
$commission = $charter->is_percent == 0 ? $price_seats-$charter->commission :  $price_seats-($price_seats * $p) ;
@endphp

@if($available_seats > 0)
<div class="container">
    <div class="row"  @if (Auth::check()) tooltip="سعر الشركة : ${{ $commission  }}" @endif>
        <div class="col-md-12">
            <div class="content" >
                <div class="container text-right " style="    padding: 0px 0;" >
                    <span class="mr-3" style="{{ Lang::locale() == 'ar' ? '' : ' position: relative;top: 7px;left:-854px;'}}">
                        {{$charter->flight_day}} {{$charter->flight_date->format("d-m-Y")}}
                    </span>
                    <div class="row" >
                        <div class="col plane"><i class="fas fa-plane-departure"></i></div>
                        <div class="col">
                            <span class="bold">{{  date("H:i", strtotime($charter->departure_time)) }}</span>
                            <span class="bold">{{$charter->from->code}}</span>
                        </div>
                        <div class="col">
                          
                          @if($charter->status_charter)
                          <span class="badge badge-primary">{{ $charter->status_charter }}</span>
                          @endif

                            <span class="border-span">{{$charter->flight_number}}</span>
                            <span > {{$charter->aircraft->name}}</span>
                        </div>
                        <div class="col">
                            <span class="bold">{{  date("H:i", strtotime($charter->arrival_time)) }}</span>
                            <span class="bold">{{$charter->to->code}}</span>
                        </div>
                        <div class="col">
                            <span class="top-span">@lang("charter.seats")</span>
                            
                            <span class="bold">{{$available_seats > 9 ? 9 : $available_seats}}</span>
                        </div>
                        <div class="col">
                            <span class="top-span">@lang("charter.price")</span>
                            <span class="bold">${{$price_seats}}</span>
                        </div>
                        <div class="col">
                            <form method="get" action="{{route("charter.create")}}">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="flight_type" value="OneWay">
                                <input type="hidden" name="flight_class" value="Economy">
                                <input type="hidden" name="adults" value="1">
                                <input type="hidden" name="children" value="0">
                                <input type="hidden" name="babies" value="0">
                                <input type="hidden" name="from" value="{{$charter->from->id}}">
                                <input type="hidden" name="to" value="{{$charter->to->id}}">
                                <input type="hidden" name="going" value="{{$charter->flight_date->format("d-m-Y")}}">
                                
                                <button type="submit" class="main-button" style="cursor:pointer;position: absolute;top: -1px; {{ Lang::locale() == 'ar' ? 'right' : 'left'}} : -26px;">
                                    @lang("alnkel.Reserve")
                                </button>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif



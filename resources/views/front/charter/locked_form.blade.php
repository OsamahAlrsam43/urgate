<form action="{{ route('charterCheckout') }}" id="charter-reserve-form" method="post">
    {{ csrf_field() }}
    <input type="hidden" value="yes" name="locked" />
    <input type="hidden" value="locked" name="search_type" />
    <input type="hidden" value="0" name="roundtrip_charter" />
    <input type="hidden" value="0" name="reserve_children" />
    <input type="hidden" value="Economy" name="flight_class" />
    <input type="hidden" value="{{$lockIds[0]}}" name="departure_lockId" />
    <input type="hidden" value="{{$lockIds[1]}}" name="return_lockId" />
    <input type="hidden" value="{{$round ? 'RoundTrip' : 'OneWay'}}" name="flight_type" />
    <input type="hidden" value="{{$charter}}" name="departure_charter" />
    <input type="hidden" value="{{ $priceId1 }}" name="departure_pricing" />
    <input type="hidden" value="{{ $priceId2 }}" name="return_pricing" />
    <input type="hidden" value="{{$round}}" name="return_charter" />
    <div class="row">
        <div class="col">
            <label class="d-block" for="adult">
                Adults
            </label>
            <select class="form-control select2 counter" name="reserve_adults">
                @for($i=1;$i<=$seats;$i++)
                    <option @if(request()->get("adults") == $i) selected @endif>{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col">
            <label class="d-block" for="adult">
                Babies
            </label>
            <select class="form-control select2 counter" name="reserve_babies">
                @for($i=0;$i<=10;$i++)
                    <option @if(request()->get("babies") == $i) selected @endif>{{$i}}</option>
                @endfor
            </select>
        </div>
    </div>
</form>
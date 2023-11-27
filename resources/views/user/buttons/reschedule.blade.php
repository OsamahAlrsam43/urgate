<div class="row m-0">
    <div class="col-md-2">
        <div class="form-group">
            <label class="d-block">@lang("From")</label>
            <input type="text" class="form-control"
                   value="{{$isOpen ? $order->charter->to->name['en'] : $order->charter->from->name['en']}}" disabled/>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label class="d-block">@lang("To")</label>
            <input type="text" class="form-control"
                   value="{{$isOpen ? $order->charter->from->name['en'] : $order->charter->to->name['en']}}" disabled/>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label class="d-block">@lang("Adults")</label>
            <input type="text" class="form-control" value="{{$order->passengers()->where("age", "adult")->count()}}"
                   disabled/>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label class="d-block">@lang("Children")</label>
            <input type="text" class="form-control" value="{{$order->passengers()->where("age", "child")->count()}}"
                   disabled/>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label class="d-block">@lang("Babies")</label>
            <input type="text" class="form-control" value="{{$order->passengers()->where("age", "baby")->count()}}"
                   disabled/>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label class="d-block">@lang("Class")</label>
            @if($isSearch or $isOpen)
                <input type="text" class="form-control flight_class" value="{{$flight_class}}" readonly/>
            @else
                <select name="flight_class" class="form-control m-select2 select2 no-search flight_class">
                    <option @if($order->flight_class === "Economy") selected @endif>Economy</option>
                    <option @if($order->flight_class === "Business") selected @endif>Business</option>
                </select>
            @endif
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label class="d-block">@lang("Date")</label>
            @if($isSearch)
                <input type="text" class="form-control flight_date" value="{{$flight_date}}" readonly/>
            @else
                <input type="date" class="form-control flight_date" value="{{$order->charter->flight_date}}"
                       min="{{$minDate}}" max="{{$maxDate}}"/>
            @endif
        </div>
    </div>
</div>

<hr/>

@if($isSearch)

    <table class="table table-bordered table-striped mb-3">
        <tr>
            <th scope="col" class="text-left">
                <a href="#" class="btn btn-brand previous-btn" data-date="{{$prevDay}}">
                    <i class="fa fa-arrow-left mr-3"></i>
                    Previous ({{$prevDay}})
                </a>
            </th>
            <th scope="col" class="text-center pt-4">{{$flight_date}}</th>
            <th scope="col" class="text-right">
                <a href="#" class="btn btn-brand next-btn" data-date="{{$nextDay}}">
                    Next {{$nextDay}}
                    <i class="fa fa-arrow-right ml-3"></i>
                </a>
            </th>
        </tr>
    </table>

    <table class="table table-bordered table-striped mb-0">
        <tr>
            <th scope="col" width="50"></th>
            <th scope="col">@lang("Flight Number")</th>
            <th scope="col">From</th>
            <th scope="col">To</th>
            <th scope="col">@lang("Aircraft")</th>
            @if(!$isOpen)
                <th scope="col">{{$flight_class}} Price</th>
            @endif
        </tr>

        @if(count($flights) == 0)
            <tr>
                <td colspan="6" class="text-center">@lang("No flights found")</td>
            </tr>
        @endif

        @foreach($flights as $flight)
            <tr>
                <td>
                    <label class="mt-radio mt-radio-outline">
                        <input type="radio" class="flight_id" value="{{$flight->id}}"
                               data-price="{{$flight->price}}"/><span></span>
                    </label>
                </td>
                <td>{{$flight->flight_number}}</td>
                <td>{{$flight->from->code}} - {{$flight->departure_time}}</td>
                <td>{{$flight->to->code}} - {{$flight->arrival_time}}</td>
                <td>{{$flight->aircraft->name}}</td>

                @if(!$isOpen)
                    <td>${{$flight->price}}</td>
                @endif
            </tr>
        @endforeach
    </table>

    <div class="summary" hidden>
        <h4 class="mt-3">@lang("Reschedule Summary")</h4>

        <table class="table table-bordered table-striped mb-0 mt-3">
            <tr>
                <th scope="col">@lang("Current Price")</th>
                <th scope="col">@lang("New Price")</th>
                <th scope="col">@lang("Reschedule Fees")</th>
            </tr>
            <tr>
                <td>${{$currentFlight->price}}</td>
                <td id="new-price"></td>
                <td>${{$currentFlight->charter->change_fees}}</td>
            </tr>
        </table>

        <h4 class="mt-3">Total Payment <span class="text-success total-payment"></span></h4>

        <label class="mt-checkbox mt-checkbox-outline mt-3 mb-0">
            <input type="checkbox" class="agree" value="yes"/><span></span>
            <b class="text-danger">Agree on new pricing?</b>
        </label>
    </div>

@endif

<script>
    $('.select2.no-search').select2({
        placeholder: "Select an option",
        minimumResultsForSearch: -1
    });

    @if(!$isOpen)
    $('.flight_id').on('change', function () {
        var price = $('.flight_id:checked').data('price');
        $('.summary').removeAttr("hidden");
        $('#new-price').text(`$${price}`);
        @if($currentFlight)
        $('.total-payment').text(`$${Math.max(0, (price - {{$currentFlight->price}})) + {{$currentFlight->charter->change_fees}} }`);
        @endif
    });
    @endif
</script>

<style>
    .select2-container {
        z-index: 99999999999;
    }
</style>
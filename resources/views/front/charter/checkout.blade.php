@extends('layouts.master-front')

@section('title')
    - Checkout
@endsection

@section('styles')
    <style>
        .card-header {
            cursor: pointer;
        }

        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            background-color: #fe0068;
        }

        .nav-fill .nav-item {
            background: #fff;
            margin-right: 5px;
            margin-left: 5px;
        }

        div#nav-tab {
            margin: 0 -5px;
        }
    </style>
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

        <a href="{{route('download-charter-ticket', ['order' => session()->get('pnr')])}}" class="btn btn-primary"
           style="margin: 0 20px;">@lang('charter.download')}}</a>
    @endif

    @if($locking)
        <div class="search-box p-3 bg-light">
            <h3 class="text-center text-info">@lang("Reserve Seats")</h3>
        </div>
    @endif

    <section class="pt-3">
        <div class="container">
            @if(Auth::check() and !session()->has('success'))
                <div class="row">
                    <div class="col-8">

                        <div class="row">
                            <div class="col">
                                <h5 class="bg-dark text-light p-2">{{$hasRoundTrip ? 'Departure ' : ''}}@lang("alnkel.Flight Details")
                                    #{{$charter->name}}</h5>

                                <table class="table table-bordered table-striped table-sm hidden-xs hidden-sm">
                                    <tr>
                                        <th scope="col">@lang("charter.from")</th>
                                        <td>{{$charter->from->code}} - {{ $charter->from->name[App::getLocale()]}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">@lang("charter.to")</th>
                                        <td>{{$charter->to->code}} - {{$charter->to->name[App::getLocale()]}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">@lang("charter.flight_date")</th>
                                        <td>{{$charter->flight_day}} {{$charter->flight_date}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">@lang("alnkel.Flight Time")</th>
                                        <td><i class="fas fa-plane-departure"></i> {{ date("H:i a", strtotime($charter->departure_time)) }} <i
                                                    class="fas fa-plane-arrival ml-3"></i> {{ date("H:i a", strtotime($charter->arrival_time )) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col">@lang("charter.airline")</th>
                                        <td>{{$charter->aircraft->name}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">@lang("alnkel.Flight Class")</th>
                                        <td>
                                            <span class="badge-pill badge-info d-inline-block small">{{$request->flight_class}}</span>

                                            @if(intval($request->departure_pricing) > 0)
                                                <span class="badge-pill badge-warning d-inline-block small">{{getPriceObject($request->departure_pricing)->price_class}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            @if($hasRoundTrip)
                                <div class="col">
                                    <h5 class="bg-dark text-light p-2">Return Flight Details #{{$roundTrip->id}}</h5>

                                    <table class="table table-bordered table-striped table-sm hidden-xs hidden-sm">
                                        <tr>
                                            <th scope="col">@lang("charter.from")</th>
                                            <td>{{$roundTrip->from->code}}
                                                - {{ $roundTrip->from->name[App::getLocale()]}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">@lang("charter.to")</th>
                                            <td>{{$roundTrip->to->code}}
                                                - {{$roundTrip->to->name[App::getLocale()]}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">@lang("charter.flight_date")</th>
                                            <td>{{$charter->flight_day}} {{$roundTrip->flight_date}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">@lang("Flight Time")</th>
                                            <td><i class="fas fa-plane-departure"></i> {{ date("H:i a", strtotime($roundTrip->departure_tim)) }} <i
                                                        class="fas fa-plane-arrival ml-3"></i> {{ date("H:i a", strtotime($roundTrip->arrival_time))}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">@lang("charter.airline")</th>
                                            <td>{{$roundTrip->aircraft->name}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">@lang("Flight Class")</th>
                                            <td>
                                                <span class="badge-pill badge-info d-inline-block small">{{$request->flight_class}}</span>

                                                @if(intval($request->return_pricing) > 0)
                                                    <span class="badge-pill badge-warning d-inline-block small">{{getPriceObject($request->return_pricing)->price_class}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif

                            @if($isOpen)
                                <div class="col">
                                    <h5 class="bg-dark text-light p-2">@lang("Return Flight Details")</h5>

                                    <table class="table table-bordered table-striped table-sm hidden-xs hidden-sm">
                                        <tr>
                                            <th scope="col">@lang("charter.from")</th>
                                            <td>{{$charter->to->code}} - {{ $charter->to->name[App::getLocale()]}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">@lang("charter.to")</th>
                                            <td>{{$charter->from->code}}
                                                - {{$charter->from->name[App::getLocale()]}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">@lang("charter.flight_date")</th>
                                            <td class="text-danger">{{$duration}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">@lang("Flight Time")</th>
                                            <td>----</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">@lang("charter.airline")</th>
                                            <td>-----</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">@lang("Flight Class")</th>
                                            <td>
                                                <span class="badge-pill badge-info d-inline-block small">{{$request->flight_class}}</span>

                                                @if(intval($request->departure_pricing) > 0)
                                                    <span class="badge-pill badge-warning d-inline-block small">{{getPriceObject($request->departure_pricing)->price_class}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        </div>


                        {{-- @if(!$locking) --}}
                            <h5 class="bg-dark text-light p-2">@lang("alnkel.Travelers")</h5>

                            <h6 class="bg-dark text-light text-center p-2">@lang("alnkel.Upload Travelers Data")</h6>

                            <div class="bg-white p-2 mb-2 border">
                                <form enctype="multipart/form-data">
                                    <input id="upload" type=file name="files[]">
                                </form>

                                <hr/>

                                <a href="{{asset("public/assets/samples/sample_data.xlsx")}}">@lang("alnkel.Download data sample file")</a>
                            </div>

                            <form id="travelers-form">
                                @foreach($travelers as $title => $traveler)
                                    <h5 class="bg-secondary p-2 border text-white text-center {{ $title }}">@lang("alnkel.$title")</h5>

                                    @for($index=0; $index < $traveler; $index++)
                                        <div class="accordion mb-2" id="accordion-{{$title.$index}}">
                                            <div class="card">
                                                <div class="card-header" hidden>
                                                    <h6 class="mb-0 full-name" data-toggle="collapse"
                                                        data-target="#collapse-{{$title.$index}}"></h6>
                                                </div>

                                                <div id="collapse-{{$title.$index}}" class="collapse show"
                                                     data-parent="#accordion-{{$title.$index}}">
                                                    <div class="card-body">
                                                        <input type="hidden" name="age[]" value="{{$title}}">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label class="d-block">@lang("alnkel.Title") @required()</label>
                                                                    <select name="title[]"
                                                                            class="form-control {{$title}} select2-nosearch">
                                                                        @if( $title == "Adults" || $title == "Children" )
                                                                        <option>@lang("MR")</option>
                                                                        <option>@lang("MRS")</option>
                                                                      @else                                                                      
                                                                        <option>@lang("INF")</option>
                                                                      @endif
                                                                      
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label class="d-block">@lang("alnkel.First Name") @required()</label>
                                                                    <input type="text" class="form-control {{$title}}"
                                                                           name="first_name[]"
                                                                           placeholder="@lang("alnkel.First Name")"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label class="d-block">@lang("alnkel.Last Name") @required()</label>
                                                                    <input type="text" class="form-control {{$title}}"
                                                                           name="last_name[]"
                                                                           placeholder="@lang("alnkel.Last Name")"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label class="d-block">@lang("alnkel.Birth Date") @required()</label>
                                                                    <input type="text"
                                                                           class="form-control {{$title}} datepicker date-mask"
                                                                           name="birth_date[]"
                                                                           placeholder="__/__/____"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label class="d-block">@lang("alnkel.Nationality") @required()</label>
                                                                    <select class="form-control {{$title}} select2"
                                                                            name="nationality[]">
                                                                        <option></option>
                                                                        @foreach($nationalities as $country)
                                                                            <option value="{{ $country->id }}"
                                                                                    {{ ($country->id == 104 or old('nationality.'.$index) == $country->id) ? 'selected' : ''}}>
                                                                                {{ $country->name["en"] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label class="d-block">@lang("alnkel.Passport Number") @required()</label>
                                                                    <input type="text" class="form-control {{$title}}"
                                                                           name="passport_number[]"
                                                                           placeholder="@lang('alnkel.Passport Number')"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label class="d-block">@lang("alnkel.Passport Expiration Date") @required()</label>
                                                                    <input type="text"
                                                                           class="form-control {{$title}} datepicker date-mask"
                                                                           placeholder="__/__/____"
                                                                           name="passport_expire_date[]"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                @endforeach
                            </form>
                       {{-- @endif --}}
                  
                    </div>
                    <div class="col-4">

                        <div class="summary sticky-top">

                            @if(!$isLocked)
                                <h5 class="bg-dark text-light p-2">@lang("alnkel.Order Summary")</h5>

                                <div class="bg-white p-2 border">
                                    <table class="table table-bordered table-sm m-0">
                                        @if($hasRoundTrip or $isOpen)
                                            <tr class="bg-warning">
                                                <td colspan="3">
                                                    <strong class="text-dark">Departure Flight To</strong>
                                                    <strong class="text-dark float-right">{{$charter->to->code}}</strong>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>@lang("alnkel.Adults")</td>
                                            <td class="text-center">
                                        <span>
                                            ${{$passengerPrices['adults']}}
                                        </span>
                                                x
                                                <span class="adult_count">{{$travelers['Adults']}}</span>
                                            </td>
                                            <td class="text-right total-adult">
                                                ${{$hasRoundTrip || $isOpen ? $departurePrices['adults'] : $prices['adults']}}</td>
                                        </tr>
                                        @if(!$locking)
                                            <tr>
                                                <td>@lang("alnkel.Children")</td>
                                                <td class="text-center">
                                                    <span>${{$passengerPrices['children']}}</span>
                                                    x
                                                    <span class="child_count">{{$travelers['Children']}}</span>
                                                </td>
                                                <td class="text-right total-children">
                                                    ${{$hasRoundTrip || $isOpen ? $departurePrices['children'] : $prices['children']}}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang("alnkel.Babies")</td>
                                                <td class="text-center">
                                                    <span>${{$passengerPrices['babies']}}</span>
                                                    x
                                                    <span class="babies_count">{{$travelers['Babies']}}</span>
                                                </td>
                                                <td class="text-right total-babies">
                                                    ${{$hasRoundTrip || $isOpen ? $departurePrices['babies'] : $prices['babies']}}</td>
                                            </tr>
                                        @endif
                                        @if($hasRoundTrip)
                                            <tr class="bg-warning">
                                                <td colspan="3">
                                                    <strong class="text-dark">Return Flight To</strong>
                                                    <strong class="text-dark float-right">{{$charter->from->code}}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>@lang("alnkel.Adults")</td>
                                                <td class="text-center">
                                                    <span>${{$isEconomy ? $roundTrip->price_adult : $roundTrip->business_adult}}</span>
                                                    x
                                                    <span class="adult_count">{{$travelers['Adults']}}</span>
                                                </td>
                                                <td class="text-right total-adult">
                                                    ${{$roundPrices['adults']}}</td>
                                            </tr>
                                            @if(!$locking)
                                                <tr>
                                                    <td>@lang("alnkel.Children")</td>
                                                    <td class="text-center">
                                                        <span>${{$isEconomy ? $roundTrip->price_child : $roundTrip->business_child}}</span>
                                                        x
                                                        <span class="child_count">{{$travelers['Children']}}</span>
                                                    </td>
                                                    <td class="text-right total-children">
                                                        ${{$roundPrices['children']}}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang("alnkel.Babies")</td>
                                                    <td class="text-center">
                                                        <span>${{$isEconomy ? $roundTrip->price_baby : $roundTrip->business_baby}}</span>
                                                        x
                                                        <span class="babies_count">{{$travelers['Babies']}}</span>
                                                    </td>
                                                    <td class="text-right total-babies">
                                                        ${{$roundPrices['babies']}}</td>
                                                </tr>
                                            @endif
                                        @endif

                                        @if($isOpen)
                                            <tr class="bg-warning">
                                                <td colspan="3">
                                                    <strong class="text-dark">Return Flight To</strong>
                                                    <strong class="text-dark float-right">{{$charter->from->code}}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Adults</td>
                                                <td class="text-center">
                                        <span>
                                            ${{$openPassengerPrices['adults']}}
                                        </span>
                                                    x
                                                    <span class="adult_count">{{$travelers['Adults']}}</span>
                                                </td>
                                                <td class="text-right total-adult">
                                                    ${{$openPrices['adults']}}</td>
                                            </tr>
                                            <tr>
                                                <td>Children</td>
                                                <td class="text-center">
                                        <span>
                                            ${{$openPassengerPrices['children']}}
                                        </span>
                                                    x
                                                    <span class="child_count">{{$travelers['Children']}}</span>
                                                </td>
                                                <td class="text-right total-children">
                                                    ${{$openPrices['children']}}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang("alnkel.Babies")</td>
                                                <td class="text-center">
                                        <span>
                                            ${{$openPassengerPrices['babies']}}
                                        </span>
                                                    x
                                                    <span class="babies_count">{{$travelers['Babies']}}</span>
                                                </td>
                                                <td class="text-right total-babies">
                                                    ${{$openPrices['babies']}}</td>
                                            </tr>
                                        @endif
                                        <tr class="bg-light">
                                            <td colspan="3">
                                                <strong class="text-info">@lang("alnkel.Total")</strong>
                                                <strong class="text-info float-right total-price">${{$total}}</strong>
                                            </td>
                                        </tr>
                                        <tr class="bg-light">
                                            <td colspan="3">
                                                <strong class="text-success">@lang("alnkel.Commission")</strong>
                                                <strong class="text-success float-right commission">${{$commission}}</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif

                           {{--  @if(!$locking) --}}
                                <h5 class="bg-dark text-light p-2 {{$isLocked ? null : "mt-2"}}">@lang("alnkel.Agent Details")</h5>

                                <form id="agent-form">
                                    <div class="bg-white p-2 border mt-2">
                                        <div class="form-group">
                                            <label class="d-block">@lang("alnkel.Contact Phone")</label>
                                            <input type="text" class="form-control" name="phone"
                                                   placeholder="@lang("alnkel.Contact Phone")"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">@lang("alnkel.Contact Email")</label>
                                            <input type="text" class="form-control" name="email"
                                                   placeholder="@lang("alnkel.Contact Email")"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">@lang("alnkel.Note")</label>
                                            <textarea type="text" class="form-control" name="note"
                                                      placeholder="@lang("alnkel.Note")"></textarea>
                                        </div>
                                    </div>
                                </form>
                           {{-- @endif --}}

                            <h5 class="bg-dark text-light p-2 mt-2">@lang("alnkel.Payment Options")</h5>

                            {{-- @if(!$isLocked) --}}
                                <nav>
                                    <div class="nav nav-pills nav-fill mt-2" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="pay-now-tab" data-toggle="tab"
                                           href="#nav-pay-now-tab" role="tab">@lang("alnkel.Pay Now")</a>
                                        @if($charter->pay_later_max > 0 and !$locking)
                                            <a class="nav-item nav-link" id="pay-later-tab" data-toggle="tab"
                                               href="#nav-pay-later-tab" role="tab">@lang("alnkel.Pay Later")</a>
                                        @endif
                                    </div>
                                </nav>
                            {{-- @endif --}}

                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-pay-now-tab" role="tabpanel"
                                     aria-labelledby="pay-now-tab">

                                    {{-- @if(!$isLocked) --}}
                                        <div class="bg-white p-2 border mt-2">
                                            <strong class="text-dark">@lang("alnkel.Balance")</strong>
                                            <strong class="text-info float-right total-price">${{$balance}}</strong>
                                        </div>
                                    {{-- @endif --}}

                                    @if($canPlaceOrder {{-- or $isLocked --}})
                                        <button class="btn btn-info btn-block mt-2 checkout">@lang("alnkel.Complete Order")</button>
                                    @else
                                        <div class="bg-warning p-2 mt-2">
                                            You don't have sufficient balance
                                        </div>
                                    @endif
                                </div>

                                {{-- @if($charter->pay_later_max > 0 and !$locking) --}}
                                @if($charter->pay_later_max > 0)
                                    <div class="tab-pane fade" id="nav-pay-later-tab" role="tabpanel"
                                         aria-labelledby="nav-profile-tab">
                                        <div class="bg-white p-2 border mt-2">
                                            <strong class="text-dark">@lang("Complete order and pay later")</strong>
                                            <button class="btn btn-info btn-block mt-2 checkout paylater">Pay Later Order</button>

                                            <div class="text-danger p-2 text-center"><small>you have a maximum
                                                    of {{$charter->pay_later_max}} hours to complete payment</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <button class="btn btn-default btn-block mt-2" onclick="window.history.back()">@lang("alnkel.Go Back")</button>
                            </div>

                            <!-- <div class="instructions mt-3">
                                {!! nl2br($charter->instructions) !!}
                            </div> -->
                          
                          <div class="instructions mt-3">
                                {!! nl2br($charter->info) !!}
                          </div>
                          <input type="checkbox" id="checkInfo" name="checkInfo" value="true" required>
							<label for="checkInfo">
                              @lang("alnkel.conditions")
                             
                          </label><br>
                        </div>

                    </div>
                </div>

            @else
                @if(!Auth::check())
                    <div class="alert m-alert m-alert--default alert-danger" role="alert">
                        @lang("alnkel.single-travel-please"), <a href="{{ route('front-login') }}">@lang("alnkel.single-travel-login") }}</a> @lang("alnkel.single-travel-for-reservation")
                    </div>
                @endif
            @endif
        </div>

        <input type="hidden" name="order_id" value="0"/>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('front-assets/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('front-assets/js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/jquery.serialize-object.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>

    <script type="template" id="table-template">
        <table class="table table-sm table-bordered">
            <tr>
                <th>#</th>
                <th>Passenger Type</th>
                <th>Title</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Nationality</th>
                <th>Birth Date</th>
                <th>Passport Number</th>
                <th>Passport Expiration</th>
            </tr>
            {rows}
        </table>
    </script>

    <script>
        var ExcelToJSON = function () {
            this.parseExcel = function (file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var data = e.target.result;
                    var workbook = XLSX.read(data, {
                        type: 'binary'
                    });
                    workbook.SheetNames.forEach(function (sheetName) {
                        // Here is your object
                        var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                        var json_string = JSON.stringify(XL_row_object);
                        var json_object = JSON.parse(json_string);
                        // console.log(json_object);

                        if (json_object && json_object.length > 0) {
                            var template = $('#table-template').html();
                            var rows = '';

                            let errors = false;

                            json_object.map(function (item, i) {
                                if ((item['DOB (dd/mm/yyyy)'] && !isValidDate(item['DOB (dd/mm/yyyy)'])) || (item['Passport Expiry (dd/mm/yyyy)'] && !isValidDate(item['Passport Expiry (dd/mm/yyyy)']))) {
                                    errors = true;
                                }

                                if (!item['Title'] || !item['Pax Type'] || !item['First Name'] || !item['Last Name'] || !item['Nationality'] || !item['DOB (dd/mm/yyyy)'] || !item['Passport Number'] || !item['Passport Expiry (dd/mm/yyyy)']) {
                                    errors = true;
                                }

                                rows += `<tr>`;
                                rows += `<td>${i + 1}</td>`;
                                rows += `<td>${item['Pax Type'] ? item['Pax Type'] : '<span class="text-danger">(Required)</span>'}</td>`;
                                rows += `<td>${item['Title'] ? item['Title'] : '<span class="text-danger">(Required)</span>'}</td>`;
                                rows += `<td>${item['First Name'] ? item['First Name'] : '<span class="text-danger">(Required)</span>'}</td>`;
                                rows += `<td>${item['Last Name'] ? item['Last Name'] : '<span class="text-danger">(Required)</span>'}</td>`;
                                rows += `<td>${item['Nationality'] ? item['Nationality'] : '<span class="text-danger">(Required)</span>'}</td>`;
                                rows += `<td>${item['DOB (dd/mm/yyyy)'] ? valid(item['DOB (dd/mm/yyyy)']) : '<span class="text-danger">(Required)</span>'}</td>`;
                                rows += `<td>${item['Passport Number'] ? item['Passport Number'] : '<span class="text-danger">(Required)</span>'}</td>`;
                                rows += `<td>${item['Passport Expiry (dd/mm/yyyy)'] ? valid(item['Passport Expiry (dd/mm/yyyy)']) : '<span class="text-danger">(Required)</span>'}</td>`;
                                rows += '<tr>';
                            });

                            let content = template.replace('{rows}', rows);

                            if (errors) {
                                content += "<div class='text-danger mt-3'>You have errors on your data, please correct them first</div>";
                            }

                            $.confirm({
                                columnClass: 'col-md-12',
                                title: 'Imported Data',
                                content: content,
                                buttons: {
                                    confirm: {
                                        text: 'Confirm and fill',
                                        action: function () {
                                            fillData(json_object);
                                        },
                                        isDisabled: errors
                                    },
                                    cancel: {}
                                }
                            });
                        }


                        $('#upload').val(null);
                    })
                };

                reader.onerror = function (ex) {
                    console.log(ex);
                };

                reader.readAsBinaryString(file);
            };
        };

        function isValidDate(dateObject) {
            return moment(dateObject, 'DD/MM/YYYY', true).isValid();
        }

        function valid(dateObject) {
            return isValidDate(dateObject) ? dateObject : `<span class="text-danger">${dateObject}</span>`;
        }

        function fillData(passengers) {
            let ages = ["Adults", "Children", "Babies"];
            ["ADT", "CHD", "INF"].map(function (slug, index) {
                let age = ages[index];

                passengers.filter(function (item) {
                    return item['Pax Type'] == slug
                }).map(function (passenger, i) {

                    if (passenger['First Name']) {
                        $('[name="first_name[]"].' + age).eq(i).val(passenger['First Name']);
                    }

                    if (passenger['Last Name']) {
                        $('[name="last_name[]"].' + age).eq(i).val(passenger['Last Name']);
                    }

                    if (passenger['DOB (dd/mm/yyyy)']) {
                        $('[name="birth_date[]"].' + age).eq(i).val(passenger['DOB (dd/mm/yyyy)']);
                    }

                    // if (passenger['Nationality']) {
                    //     $('[name="nationality[]"].' + age).eq(i).val(passenger['Nationality']);
                    // }

                    if (passenger['Passport Number']) {
                        $('[name="passport_number[]"].' + age).eq(i).val(passenger['Passport Number']);
                    }

                    if (passenger['Passport Expiry (dd/mm/yyyy)']) {
                        $('[name="passport_expire_date[]"].' + age).eq(i).val(passenger['Passport Expiry (dd/mm/yyyy)']);
                    }

                    if (passenger['Title']) {
                        $('[name="title[]"].' + age).eq(i).val(passenger['Title']).trigger('change');
                    }

                });
            });

        }

        function handleFileSelect(evt) {
            var files = evt.target.files; // FileList object
            var xl2json = new ExcelToJSON();
            xl2json.parseExcel(files[0]);
        }

        $('#upload').on('change', function (e) {
            handleFileSelect(e);
        });
    </script>

    <script>
        // Prefill
        /**/

        $('body').on('click', '.checkout', function (e) {
            e.preventDefault();
            var $this = $(this),
                payMethod = $this.hasClass("paylater") ? "PayLater" : "PayNow";

            // Validate
            var fields = $('#travelers-form').serializeArray(),
                errors = false;

            $(fields).each(function (i, field) {
                if (!field.value) {
                    errors = true;
                }
            });
			if( $('input[name=checkInfo]:checked').length == 0){
              errors=true;
            }
            if (errors) {
                $.alert({
                    title: 'Alert',
                    content: 'Please fill all required fields first!'
                });

                return;
            }

            $.confirm({
                title: 'Confirm',
                @if($isLocked)
                content: 'Your order will be processed and seats will be deducted from your reserved seats',
                @else
                content: payMethod === "PayNow" ? 'Your balance will be credited and the order will be placed, are you sure?' : 'Your order will be placed and you have a maximum of {{$charter->pay_later_max}} hours to complete payment, continue?',
                @endif
                buttons: {
                    sure: {
                        btnClass: 'btn-success',
                        text: 'Yes, Sure',
                        action: function () {
                            $.confirm({
                                title: 'Order Completed Successfully',
                                columnClass: 'col-md-6',
                                buttons: {
                                    {{-- @if($locking) --}}
                                    /*ok: {
                                        btnClass: 'btn-info',
                                        text: 'Redirect to reserved seats',
                                        action: function () {
                                            window.location = '{{route("reservedSeats")}}';
                                        }
                                    },*/
                                    {{-- @else --}}
                                    ok: {
                                        btnClass: 'btn-info',
                                        text: 'Redirect to orders panel',
                                        action: function () {
                                            var order = $('[name=order_id]').val();
                                            window.location.replace('{{url("/profile/charter")}}/' + order)
                                        }
                                    },
                                    {{-- @endif --}}
                                    cancel: {
                                        btnClass: 'btn-secondary',
                                        text: 'Redirect to home page',
                                        action: function () {
                                            window.location = '{{url("/")}}';
                                        }
                                    },
                                },
                                content: function () {
                                    var self = this;
                                    return $.ajax({
                                        url: '{{route('completeCharterOrder')}}',
                                        method: 'post',
                                        data: {
                                            charter: {{$charter->id}},
                                            charterRoundTrip: @if($hasRoundTrip) {{$roundTrip->id}} @else "" @endif,
                                            departure_lockId: @if($request->has('departure_lockId')) {{$request->departure_lockId}} @else "" @endif,
                                            return_lockId: @if($request->has('return_lockId')) {{$request->return_lockId}} @else "" @endif,
                                            flight_class: '{{$request->flight_class}}',
                                            fields: $('#travelers-form').serializeObject(),
                                            agent: $('#agent-form').serializeObject(),
                                            travelers: {
                                                adults: {{$travelers['Adults']}},
                                                children: {{$locking ? 0 : $travelers['Children']}},
                                                babies: {{$locking ? 0 : $travelers['Babies']}},
                                            },
                                            total: {{$total}},
                                            commission: {{$commission}},
                                            payMethod,
                                            paylaterMax: {{$charter->pay_later_max}},
                                            search_type: '{{request()->get("search_type")}}',
                                            price_class:'{{getPriceObject($request->departure_pricing)->price_class}}'
                                        }
                                    }).done(function (response,e) {
                                        $('[name=order_id]').val(response.order);
                                        console.log(e.responseText);
                                        console.log(response);
                                        self.setContent(response.html);
                                    }).fail(function (e) {
                                        console.log(e.responseText);
                                        self.setContent('Something went wrong.');
                                    });
                                },
                                onContentReady: function () {
                                    // bind to events
                                }
                            })
                        }
                    },
                    cancel: {}
                }
            });
        });
    </script>

    <script>

        $('[name="first_name[]"], [name="last_name[]"], [name="title[]"]').on('change', function () {
            var value = $(this).val(),
                cardHeader = $(this).closest('.card').find(".card-header"),
                card = $(this).closest('.card');

            var fullName = card.find('[name="title[]"]').val() + '/ ' + card.find('[name="first_name[]"]').val() + ' ' + card.find('[name="last_name[]"]').val();

            if (value) {
                cardHeader.find(".full-name").text(fullName);
                cardHeader.removeAttr("hidden");
            } else {
                cardHeader.attr("hidden", true);
            }
        });

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

        $('.date-mask').on('focus', function () {
            $(this).mask('00/00/0000', {placeholder: "__/__/____"});
        }).on('change', function () {
            var val = $(this).val();
            var datParts = val.split("/");

            var dateCheck = moment(val ,'dd mm yy');
            
            var rgexp = /(^(((0[1-9]|1[0-9]|2[0-8])[/](0[1-9]|1[012]))|((29|30|31)[/](0[13578]|1[02]))|((29|30)[/](0[4,6,9]|11)))[/](19|[2-9][0-9])\d\d$)|(^29[/]02[-](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)/;
            var isValidDate = rgexp.test(val);
            if (!isValidDate) {
                console.log(val);
                alert("Date is invalid, please enter a valid date");
                $(this).val("")
            }
        });

        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });

        $('.birthday-adult').datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });

        @if(isset($timestamp))
		<?php
		$childrenMinDate = date( "m", $timestamp ) . "/" . ( intval( date( "d", $timestamp ) ) + 1 ) . "/" . ( intval( date( "Y", $timestamp ) ) - 12 );
		$babyMinDate = date( "m", $timestamp ) . "/" . ( intval( date( "d", $timestamp ) ) + 1 ) . "/" . ( intval( date( "Y", $timestamp ) ) - 2 );
		?>

        $('.birthday-children').datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            minDate: new Date('{{$childrenMinDate}}'),
            maxDate: "+1D"
        }).on('blur', function () {
            var date = $(this).val();
            if (moment(date, "DD/MM/YYYY").isBefore('{{$childrenMinDate}}')) {
                alert("Child age can't be more than 12 years.");
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
        @endif
    </script>
@endsection
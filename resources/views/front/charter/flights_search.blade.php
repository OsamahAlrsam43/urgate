@extends('layouts.master-front')

@section('title')
    Search results
@endsection

@section('styles')
    <style>
        .lds-ellipsis {
            display: inline-block;
            position: relative;
            width: 64px;
            height: 64px;
            top: 40%;
        }

        .lds-ellipsis div {
            position: absolute;
            top: 27px;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: #fff;
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }

        .lds-ellipsis div:nth-child(1) {
            left: 6px;
            animation: lds-ellipsis1 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(2) {
            left: 6px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(3) {
            left: 26px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(4) {
            left: 45px;
            animation: lds-ellipsis3 0.6s infinite;
        }

        @keyframes lds-ellipsis1 {
            0% {
                transform: scale(0);
            }
            100% {
                transform: scale(1);
            }
        }

        @keyframes lds-ellipsis3 {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(0);
            }
        }

        @keyframes lds-ellipsis2 {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(19px, 0);
            }
        }
      
      
      .tooltip1 {
  border-bottom: 1px dotted black;
}

.tooltip1 .tooltiptext {
  visibility: hidden;
  width: 130px;
  background-color: #4a4a4a;
  color: white;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  
  /* Position the tooltip */
  position: absolute;
  left: 50%;
      top: 0;
  margin-left: -60px;
}

.tooltip1:hover .tooltiptext {
  visibility: visible;
}

    </style>
    
@endsection

@section('content')
    <div class="search-box p-3" style="background: white;padding: 21px !important;">

        <div class="container">
            <div class="row">
                <div class="col">
                    <input class="form-control date" name="going" type="text" value="{{request("flight_type")}}"
                           disabled>
                </div>
                <div class="col">
                    <select class="form-control select2" name="from" disabled>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}"
                                    {{ request()->get('from') == $country->id ? 'selected' : ''}}
                            >{{ $country->name['ar'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select class="form-control select2" name="to" disabled>
                        @foreach($countries_order as $country)
                            <option value="{{ $country->id }}"
                                  
                                {{  request()->get('to') == $country->id ? 'selected' : ''}}
                              
                              
                            >{{ $country->name['ar'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <input class="form-control date" name="going" type="text" value="{{request()->get("going")}}"
                           disabled>
                </div>
              
                @if(request("flight_type") == "RoundTrip")
                    <div class="col" id="coming-two-way">
                        <input class="form-control date" name="coming" type="text" value="{{request()->get("coming")}}"
                               disabled>
                    </div>
                @endif
                @if(request("flight_type") == "OpenReturn")
                    <div class="col" id="coming-duration">
                        <select class="form-control select2" name="coming_duration" disabled>
                            <option value="1" {{request("coming_duration") == "1" ? "selected" : ""}}>One month</option>
                            <option value="3" {{request("coming_duration") == "3" ? "selected" : ""}}>Three months
                            </option>
                            <option value="6" {{request("coming_duration") == "6" ? "selected" : ""}}>Six month</option>
                            <option value="12" {{request("coming_duration") == "12" ? "selected" : ""}}>One Year
                            </option>
                        </select>
                    </div>
                @endif
                <div class="col">
                    <a href="{{route("charter.create")}}" class="btn btn-primary btn-block">
                        Edit Search
                    </a>
                </div>
            </div>
            <div class="extra">{{request("adults")}} @lang("alnkel.Adults"), {{request("children")}} @lang("alnkel.Children"), {{request("babies")}}
                @lang("alnkel.Babies"), {{request("flight_class")}}</div>
        </div>
    </div>

    <div id="charter-search">

        <div class="results container">

            <div class="loading" v-if="loading">
                <div class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>

            <header class="container mb-3">
                <h1 class="departure section-header-main" style="font-size: 25px;margin-top: 33px;">
                    <div class="title-departure">
                    <span class="title-city-text">@lang("alnkel.departure from") <span
                                class="text-info">{{$fromCountry->name['ar']}}</span></span>
                        <span class="secondary bg-warning pl-2 pr-2">@{{going}}</span>
                    </div>
                </h1>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-outline-dark float-right" @click="next(false)">@lang("alnkel.Next Day")</button>
                        <button class="btn btn-sm btn-outline-dark float-left" @click="prev(false)">@lang("alnkel.Previous Day")
                        </button>
                    </div>
                </div>
            </header>

            <div class="container" v-cloak>
                <div>
                    <table class="table table-sm table-bordered table-striped mb-0">
                        <thead>
                        <tr class="bg-dark text-light">
                            <th width="50"></th>
                            <th width="120">@lang("alnkel.Flight Class")</th>
                            <th width="200">@lang("alnkel.Flight Date")</th>
                            <th width="120">@lang("alnkel.Flight Number")</th>
                            <th width="120">@lang("alnkel.Air Line")</th>
                            <th>@lang("alnkel.Price Class")</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="departureFlights.length === 0" >
                            <td colspan="7">No flights found</td>
                        </tr>
                          
                        <tr v-for="charter in departureFlights" :tooltip="charter.flight_class" class="tooltip1">
                          
                        
                           
                            <td   >
                             
                               <!-- <input type="radio" v-model="departureCharter" :value="charter.id"
                                       @click="selectFlight(charter.id, false)"
                                       /> -->

                                
                            </td>
                            {{-- <td>@{{charter}}</td> --}}
                           
                            <!-- <td>تحت التطوير</td> -->
                            <td>{{request("flight_class")}}</td>
                            <td>@{{charter.flight_date | moment}} - @{{charter.departure_time}}</td>
                            <td>
                              @{{charter.flight_number}} 
                              
                                  
                          </td>
                        
                            <td>@{{charter.aircraft.name}}</td>
                            <td>
                                <div class="row">
                                    <div class="col-md-12">
                                        @if(request("flight_type") == "OneWay" || request("flight_type") == "RoundTrip")
                                            <div class="price-class-item bg-secondary text-light p-2 text-center float-left mr-3 mb-1"
                                                v-for="price in charter.prices" 
                                                v-if="(price.available_seats >= requiredSeats) &&( '{{request("flight_class")}}' == price.flight_class)">
                                              
                                              <input type="radio" v-model="departurePricing" :value="price.id" @click="selectFlight(charter.id, false)"
                                                    />

												<i class="fa fa-times text-warning" v-if="price.available_seats < requiredSeats"></i>
                                                <h6 class="text-warning mt-1">
                                                @{{ price.price_class }} (@{{price.available_seats > 9 ? 9 : price.available_seats}})
                                                  
                                                  
                                                </h6>
                                                @if(request("flight_type")== "RoundTrip")
                                                <span>@{{ price.price_adult_2 }} USD</span>
                                                @else
                                                <span>@{{ price.price_adult_1}} USD</span>
                                                @endif

                                                <button class="btn btn-sm" style="background: transparent"
                                                        data-toggle="popover" title="@lang("Pricing")"
                                                        :data-content="pricing(charter, price)">
                                                    <i class="fa fa-ellipsis-h text-white"></i>
                                                </button>
                                            </div>
                                        @elseif(request("flight_type") == "OpenReturn")


                                            <div class="price-class-item bg-secondary text-light p-2 text-center float-left mr-3 mb-1"
                                                 v-for="price in charter.prices">


                                                <input type="radio" v-model="departurePricing" :value="price.id" @click="selectFlight(charter.id, false)"
{{--                                                       :disabled="departureCharter!==charter.id"--}}
                                                       v-if="(price.available_seats >= requiredSeats) &&( '{{request("flight_class")}}' == price.flight_class)
                                                        && (
                                                          ((price.price_adult_3_1 > 0) && ({{request("coming_duration")}} == 1)) 
                                                        ||((price.price_adult_3_3 > 0) && ({{request("coming_duration")}} == 3)) 
                                                        ||((price.price_adult_3_6 > 0) && ({{request("coming_duration")}} == 6)) 
                                                        ||((price.price_adult_3_12 > 0) && ({{request("coming_duration")}} == 12)) 
                                                        )"
                                                       />
                                                       <i class="fa fa-times text-warning"
                                                        v-if="!((price.available_seats >= requiredSeats) &&( '{{request("flight_class")}}' == price.flight_class)
                                                        && (
                                                          ((price.price_adult_3_1 > 0) && ({{request("coming_duration")}} == 1)) 
                                                        ||((price.price_adult_3_3 > 0) && ({{request("coming_duration")}} == 3)) 
                                                        ||((price.price_adult_3_6 > 0) && ({{request("coming_duration")}} == 6)) 
                                                        ||((price.price_adult_3_12 > 0) && ({{request("coming_duration")}} == 12)) 
                                                        ))"></i>

                                              
                                                <h6 class="text-warning mt-1">


                                                     @{{ price.price_class }} (@{{price.available_seats > 9 ? 9 : price.available_seats}}) </span>
                                                </h6>
                                                @if(request("flight_type")== "RoundTrip")
                                                <span>@{{ price.price_adult_2 }} USD</span>
                                                @else
                                                <span>@{{ price.price_adult_1}} USD</span>
                                                @endif
    
                                                <button class="btn btn-sm" style="background: transparent"
                                                        data-toggle="popover" title="@lang("Pricing")"
                                                        :data-content="pricing(charter, price)">
                                                    <i class="fa fa-ellipsis-h text-white"></i>
                                                </button>
                                                
                                            </div>
                                        @endif
                                        
                                        
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if(request("flight_type") == "RoundTrip")
                <header class="container mb-3">
                    <h1 class="departure section-header-main">
                        <div class="title-departure">
                        <span class="title-city-text">Select your return from <span
                                    class="text-info">{{$toCountry->name['ar']}}</span></span>
                            <span class="secondary bg-warning pl-2 pr-2">@{{coming}}</span>
                        </div>
                    </h1>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button class="btn btn-sm btn-outline-dark float-right" @click="next(true)">Next Day
                            </button>
                            <button class="btn btn-sm btn-outline-dark float-left" @click="prev(true)">Previous Day
                            </button>
                        </div>
                    </div>
                </header>

                <div class="container" v-cloak>
                    <div>
                        <table class="table table-sm table-bordered table-striped mb-0">
                            <thead>
                            <tr class="bg-dark text-light">
                                <th width="50"></th>
                                <th width="120">@lang("alnkel.Flight Class")</th>
                                <th width="200">Flight Date - Time</th>
                                <th width="120">Flight Number</th>
                                <th width="120">Air Line</th>
                                <th>@lang("alnkel.Price Class")</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="returnFlights.length === 0">
                                <td colspan="6">No flights found</td>
                            </tr>
                            <tr v-for="(charter , key) in returnFlights" :tooltip="charter.flight_class" :key="key" >
                                <td>
                                    <input type="radio" v-model="returnCharter" :value="charter.id"
                                           @click="selectFlight(charter.id, true)"/>
                                </td>
                                <td>{{request("flight_class")}}</td>
                                <td>@{{charter.flight_date | moment}} - @{{charter.departure_time}}</td>
                                <td>@{{charter.flight_number}}</td>
                                <td>@{{charter.aircraft.name}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="price-class-item bg-secondary text-light p-2 text-center float-left mr-3 mb-1"
                                                 v-for="price in charter.prices">
                                                <input type="radio" v-model="returnPricing" :value="price.id"
                                                       :disabled="returnCharter!=charter.id"
                                                       v-if="price.available_seats >= requiredSeats &&( '{{request("flight_class")}}' == price.flight_class)"/>

                                                <i class="fa fa-times text-warning"
                                                   v-if="price.available_seats < requiredSeats"></i>

                                                <h6 class="text-warning mt-1">
                                                  @{{ price.price_class }} (@{{price.available_seats > 9 ? 9 : price.available_seats}})
                                                </h6>
                                                @if(request("flight_type")== "RoundTrip")
                                                <span>@{{ price.price_adult_2 }} USD</span>
                                                @else
                                                <span>@{{ price.price_adult_1}} USD</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            
            @if(request("flight_type") == "OpenReturn")
                <header class="container mb-3">
                    <h1 class="departure section-header-main">
                        <div class="title-departure">
                        <span class="title-city-text">Select your return from <span
                                    class="text-info">{{$toCountry->name['ar']}}</span></span>
                            <span class="secondary bg-warning pl-2 pr-2">@{{coming}}</span>
                        </div>
                    </h1>
                </header>

                <div class="container" v-cloak>
                    <div>
                        <table class="table table-sm table-bordered table-striped mb-0">
                            <thead>
                                <tr class="bg-dark text-light">
                                <th width="50"></th>
                                <th width="120">Flight Class</th>
                                <th width="200">Flight Date - Time</th>
                                <th width="120">Flight Number</th>
                                <th width="120">Air Line</th>
                                <th>Price Class</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="charter in departureFlights">
                                    <td >
                                        <!--<input type="radio" name="open" v-model="openCharter" :value="charter.id" 
                                        v-if="( ((charter.prices.price_adult_3_1 > 0) && ({{request("coming_duration")}} == 1)) 
                                                            ||((charter.prices.price_adult_3_3 > 0) && ({{request("coming_duration")}} == 3)) 
                                                            ||((charter.prices.price_adult_3_6 > 0) && ({{request("coming_duration")}} == 6)) 
                                                            ||((charter.prices.price_adult_3_12 > 0) && ({{request("coming_duration")}} == 12))
                                                      
                                                            )"/>-->
                                    </td>
                                    <td v-else>
                                        لا يمكن حجز هذه الرحلة
                                    </td>
                                    <td>{{request("flight_class")}}</td>
                                    <td colspan="3">العودة خلال{{request("coming_duration")}} شهر</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="bg-secondary text-light p-2 text-center mr-3 mb-1" v-for="price in charter.prices" 
                                                v-if="( ((price.price_adult_3_1 > 0) && ({{request("coming_duration")}} == 1)) 
                                                            ||((price.price_adult_3_3 > 0) && ({{request("coming_duration")}} == 3)) 
                                                            ||((price.price_adult_3_6 > 0) && ({{request("coming_duration")}} == 6)) 
                                                            ||((price.price_adult_3_12 > 0) && ({{request("coming_duration")}} == 12))
                                                      
                                                            )">
                                                    <input type="radio" name="open" v-model="openCharter" :value="charter.id"
                                                        
                                                            v-if="( ((price.price_adult_3_1 > 0) && ({{request("coming_duration")}} == 1)) 
                                                            ||((price.price_adult_3_3 > 0) && ({{request("coming_duration")}} == 3)) 
                                                            ||((price.price_adult_3_6 > 0) && ({{request("coming_duration")}} == 6)) 
                                                            ||((price.price_adult_3_12 > 0) && ({{request("coming_duration")}} == 12))
                                                      
                                                            )"
                                                            />
                                                    <i class="fa fa-times text-warning"
                                                        v-if="!( ((price.price_adult_3_1 > 0) && ({{request("coming_duration")}} == 1)) 
                                                            ||((price.price_adult_3_3 > 0) && ({{request("coming_duration")}} == 3)) 
                                                            ||((price.price_adult_3_6 > 0) && ({{request("coming_duration")}} == 6)) 
                                                            ||((price.price_adult_3_12 > 0) && ({{request("coming_duration")}} == 12))
                                                      
                                                            )"></i>
                                                    @if(request("adults")>0)
                                                        @if(request("coming_duration") == "1")
                                                            <span v-if="price.price_adult_3_1 > 0">السعر adults @{{ price.price_adult_3_1 }} USD</span><br>
                                                        @elseif(request("coming_duration") == "3")
                                                            <span v-if="price.price_adult_3_3 > 0">السعر adults @{{ price.price_adult_3_3 }} USD</span><br>
                                                        @elseif(request("coming_duration") == "6")
                                                            <span v-if="price.price_adult_3_6 > 0">السعر adults @{{ price.price_adult_3_6 }} USD</span><br>
                                                        @elseif(request("coming_duration") == "12")
                                                            <span v-if="price.price_adult_3_12 > 0">السعر adults @{{ price.price_adult_3_12 }} USD</span><br>
                                                        @endif
                                                    @endif
                                                    @if(request("children")>0)
                                                        @if(request("coming_duration") == "1")
                                                            <span>السعر children @{{ price.price_child_3_1 }} USD</span><br>
                                                        @elseif(request("coming_duration") == "3")
                                                            <span>السعر children @{{ price.price_child_3_3 }} USD</span><br>
                                                        @elseif(request("coming_duration") == "6")
                                                            <span>السعر children @{{ price.price_child_3_6 }} USD</span><br>
                                                        @elseif(request("coming_duration") == "12")
                                                            <span>السعر children @{{ price.price_child_3_12 }} USD</span><br>
                                                        @endif
                                                    @endif
                                                    @if(request("babies")>0)
                                                        @if(request("coming_duration") == "1")
                                                            <span>السعر babies @{{ price.price_inf_3_1 }} USD</span><br>
                                                        @elseif(request("coming_duration") == "3")
                                                            <span>السعر babies @{{ price.price_inf_3_3 }} USD</span><br>
                                                        @elseif(request("coming_duration") == "6")
                                                            <span>السعر babies @{{ price.price_inf_3_6 }} USD</span><br>
                                                        @elseif(request("coming_duration") == "12")
                                                            <span>السعر babies @{{ price.price_inf_3_12 }} USD</span><br>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if(Auth::check())
                <div class="container mt-3">
                    <button class="btn btn-primary"
                            :disabled="(flight_type == 'OpenReturn' ? !(departureCharter && openCharter) : !departureCharter) || (flight_type == 'RoundTrip' ? !(departureCharter && returnCharter) : !departureCharter)"
                            @click="submitForm">@lang("alnkel.Continue")
                    </button>
                </div>
            @else
                <div class="alert m-alert m-alert--default alert-danger" role="alert">
                    @lang("alnkel.single-visa-please"), <a href="#" class="login" data-toggle="modal" data-target="#login_modal">@lang("alnkel.single-visa-login")</a> @lang("alnkel.single-visa-for-reservation")
                </div>
                
            @endif
        </div>

        <form action="{{route("charterCheckout")}}" ref="form" method="post">
            {{ csrf_field() }}
            <input type="hidden" :value="departureCharter" name="departure_charter"/>
            <input type="hidden" :value="returnCharter" name="return_charter"/>
            <input type="hidden" :value="departurePricing" name="departure_pricing"/>
            <input type="hidden" :value="returnPricing" name="return_pricing"/>
            <input type="hidden" value="{{request("adults")}}" name="reserve_adults"/>
            <input type="hidden" value="{{request("children")}}" name="reserve_children"/>
            <input type="hidden" value="{{request("babies")}}" name="reserve_babies"/>
            <input type="hidden" value="{{request("flight_class")}}" name="flight_class"/>
            <input type="hidden" value="{{request("flight_type")}}" name="flight_type"/>
            <input type="hidden" value="{{request("coming_duration")}}" name="coming_duration"/>
            <input type="hidden" value="{{request("search_type")}}" name="search_type"/>
        </form>
    </div>
@endsection

@section("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    
    <script>
        let params = {!! json_encode(request()->all()) !!};
        let dateFormat = "DD/MM/YYYY";

        let requiredSeats = {{request("adults")}} + {{request("children")}};

        var searchApp = new Vue({
            el: '#charter-search',
            data: {
                departureFlights: [],
                returnFlights: [],
                flight_type: 'OneWay',
                loading: true,
                departureCharter: false,
                returnCharter: false,
                openCharter: false,
                departurePricing: false,
                returnPricing: false,
                coming: params.coming,
                going: params.going,
                requiredSeats: requiredSeats
            },
            created() {
                this.fetchData();
            },
            filters: {
                moment: function (date) {
                    return moment(date).format("DD-MM-YYYY");
                }
            },
            mounted: function () {
                this.flight_type = '{{request("flight_type")}}';
                this.flight_class = '{{request("flight_class")}}';
                this.coming_duration = '{{request("coming_duration")}}'
            },
            methods: {
                pricing(charter, price) {
                  let c1 = charter.is_percent == 0 ? price.price_adult_1 : price.price_adult_1 - (price.price_adult_1 * (charter.commission / 100) ) ;
                  let c2 = charter.is_percent == 0 ? price.price_child_1 : price.price_child_1 - (price.price_child_1 * (charter.commission / 100) ) ;
                  let c3 = charter.is_percent == 0 ? price.price_inf_1 : price.price_inf_1 - (price.price_inf_1 * (charter.commission / 100) ) ;
                    let output = '<table class="table table-sm table-bordered" style="width:50%;"><thead><tr>'
                    output += `<th scope="col"><strong>@lang("alnkel.nameclient")</strong> </th> <th scope="col"><strong>@lang("alnkel.Adult")</strong> </th> - `
                    output += `<th scope="col"><strong>@lang("alnkel.Child")</strong></th> - `
                    output += `<th scope="col"><strong>@lang("alnkel.Inf")</strong></th><tr /> <tbody><tr>
                               <td>@lang("alnkel.nameclient")</td> <td>$${ price.price_adult_1  }</td><td>$${ price.price_child_1 } </td><td>$${ price.price_inf_1}</td></tr><tr><td>@lang("alnkel.nameclient1")</td> <td>$${ c1  }</td><td>$${c2} </td><td>$${c3}</td></tr></tbody></table>`

                    let changeCheck = charter.can_change === 1 ? 'fa-check' : 'fa-close',
                        cancelCheck = charter.can_cancel === 1 ? 'fa-check' : 'fa-close';

                    output += `<table class="table table-sm table-bordered mt-2">
                                <tr><td>@lang("Change")</td><td><i class="fa ${changeCheck}"></></td><td>${charter.change_fees ? charter.change_fees : '-'}</td></tr>
                                <tr><td>@lang("Cancel")</td><td><i class="fa ${cancelCheck}"></></td><td>${charter.cancel_fees ? charter.cancel_fees : '-'}</td></tr>
                            </table>`
                    return output
                },
                next(isComing) {
                    if (isComing) {
                        params.coming = moment(params.coming, dateFormat).add(1, 'd').format(dateFormat);
                        this.returnCharter = false
                    } else {
                        params.going = moment(params.going, dateFormat).add(1, 'd').format(dateFormat);
                        this.departureCharter = false
                    }

                    this.coming = params.coming;
                    this.going = params.going;

                    this.fetchData()
                },
                prev(isComing) {
                    if (isComing) {
                        params.coming = moment(params.coming, dateFormat).subtract(1, 'd').format(dateFormat);
                        this.returnCharter = false
                    } else {
                        params.going = moment(params.going, dateFormat).subtract(1, 'd').format(dateFormat);
                        this.departureCharter = false
                    }

                    this.coming = params.coming;
                    this.going = params.going;

                    this.fetchData()
                },
                fetchData() {
                    this.loading = true;

                    axios.post('{{route("charter.search.ajax")}}', params).then(response => {
                        this.departureFlights = response.data.departureFlights;
                        this.returnFlights = response.data.returnFlights;
                        this.loading = false;

                        Vue.nextTick(function () {
                            $('[data-toggle="popover"]').popover({
                                placement: 'bottom',
                                html: true,
                                trigger: 'focus'
                            })
                        })
                    });
                },
                selectFlight(charter, isReturn) {
                    let flights;

                    if (isReturn) {
                        this.returnCharter = charter;
                        this.returnPricing = false;

                        flights = this.returnFlights;
                    } else {
                        this.departureCharter = charter;
                        this.departurePricing = false;

                        flights = this.departureFlights;
                    }

                    let prices = (flights.find(function (item) {
                        return item.id === charter
                    })).prices;

                    let matchedPrices = prices.filter((price) => {
                        return price.available_seats >= requiredSeats
                    });

                    if (isReturn) {
                        this.returnPricing = matchedPrices.length > 0 ? matchedPrices[0].id : false;
                    } else {
                        this.departurePricing = matchedPrices.length > 0 ? matchedPrices[0].id : false;
                    }
                },
                submitForm(e) {
                    e.preventDefault();

                    this.$refs.form.submit();
                }
            }
        });
    </script>
@endsection

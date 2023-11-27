@extends('layouts.master')

@section('page-title')
    Charter Flights
@endsection

@section('sub-header')
    Create New Flight
@endsection

@section('content')
    @if(session()->has('success'))
        <div class="alert m-alert m-alert--default alert-success" role="alert">
            {{session()->get('success') }}
        </div>
    @endif
    @if(count($errors) > 0)
        <div class="m-alert m-alert--icon alert alert-danger" role="alert" id="m_form_1_msg">
            <div class="m-alert__icon">
                <i class="la la-warning"></i>
            </div>
            <div class="m-alert__text">
                Oh snap! Change a few things up and try submitting again.
            </div>
            <div class="m-alert__close">
                <button type="button" class="close" data-close="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Flight Details.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('storeCharter') }}" enctype="multipart/form-data">

                    <!--begin::Portlet-->
                    <div class="m-portlet">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row going-section">
                                <div class="col-lg-12 mb-2">
                                    <h4>Main Information</h4>
                                </div>
                              
                              
                              
                               <div class="col-lg-3 mb-3">
                                    <label>
                                        Flight <span class="text-danger">Status</span>:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" name="status_charter"
                                               placeholder="Enter flight Status" class="form-control m-input"
                                               value="{{ old('status_charter') }}" required>
                                    </div>
                                    @if(isset($errors->messages()['status_charter']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            {{  $errors->messages()['status_charter'][0] }}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-lg-3 mb-3">
                                    <label>
                                        Flight <span class="text-danger">Name</span>:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" name="name"
                                               placeholder="Enter flight name" class="form-control m-input"
                                               value="{{ old('name') }}" required>
                                    </div>
                                    @if(isset($errors->messages()['name']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            {{  $errors->messages()['name'][0] }}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-lg-3">
                                    <label><span class="text-danger">Flight</span> number</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-plane"></i></span>
                                        <input type="text" name="flight_number" class="form-control m-input"
                                               value="{{ old('flight_number') }}"
                                               placeholder="Enter flight number" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <label style="display: table">
                                        From where <span class="text-danger">to</span> where
                                    </label>

                                    <div class="input-group m-input-group m-input-group--square pull-left"
                                         style="width: 50%">
                                        <span class="input-group-addon"><i class="fa fa-plane"></i></span>
                                        <select class="form-control select2" id="m_select2_1"
                                                name="from_where" required>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}"
                                                        {{ old('from_where') === $country->id ? 'selected' : ''}}
                                                >{{ $country->name['ar'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if(isset($errors->messages()['from_where']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            {{  $errors->messages()['from_where'][0] }}
                                        </div>
                                    @endif

                                    <div class="input-group m-input-group m-input-group--square" style="width: 50%">
                                        <span class="input-group-addon"> to </span>

                                        <select class="form-control select2" id="m_select2_1"
                                                name="to_where" required>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}"
                                                        {{ old('to_where') === $country->id ? 'selected' : ''}}
                                                >{{ $country->name['ar'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if(isset($errors->messages()['to_where']))
                                        <div class="form-control-feedback" style="color: #f4516c;">
                                            {{  $errors->messages()['to_where'][0] }}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-lg-3 mb-3">
                                    <label><span class="text-danger">Flight</span> aircraft</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-plane"></i></span>
                                        <select class="form-control select2" id="m_select2_1"
                                                name="aircraft_id" required>
                                            @foreach($aircrafts as $aircraft)
                                                <option value="{{ $aircraft->id }}" {{ old('aircraft_id') === $aircraft->id ? 'selected' : ''}}>
                                                    {{ $aircraft->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label><span class="text-danger">Flight</span> Date</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="date" name="flight_date" class="form-control m-input date-picker"
                                               value="{{ old('flight_date') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label><span class="text-danger">Flight</span> departure time</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="text" name="departure_time" class="form-control m-input timer"
                                               value="{{ old('departure_time') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label><span class="text-danger">Flight</span> arrival time</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="text" name="arrival_time" class="form-control m-input timer"
                                               value="{{ old('arrival_time') }}" required>
                                    </div>
                                </div>
                              
                              
                                <div class="col-lg-3">
                                    <label><span class="text-danger">Arrival</span> Date</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="date" name="arrival_day" class="form-control m-input date-picker"
                                               value="{{ old('arrival_day') }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Flight <span class="text-danger">economy</span> seats</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon">+</span>
                                        <input type="number" name="economy_seats" class="form-control m-input"
                                               value="{{ old('economy_seats', 0) }}" required>
                                        <span class="input-group-addon">SEAT</span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label>Flight <span class="text-danger">business</span> seats</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon">+</span>
                                        <input type="number" name="business_seats" class="form-control m-input"
                                               value="{{ old('business_seats', 0) }}" required>
                                        <span class="input-group-addon">SEAT</span>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Client can <span class="text-danger">cancel?</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <select name="can_cancel" class="form-control m-input" required>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Cancel <span class="text-danger">fees</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="cancel_fees" class="form-control m-input"
                                               value="{{ old('cancel_fees', 0) }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label>Show in <span class="text-danger">home</span> page?</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <select name="show_in_home" class="form-control m-input" required>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label>Flight <span class="text-danger">type</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <select name="flight_type" class="form-control m-input" required>
                                            <option value="OneWay">One Way</option>
                                            <option value="RoundTrip">Round Trip</option>
                                        </select>
                                    </div>
                                </div>
                                
                                
                                <div class="col-lg-2">
                                    <label>Cancel <span class="text-danger">Duration 1</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="number" name="cancel_days_1" class="form-control m-input"
                                               value="{{ old('cancel_days_1', 0) }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Cancel Duration 1 <span class="text-danger">fees</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="cancel_fees_1" class="form-control m-input"
                                               value="{{ old('cancel_fees_1', 0) }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-2">
                                    <label>Cancel <span class="text-danger">Duration 2</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="number" name="cancel_days_2" class="form-control m-input"
                                               value="{{ old('cancel_days_2', 0) }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Cancel Duration 2 <span class="text-danger">fees</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="cancel_fees_2" class="form-control m-input"
                                               value="{{ old('cancel_fees_2', 0) }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-2">
                                    <label>Cancel <span class="text-danger">Duration 3</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="number" name="cancel_days_3" class="form-control m-input"
                                               value="{{ old('cancel_days_3', 0) }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Cancel Duration 3 <span class="text-danger">fees</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="cancel_fees_3" class="form-control m-input"
                                               value="{{ old('cancel_fees_3', 0) }}" required>
                                    </div>
                                </div>
                                
                                
                                

                                <div class="col-lg-12 mb-2 round-trip" hidden>
                                    <hr/>

                                    <h4>Round Trip Details</h4>
                                </div>

                                <div class="col-lg-3 round-trip" hidden>
                                    <label><span class="text-danger">Flight</span> number</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-plane"></i></span>
                                        <input type="text" name="2way_flight_number" class="form-control m-input"
                                               value="{{ old('2way_flight_number') }}"
                                               placeholder="Enter flight number">
                                    </div>
                                </div>

                                <div class="col-lg-3 round-trip" hidden>
                                    <label><span class="text-danger">Flight</span> Date</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="date" name="2way_flight_date"
                                               class="form-control m-input date-picker"
                                               value="{{ old('2way_flight_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 round-trip" hidden>
                                    <label><span class="text-danger">Flight</span> departure time</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="text" name="2way_departure_time" class="form-control m-input timer"
                                               value="{{ date('H:i a', strtotime( old('2way_departure_time') )) }}">
                                    </div>
                                </div>
                                <div class="col-lg-23 round-trip" hidden>
                                    <label><span class="text-danger">Flight</span> arrival time</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="text" name="2way_arrival_time" class="form-control m-input timer"
                                               value="{{ old('2way_arrival_time') }}">
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <hr/>

                                    <h4>Pricing</h4>
                                </div>

                                <div class="col-lg-12 mb-2 mt-4">
                                    <h5><span class="text-info">Economy Prices</span></h5>
                                </div>

                                <div class="col-lg-4">
                                    <label class="d-table">Price <span class="text-danger">Adult</span></label>
                                    <div class="input-group m-input-group m-input-group--square pull-left w-50">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="price_adult" class="form-control m-input text-right"
                                               value="{{ old('price_adult') }}" required>
                                    </div>
                                    <div class="input-group m-input-group m-input-group--square w-50">
                                        <span class="input-group-addon">2Way</span>
                                        <input type="number" name="price_adult_2way"
                                               class="form-control m-input text-right"
                                               value="{{ old('price_adult_2way') }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <label class="d-table">Price <span class="text-danger">Children</span></label>
                                    <div class="input-group m-input-group m-input-group--square pull-left w-50">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="price_child" class="form-control m-input text-right"
                                               value="{{ old('price_child') }}" required>
                                    </div>
                                    <div class="input-group m-input-group m-input-group--square w-50">
                                        <span class="input-group-addon">2Way</span>
                                        <input type="number" name="price_child_2way"
                                               class="form-control m-input text-right"
                                               value="{{ old('price_child_2way') }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <label class="d-table">Price <span class="text-danger">baby</span></label>
                                    <div class="input-group m-input-group m-input-group--square pull-left w-50">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="price_baby" class="form-control m-input text-right"
                                               value="{{ old('price_baby') }}" required>
                                    </div>
                                    <div class="input-group m-input-group m-input-group--square w-50">
                                        <span class="input-group-addon">2Way</span>
                                        <input type="number" name="price_baby_2way"
                                               class="form-control m-input text-right"
                                               value="{{ old('price_baby_2way') }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-2 mt-4">
                                    <h5><span class="text-info">Business Prices</span></h5>
                                </div>

                                <div class="col-lg-4">
                                    <label class="d-table">Price <span class="text-danger">Adult</span></label>
                                    <div class="input-group m-input-group m-input-group--square pull-left w-50">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="business_adult"
                                               class="form-control m-input text-right"
                                               value="{{ old('business_adult') }}" required>
                                    </div>
                                    <div class="input-group m-input-group m-input-group--square w-50">
                                        <span class="input-group-addon">2Way</span>
                                        <input type="number" name="business_2way_adult"
                                               class="form-control m-input text-right"
                                               value="{{ old('business_2way_adult') }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <label class="d-table">Price <span class="text-danger">Children</span></label>
                                    <div class="input-group m-input-group m-input-group--square pull-left w-50">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="business_child"
                                               class="form-control m-input text-right"
                                               value="{{ old('business_child') }}" required>
                                    </div>
                                    <div class="input-group m-input-group m-input-group--square w-50">
                                        <span class="input-group-addon">2Way</span>
                                        <input type="number" name="business_2way_child"
                                               class="form-control m-input text-right"
                                               value="{{ old('business_2way_child') }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <label class="d-table">Price <span class="text-danger">baby</span></label>
                                    <div class="input-group m-input-group m-input-group--square pull-left w-50">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="business_baby"
                                               class="form-control m-input text-right"
                                               value="{{ old('business_baby') }}" required>
                                    </div>
                                    <div class="input-group m-input-group m-input-group--square w-50">
                                        <span class="input-group-addon">2Way</span>
                                        <input type="number" name="business_2way_baby"
                                               class="form-control m-input text-right"
                                               value="{{ old('business_2way_baby') }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <hr/>

                                    <h4>Commission</h4>
                                </div>

                                <div class="col-lg-4">
                                    <label><span class="text-danger">Commission</span> Value:</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <input type="text" name="commission" class="form-control m-input"
                                               placeholder="Enter commission value"
                                               value="{{ old('commission') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label><span class="text-danger">Commission</span> Calculation:</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <select name="is_percent" class="form-control m-input" required>
                                            <option value="0">Fixed amount</option>
                                            <option value="1">Percentage</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <hr/>

                                    <h4>Instructions</h4>
                                </div>

                                <div class="col-lg-12">
                                    <label><span class="text-danger">Flight</span> Instructions:</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <textarea class="form-control" rows="6" name="instructions"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr class="mt-4 mb-4"/>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-lg-12 mb-2">
                                            <h4>Pay Later Settings</h4>
                                        </div>

                                        <div class="col-lg-6">
                                            <label><span class="text-danger">Maximum</span> hours for payment:</label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">+</span>
                                                <input type="number" name="pay_later_max" class="form-control m-input"
                                                       value="{{ old('pay_later_max', 0) }}">
                                                <span class="input-group-addon">HOURS</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-lg-12 mb-2">
                                            <h4>Void Settings</h4>
                                        </div>

                                        <div class="col-lg-6">
                                            <label><span class="text-danger">Maximum</span> hours for payment:</label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">+</span>
                                                <input type="number" name="void_max" class="form-control m-input"
                                                       value="{{ old('void_max', 0) }}">
                                                <span class="input-group-addon">HOURS</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <hr/>

                                    <h4>Is frequent flight?</h4>
                                    <span class="text-muted">The flight will be duplicated with the same data with the selected days</span>
                                </div>

                                <div class="col-lg-6" style="margin-bottom: 20px;">
                                    <label><span class="text-danger">From</span> Date</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="date" name="frequent_from_date"
                                               class="form-control m-input date-picker"
                                               value="{{ old('frequent_from_date') }}">
                                    </div>
                                </div>

                                <div class="col-lg-6" style="margin-bottom: 20px;">
                                    <label><span class="text-danger">To</span> Date</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="date" name="frequent_to_date" class="form-control m-input date-picker"
                                               value="{{ old('frequent_to_date') }}">
                                    </div>
                                </div>

                                @foreach(["saturday", "sunday", "monday", "tuesday", "wednesday", "thursday", "friday"] as $day)
                                    <div class="col-lg-4">
                                        <div class="form-check">
                                            <input type="checkbox" name="frequent_days[]" value="{{$day}}" id="d-{{$day}}<">
                                            <label class="form-check-label" for="d-{{$day}}<">{{ucfirst($day)}}</label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
            </div>
            <!--end::Portlet-->
            {!! csrf_field() !!}
            <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions--solid">
                    <div class="row">
                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                            <a href="{{ route('listCharter') }}" class="btn btn-secondary">
                                Go Back
                            </a>
                        </div>
                        <div class="col-lg-8"></div>
                    </div>
                </div>
            </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Portlet-->
    </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('default-assets/demo/default/custom/components/forms/widgets/ckeditor/ckeditor.js') }}"
            type="text/javascript"></script>

    <script src="{{ asset('default-assets/demo/default/custom/components/forms/widgets/select2.js') }}"
            type="text/javascript"></script>

    <script src="{{ asset('front-assets/bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"
            type="text/javascript"></script>

    <script>

        if ($('[name=flight_type]').val() === "RoundTrip") {
            $('.round-trip').removeAttr('hidden');
        }

        $('[name=flight_type]').on('change', function () {
            if ($(this).val() === "RoundTrip") {
                $('.round-trip').removeAttr('hidden');
            } else {
                $('.round-trip').attr('hidden', true);
            }
        });

        $('.timer').timepicker({
            icons: {
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down'
            },
        format: 'HH:mm a',
          showMeridian:false

        });

        $('#ticket').on('change', function () {
            if ($(this).val() === 'RoundTrip') {
                $('.coming-section').show();
                $('#tab_5_5').removeClass('disabled');
                $('#tab_5_6').removeClass('disabled');
            } else if ($(this).val() === 'OneWay') {
                $('.coming-section').hide();
                $('#tab_5_5').addClass('disabled');
                $('#tab_5_6').addClass('disabled');
            }
        });

        $('#pricing-form-repeater').repeater({
            initEmpty: true,

            defaultValues: {
                'text-input': 'foo'
            },

            isFirstItemUndeletable: true,

            show: function () {
                $(this).slideDown();

                $(this).find('.date-picker').datepicker({
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: {
                        leftArrow: '<i class="la la-angle-left"></i>',
                        rightArrow: '<i class="la la-angle-right"></i>'
                    }
                });
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        $('.m-price').on('input', function () {
            var name = $(this).attr('name');
            var new_name = name.replace('business', 'business_2way');
            new_name = new_name.replace('adult', 'adult_2way');
            new_name = new_name.replace('children', 'children_2way');
            new_name = new_name.replace('baby', 'baby_2way');

            $("[name='" + new_name + "']").val($(this).val());
        });
    </script>
@endsection
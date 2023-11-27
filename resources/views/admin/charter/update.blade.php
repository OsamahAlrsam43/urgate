@extends('layouts.master')

@section('page-title')
    Edit Flight
@endsection

@section('sub-header')
    Edit Flight
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
                        <a href="{{route('deleteCharter', ['charter' => $charter->id])}}"
                           class="btn btn-danger pull-right mt-3">
                            <i class="fa fa-close"></i> Archive Flight
                        </a>

                        <a href="{{route('lockCharter', ['charter' => $charter->id])}}"
                           class="btn btn-brand pull-right mt-3 mr-2">
                            <i class="fa fa-{{$charter->locked ? "unlock" : "lock"}}"></i> {{$charter->locked ? "Unlock" : "Lock"}}
                            Charter
                        </a>

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
                      action="{{ route('updateCharter',['charter' => $charter->id]) }}" enctype="multipart/form-data">

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
                                                 value="{{ old('status_charter', $charter->status_charter) }}" required>
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
                                               value="{{ old('name', $charter->name) }}">
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
                                               value="{{ old('flight_number', $charter->flight_number) }}"
                                               placeholder="Enter flight number">
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
                                                name="from_where">
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}"
                                                        {{ old('from_where', $charter->from_where) === $country->id ? 'selected' : ''}}
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
                                                name="to_where">
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}"
                                                        {{ old('to_where', $charter->to_where) === $country->id ? 'selected' : ''}}
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
                                                name="aircraft_id">
                                            @foreach($aircrafts as $aircraft)
                                                <option {{ $charter->aircraft->id == $aircraft->id ? 'selected' : ''}} value="{{ $aircraft->id }}">
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
                                               value="{{ old('flight_date', $charter->flight_date->format('Y-m-d')) }}"
                                        >
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label><span class="text-danger">Flight</span> departure time</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="text" name="departure_time" class="form-control m-input timer"
                                               value="{{ old('departure_time', $charter->departure_time) }}">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label><span class="text-danger">Flight</span> arrival time</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="text" name="arrival_time" class="form-control m-input timer"
                                               value="{{ old('arrival_time',  date('H:i a', strtotime( $charter->arrival_time) )) }}">
                                    </div>
                                </div>
                              
                                 <div class="col-lg-3">
                                    <label><span class="text-danger">Arrival</span> Date</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="date" name="arrival_day" class="form-control m-input date-picker"
                                               value="{{ old('arrival_day',  $charter->arrival_day != '00:00:00' ?$charter->arrival_day  :  $charter->flight_date->format('Y-m-d'))  }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Flight <span class="text-danger">economy</span> seats</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon">+</span>
                                        <input type="number" name="economy_seats" class="form-control m-input"
                                               value="{{ old('economy_seats', $charter->economy_seats) }}">
                                        <span class="input-group-addon">SEAT</span>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label>Flight <span class="text-danger">business</span> seats</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon">+</span>
                                        <input type="number" name="business_seats" class="form-control m-input"
                                               value="{{ old('business_seats', $charter->business_seats) }}">
                                        <span class="input-group-addon">SEAT</span>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Seats <span class="text-danger">increase</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="seat_increase" class="form-control m-input"
                                               value="{{ old('seat_increase', $charter->seat_increase) }}">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3"></div>

                                <div class="col">
                                    <label>Can <span class="text-danger">cancel?</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <select name="can_cancel" class="form-control m-input">
                                            <option value="0" {{ old('can_cancel', $charter->can_cancel) == "0" ? 'selected' : ''}}>
                                                No
                                            </option>
                                            <option value="1" {{ old('can_cancel', $charter->can_cancel) == "1" ? 'selected' : ''}}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Cancel <span class="text-danger">fees</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="cancel_fees" class="form-control m-input"
                                               value="{{ old('cancel_fees', $charter->cancel_fees) }}">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Can <span class="text-danger">change?</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <select name="can_change" class="form-control m-input">
                                            <option value="0" {{ old('can_change', $charter->can_change) == "0" ? 'selected' : ''}}>
                                                No
                                            </option>
                                            <option value="1" {{ old('can_change', $charter->can_change) == "1" ? 'selected' : ''}}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Change <span class="text-danger">fees</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="change_fees" class="form-control m-input"
                                               value="{{ old('change_fees', $charter->change_fees) }}">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Show in <span class="text-danger">home</span>?</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <select name="show_in_home" class="form-control m-input">
                                            <option value="0" {{ old('show_in_home', $charter->show_in_home) == "0" ? 'selected' : ''}}>
                                                No
                                            </option>
                                            <option value="1" {{ old('show_in_home', $charter->show_in_home) == "1" ? 'selected' : ''}}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Flight <span class="text-danger">type</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <select name="flight_type" class="form-control m-input">
                                            <option value="OneWay" {{ old('flight_type', $charter->flight_type) == 'OneWay' ? 'selected' : ''}}>
                                                One Way
                                            </option>
                                            <option value="RoundTrip" {{ old('flight_type', $charter->flight_type) == 'RoundTrip' ? 'selected' : ''}}>
                                                Round Trip
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                
                                <hr>
                                <div class="col-lg-2">
                                    <label>Cancel <span class="text-danger">Duration 1</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="number" name="cancel_days_1" class="form-control m-input"
                                               value="{{ $charter->cancel_days_1 }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Cancel Duration 1 <span class="text-danger">fees</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="cancel_fees_1" class="form-control m-input"
                                               value="{{ $charter->cancel_fees_1 }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-2">
                                    <label>Cancel <span class="text-danger">Duration 2</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="number" name="cancel_days_2" class="form-control m-input"
                                               value="{{ $charter->cancel_days_2 }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Cancel Duration 2 <span class="text-danger">fees</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="cancel_fees_2" class="form-control m-input"
                                               value="{{ $charter->cancel_fees_2 }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-2">
                                    <label>Cancel <span class="text-danger">Duration 3</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="number" name="cancel_days_3" class="form-control m-input"
                                               value="{{ $charter->cancel_days_3 }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label>Cancel Duration 3 <span class="text-danger">fees</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="cancel_fees_3" class="form-control m-input"
                                               value="{{ $charter->cancel_fees_3 }}" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-2">
                                    <label>change <span class="text-danger">Duration 1</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="number" name="change_days_1" class="form-control m-input"
                                                value="{{ $charter->change_days_1 }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-2">
                                    <label>change Duration 1 <span class="text-danger">fees</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="change_fees_1" class="form-control m-input"
                                                value="{{ $charter->change_fees_1 }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-2">
                                    <label>change <span class="text-danger">Duration 2</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="number" name="change_days_2" class="form-control m-input"
                                                value="{{ $charter->change_days_2 }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-2">
                                    <label>change Duration 2 <span class="text-danger">fees</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="change_fees_2" class="form-control m-input"
                                                value="{{ $charter->change_fees_2 }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-2">
                                    <label>change <span class="text-danger">Duration 3</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="number" name="change_days_3" class="form-control m-input"
                                                value="{{ $charter->change_days_3 }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-2">
                                    <label>change Duration 3 <span class="text-danger">fees</span></label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                        <input type="number" name="change_fees_3" class="form-control m-input"
                                                value="{{ $charter->change_fees_3 }}" required>
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
                                               value="{{ old('2way_flight_number', $charter->roundtrip ? $charter->roundtrip->flight_number : '') }}"
                                               placeholder="Enter flight number">
                                    </div>
                                </div>
                                <div class="col-lg-3 round-trip" hidden>
                                    <label><span class="text-danger">Flight</span> Date</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="date" name="2way_flight_date"
                                               class="form-control m-input date-picker"
                                               value="{{ old('2way_flight_date', $charter->roundtrip ? $charter->roundtrip->flight_date  : '') }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 round-trip" hidden>
                                    <label><span class="text-danger">Flight</span> departure time</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="text" name="2way_departure_time" class="form-control m-input timer"
                                               value="{{ old('2way_departure_time', $charter->roundtrip ? $charter->roundtrip->departure_time  : '') }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 round-trip" hidden>
                                    <label><span class="text-danger">Flight</span> arrival time</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        <input type="text" name="2way_arrival_time" class="form-control m-input timer"
                                               value="{{ old('2way_arrival_time', $charter->roundtrip ? $charter->roundtrip->arrival_time : '') }}">
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
                                               value="{{ old('commission', $charter->commission) }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label><span class="text-danger">Commission</span> Calculation:</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <select name="is_percent" class="form-control m-input">
                                            <option value="0" {{ old('is_percent', $charter->is_percent) == "0" ? 'selected' : ''}}>
                                                Fixed amount
                                            </option>
                                            <option value="1" {{ old('is_percent', $charter->is_percent) == "1" ? 'selected' : ''}}>
                                                Percentage
                                            </option>
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
                                        <textarea class="form-control" rows="6"
                                                  name="instructions">{{$charter->instructions}}</textarea>
                                    </div>
                                </div>
                              
                              <div class="col-lg-12 mb-2">
                                    <hr/>

                                    <h4>Informations</h4>
                                </div>

                                <div class="col-lg-12">
                                    <label><span class="text-danger">Flight</span> Information:</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <textarea class="form-control" rows="6"
                                                  name="info">{{$charter->info}}</textarea>
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
                                                       value="{{ old('pay_later_max', $charter->pay_later_max) }}">
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
                                                       value="{{ old('void_max', $charter->void_max) }}">
                                                <span class="input-group-addon">HOURS</span>
                                            </div>
                                        </div>
                                    </div>
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
    </script>
@endsection
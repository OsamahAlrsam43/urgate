@extends('layouts.master')

@section('page-title')
    Charter Flights
@endsection

@section('sub-header')
    Charter Flights - Create
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
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('storeCharter') }}" enctype="multipart/form-data">

                    <!--begin::Portlet-->
                    <div class="m-portlet">
                        <div class="m-portlet__body">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#m_tabs_5_1">
                                        Common (english)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#m_tabs_5_2">
                                        Common (arabic)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#m_tabs_5_3">
                                        Going (english)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#m_tabs_5_4">
                                        Going (arabic)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ old('ticket') === 'OneWay' ? 'disabled' : ''}}"
                                       data-toggle="tab" href="#m_tabs_5_5" id="tab_5_5">
                                        Coming (english)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ old('ticket') === 'OneWay' ? 'disabled' : ''}}"
                                       data-toggle="tab" href="#m_tabs_5_6" id="tab_5_6">
                                        Coming (arabic)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                       data-toggle="tab" href="#m_tabs_5_7" id="tab_5_7">
                                        Pricing
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_tabs_5_1" role="tabpanel">
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4">
                                            <label>
                                                Client can cancel:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <select name="can_cancel" class="form-control m-input">
                                                    <option value="0">
                                                        No
                                                    </option>
                                                    <option value="1">
                                                        Yes
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>
                                                Commission Value:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <input type="text" name="commission" class="form-control m-input"
                                                       placeholder="Enter commission value"
                                                       value="{{ old('commission') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>
                                                Commission Calculation:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <select name="is_percent" class="form-control m-input">
                                                    <option value="0">Fixed amount</option>
                                                    <option value="1">Percentage</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-3">
                                            <label>
                                                Flight Name:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </span>
                                                <input type="text" name="name[en]" class="form-control m-input"
                                                       placeholder="Enter flight name" value="{{ old('name.en') }}">
                                            </div>
                                            @if(isset($errors->messages()['name.en']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['name.en'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                                Please enter flight name in english
                                            </span>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>
                                                Flight Name (Arabic):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </span>
                                                <input type="text" name="name[ar]" class="form-control m-input"
                                                       placeholder="Enter flight name" value="{{ old('name.ar') }}">
                                            </div>
                                            @if(isset($errors->messages()['name.ar']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['name.ar'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                                Please enter flight name in arabic
                                            </span>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>
                                                Flight No:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                                <input type="text" name="flight_number" class="form-control m-input"
                                                       placeholder="Enter flight number"
                                                       value="{{ old('flight_number') }}">
                                            </div>
                                            @if(isset($errors->messages()['flight_number']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['flight_number'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight number in arabic
                                </span>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>
                                                Ticket:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-ticket"></i>
                                                </span>
                                                <select name="ticket" class="form-control m-input" id="ticket">
                                                    <option value="">Select ticket type</option>
                                                    <option value="RoundTrip" {{ old('ticket') === 'RoundTrip' ? 'selected' : '' }}>
                                                        Round Trip
                                                    </option>
                                                    <option value="OneWay" {{ old('ticket') === 'OneWay' ? 'selected' : '' }}>
                                                        One Way
                                                    </option>
                                                </select>
                                            </div>
                                            @if(isset($errors->messages()['ticket']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['ticket'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please select Ticket type
                                </span>
                                        </div>

                                        <div class="col-lg-12">
                                            <label>
                                                Flight Instructions:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                                <textarea name="instructions" rows="8" class="form-control m-input"
                                                          placeholder="Enter flight instructions">{{ old('instructions') }}</textarea>
                                            </div>
                                            @if(isset($errors->messages()['instructions']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['instructions'][0] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Aircraft Operator:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="aircraft_operator[en]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight aircraft operator"
                                                       value="{{ old('aircraft_operator.en') }}">
                                            </div>
                                            @if(isset($errors->messages()['aircraft_operator.en']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['aircraft_operator.en'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight aircraft operator
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Airplane Type:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="airplane_type[en]" class="form-control m-input"
                                                       placeholder="Enter flight airplane type"
                                                       value="{{ old('airplane_type.en') }}">
                                            </div>
                                            @if(isset($errors->messages()['airplane_type.en']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['airplane_type.en'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airplane type
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Class:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="class[en]" class="form-control m-input"
                                                       placeholder="Enter flight class" value="{{ old('class.en') }}">
                                            </div>
                                            @if(isset($errors->messages()['class.en']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['class.en'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight class
                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row going-section">
                                        <div class="col-lg-6">
                                            <label class="">
                                                Going (from country):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                            <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                                <select class="form-control m-select2" id="m_select2_1"
                                                        name="trip_information[common][going][from_country]">
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}"
                                                                {{ old('trip_information.common.going.from_country') === $country->id ? 'selected' : ''}}
                                                        >{{ $country->name['ar'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if(isset($errors->messages()['trip_information.common.going.from_country']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.common.going.from_country'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                                Please enter flight from country (going)
                                            </span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="">
                                                Going (to country):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-map"></i>
                                                </span>

                                                <select class="form-control m-select2" id="m_select2_1"
                                                        name="trip_information[common][going][to_country]">
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}"
                                                                {{ old('trip_information.common.going.to_country') === $country->id ? 'selected' : ''}}
                                                        >{{ $country->name['ar'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if(isset($errors->messages()['trip_information.common.going.to_country']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.common.going.to_country'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                                Please enter flight to country (going)
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4">
                                            <label>
                                                Aircraft Logo:
                                            </label>
                                            <div class="m-input-icon m-input-icon--right">
                                                <input type="file" name="aircraft_logo" class="form-control m-input">
                                            </div>
                                            @if(isset($errors->messages()['aircraft_logo']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['aircraft_logo'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please select your aircraft logo.
                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="m_tabs_5_2" role="tabpanel">
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Aircraft Operator:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="aircraft_operator[ar]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight aircraft operator"
                                                       value="{{ old('aircraft_operator.ar') }}">
                                            </div>
                                            @if(isset($errors->messages()['aircraft_operator.ar']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['aircraft_operator.ar'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight aircraft operator
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Airplane Type:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="airplane_type[ar]" class="form-control m-input"
                                                       placeholder="Enter flight airplane type"
                                                       value="{{ old('airplane_type.ar') }}">
                                            </div>
                                            @if(isset($errors->messages()['airplane_type.ar']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['airplane_type.ar'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airplane type
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Class:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="class[ar]" class="form-control m-input"
                                                       placeholder="Enter flight class" value="{{ old('class.ar') }}">
                                            </div>
                                            @if(isset($errors->messages()['class.ar']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['class.ar'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight class
                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="m_tabs_5_3" role="tabpanel">
                                    <div class="form-group m-form__group row going-section">
                                        <div class="col-lg-6">
                                            <label class="">
                                                Going (Start Date):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                                <input type="date" class="form-control m-input"
                                                       name="trip_information[common][going][start_date]"
                                                       placeholder="Enter your flight start date (going)"
                                                       value="{{ old('trip_information.common.going.start_date') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.common.going.start_date']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.common.going.start_date'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter your flight start date (going)
                                </span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="">
                                                Going (End Date):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                                <input type="date" class="form-control m-input"
                                                       name="trip_information[common][going][end_date]"
                                                       placeholder="Enter your flight end date (going)"
                                                       value="{{ old('trip_information.common.going.end_date') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.common.going.end_date']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.common.going.end_date'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter your flight end date (going)
                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row going-section">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Going (from airport):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][going][from_airport]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight from airport (going)"
                                                       value="{{ old('trip_information.en.going.from_airport') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.en.going.from_airport']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.en.going.from_airport'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight from airport (going)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Going (to airport):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][going][to_airport]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight to airport (going)"
                                                       value="{{ old('trip_information.en.going.to_airport') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.en.going.to_airport']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.en.going.to_airport'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight to airport (going)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Going (from city):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][going][from_city]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's from city (going)"
                                                       value="{{ old('trip_information.en.going.from_city') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.en.going.from_city']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.en.going.from_city'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's from city (going)
                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row going-section">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Going (to city):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][going][to_city]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's to city (going)"
                                                       value="{{ old('trip_information.en.going.to_city') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.en.going.to_city']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.en.going.to_city'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's to city (going)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Going (from lounge):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][going][from_lounge]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's lounge (going)"
                                                       value="{{ old('trip_information.en.going.from_lounge') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.en.going.from_lounge']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.en.going.from_lounge'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's from lounge (going)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Going (to lounge):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][going][to_lounge]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's lounge (going)"
                                                       value="{{ old('trip_information.en.going.to_lounge') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.en.going.to_lounge']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.en.going.to_lounge'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's to lounge (going)
                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="m_tabs_5_4" role="tabpanel">
                                    <div class="form-group m-form__group row going-section">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Going (from airport):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][going][from_airport]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight from airport (going)"
                                                       value="{{ old('trip_information.ar.going.from_airport') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.ar.going.from_airport']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.ar.going.from_airport'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight from airport (going)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Going (to airport):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][going][to_airport]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight to airport (going)"
                                                       value="{{ old('trip_information.ar.going.to_airport') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.ar.going.to_airport']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.ar.going.to_airport'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight to airport (going)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Going (from city):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][going][from_city]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's from city (going)"
                                                       value="{{ old('trip_information.ar.going.from_city') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.ar.going.from_city']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.ar.going.from_city'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's from city (going)
                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row going-section">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Going (to city):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][going][to_city]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's to city (going)"
                                                       value="{{ old('trip_information.ar.going.to_city') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.ar.going.to_city']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.ar.going.to_city'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's to city (going)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Going (from lounge):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][going][from_lounge]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's lounge (going)"
                                                       value="{{ old('trip_information.ar.going.from_lounge') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.ar.going.from_lounge']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.ar.going.from_lounge'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's from lounge (going)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Going (to lounge):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][going][to_lounge]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's lounge (going)"
                                                       value="{{ old('trip_information.ar.going.to_lounge') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.ar.going.to_lounge']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.ar.going.to_lounge'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's to lounge (going)
                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="m_tabs_5_5" role="tabpanel">
                                    <div class="form-group m-form__group row coming-section {{ old('ticket') === 'OneWay' ? 'm--hide' : ''}}">
                                        <div class="col-lg-6">
                                            <label class="">
                                                Coming (Start Date):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                                <input type="date" class="form-control m-input"
                                                       name="trip_information[common][coming][start_date]"
                                                       placeholder="Enter your flight start date (coming)"
                                                       value="{{ old('trip_information.common.coming.start_date') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.common.coming.start_date']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.common.coming.start_date'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter your flight start date (coming)
                                </span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="">
                                                Coming (End Date):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                                <input type="date" class="form-control m-input"
                                                       name="trip_information[common][coming][end_date]"
                                                       placeholder="Enter flight end date (coming)"
                                                       value="{{ old('trip_information.common.coming.end_date') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.common.coming.end_date']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.common.coming.end_date'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter your flight end date (coming)
                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row coming-section {{ old('ticket') === 'OneWay' ? 'm--hide' : ''}}">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (from airport):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][coming][from_airport]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight from airport (coming)"
                                                       value="{{ old('trip_information.en.coming.from_airport') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.en.coming.from_airport']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.en.coming.from_airport'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight from airport (coming)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (to airport):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][coming][to_airport]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight to airport (coming)"
                                                       value="{{ old('trip_information.en.coming.to_airport') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.en.coming.to_airport']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.en.coming.to_airport'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight to airport (coming)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (from city):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][coming][from_city]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's city (coming)"
                                                       value="{{ old('trip_information.en.coming.from_city') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.en.coming.from_city']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.en.coming.from_city'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's from city (coming)
                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row coming-section {{ old('ticket') === 'OneWay' ? 'm--hide' : ''}}">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (to city):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][coming][to_city]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's city (coming)"
                                                       value="{{ old('trip_information.en.coming.to_city') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.en.coming.to_city']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.en.coming.to_city'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's to city (coming)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (from lounge):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][coming][from_lounge]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's from lounge (coming)"
                                                       value="{{ old('trip_information.en.coming.from_lounge') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.en.coming.from_lounge']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.en.coming.from_lounge'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's from lounge (coming)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (to lounge):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][coming][to_lounge]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's to lounge (coming)"
                                                       value="{{ old('trip_information.en.coming.to_lounge') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.en.coming.to_lounge']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.en.coming.to_lounge'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's to lounge (coming)
                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="m_tabs_5_6" role="tabpanel">
                                    <div class="form-group m-form__group row coming-section {{ old('ticket') === 'OneWay' ? 'm--hide' : ''}}">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (from airport):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][coming][from_airport]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight from airport (coming)"
                                                       value="{{ old('trip_information.ar.coming.from_airport') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.ar.coming.from_airport']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.ar.coming.from_airport'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight from airport (coming)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (to airport):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][coming][to_airport]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight to airport (coming)"
                                                       value="{{ old('trip_information.ar.coming.to_airport') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.ar.coming.to_airport']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.ar.coming.to_airport'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight to airport (coming)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (from city):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][coming][from_city]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's city (coming)"
                                                       value="{{ old('trip_information.ar.coming.from_city') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.ar.coming.from_city']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.ar.coming.from_city'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's from city (coming)
                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row coming-section {{ old('ticket') === 'OneWay' ? 'm--hide' : ''}}">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (to city):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][coming][to_city]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's city (coming)"
                                                       value="{{ old('trip_information.ar.coming.to_city') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.ar.coming.to_city']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.ar.coming.to_city'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's to city (coming)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (from lounge):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][coming][from_lounge]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's from lounge (coming)"
                                                       value="{{ old('trip_information.ar.coming.from_lounge') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.ar.coming.from_lounge']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.ar.coming.from_lounge'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's from lounge (coming)
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (to lounge):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][coming][to_lounge]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight airport's to lounge (coming)"
                                                       value="{{ old('trip_information.ar.coming.to_lounge') }}">
                                            </div>
                                            @if(isset($errors->messages()['trip_information.ar.coming.to_lounge']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['trip_information.ar.coming.to_lounge'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight airport's to lounge (coming)
                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="m_tabs_5_7" role="tabpanel">
                                    <div id="pricing-form-repeater">
                                        <div data-repeater-list="price">

                                            <div style="padding-bottom: 10px">
                                                <button class="btn btn-primary btn-xs" type="button" data-repeater-create>
                                                    <i class="fa fa-plus"></i> Add day
                                                </button>
                                            </div>

                                            <div class="form-group row m--padding-bottom-10" style="margin-right: 50px;position: relative;" data-repeater-item>
                                                <div class="col-lg-2" style="margin-bottom: 20px;">
                                                    <label>Date</label>
                                                    <input type="text" name="date" class="form-control m-input date-picker">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>Time</label>
                                                    <input type="text" name="time" class="form-control m-input">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>Seats</label>
                                                    <input type="number" name="seats" class="form-control m-input">
                                                    <input type="hidden" name="reserved_seats" value="0">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Price [Business]</label>
                                                    <input type="text" name="business" class="form-control m-input"
                                                           placeholder="Price for businessman">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Price [Adult]</label>
                                                    <input type="text" name="adult" class="form-control m-input"
                                                           placeholder="Price for adult">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Price [Children]</label>
                                                    <input type="text" name="children" class="form-control m-input"
                                                           placeholder="Price for children">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Price [Baby]</label>
                                                    <input type="text" name="baby" class="form-control m-input"
                                                           placeholder="Price for baby">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Price [Business] [2 Way]</label>
                                                    <input type="text" name="business_2way" class="form-control m-input"
                                                           placeholder="Price for businessman">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Price [Adult] [2 Way]</label>
                                                    <input type="text" name="adult_2way" class="form-control m-input"
                                                           placeholder="Price for adult">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Price [Children] [2 Way]</label>
                                                    <input type="text" name="children_2way" class="form-control m-input"
                                                           placeholder="Price for children">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Price [Baby] [2 Way]</label>
                                                    <input type="text" name="baby_2way" class="form-control m-input"
                                                           placeholder="Price for baby">
                                                </div>
                                                <div style="position: absolute;right: -50px;top: 25px;">
                                                    <button class="btn btn-danger btn-xs" type="button" data-repeater-delete>
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
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
                                <div class="col-lg-4"></div>
                                <div class="col-lg-8">
                                    <button type="submit" class="btn btn-primary">
                                        Add Flight
                                    </button>
                                    <a href="{{ route('listFlights') }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
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

    <script>
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
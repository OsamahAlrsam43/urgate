@extends('layouts.master')

@section('page-title')
    Flights
@endsection

@section('sub-header')
    Flights- Update
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
                                Flight Details (English).
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('updateFlight',['flight' => $flight->id]) }}" enctype="multipart/form-data">

                    <!--begin::Portlet-->
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Flight Information
                                    </h3>
                                </div>
                            </div>
                        </div>
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
                                    <a class="nav-link {{ old('ticket') ?  old('ticket') === 'OneWay' ? 'disabled' : '' : $flight->ticket === 'OneWay' ? 'disabled' : ''}}"
                                       data-toggle="tab" href="#m_tabs_5_5" id="tab_5_5">
                                        Coming (english)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ old('ticket') ?  old('ticket') === 'OneWay' ? 'disabled' : '' : $flight->ticket === 'OneWay' ? 'disabled' : ''}}"
                                       data-toggle="tab" href="#m_tabs_5_6" id="tab_5_6">
                                        Coming (arabic)
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_tabs_5_1" role="tabpanel">
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4">
                                            <label>
                                                Commission Value:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <input type="text" name="commission" class="form-control m-input"
                                                       placeholder="Enter commission value"
                                                       value="{{ $flight->commission ? $flight->commission : old('commission') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>
                                                Commission Calculation:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <select name="is_percent" class="form-control m-input">
                                                    <option value="0" {{ old('is_percent') ? old('is_percent') == 0 ? 'selected' : '' : $flight->is_percent == 0 ? 'selected' : '' }}>Fixed amount</option>
                                                    <option value="1" {{ old('is_percent') ? old('is_percent') == 1 ? 'selected' : '' : $flight->is_percent == 1 ? 'selected' : '' }}>Percentage</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">

                                        <div class="col-lg-3">
                                            <label>
                                                Cancel before departure?
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-star"></i>
                                                </span>
                                                <select name="cancellation_before_departure" class="form-control m-input">
                                                    <option value="1" {{ old('cancellation_before_departure') ? old('cancellation_before_departure') === '1' ? 'selected' : '' : $flight->cancellation_before_departure === '1' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                    <option value="0" {{ old('cancellation_before_departure') ? old('cancellation_before_departure') === '0' ? 'selected' : '' : $flight->cancellation_before_departure === '0' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- <span class="m-form__help">
                                                Please select yes if you want to show this flight in best offer section
                                            </span> -->
                                        </div>

                                        <div class="col-lg-3">
                                            <label>
                                                Cancel before departure price
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </span>                                                
                                                <input type="number" name="cancellation_before_departure_price" class="form-control m-input"
                                                       placeholder="Cancel before departure price"
                                                       value="{{ isset($flight->cancellation_before_departure_price) ? $flight->cancellation_before_departure_price : old('cancellation_before_departure_price') }}">
                                            </div>
                                                <span class="m-form__help">
                                                Cancel before departure price
                                                </span>
                                        </div>

                                        <div class="col-lg-3">
                                            <label>
                                                Cancel after departure?
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-star"></i>
                                                </span>
                                                <select name="cancellation_after_departure" class="form-control m-input">
                                                    <option value="1" {{ old('cancellation_after_departure') ? old('cancellation_after_departure') === '1' ? 'selected' : '' : $flight->cancellation_after_departure === '1' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                    <option value="0" {{ old('cancellation_after_departure') ? old('cancellation_after_departure') === '0' ? 'selected' : '' : $flight->cancellation_after_departure === '0' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- <span class="m-form__help">
                                                Please select yes if you want to show this flight in best offer section
                                            </span> -->
                                        </div>

                                        <div class="col-lg-3">
                                            <label>
                                                Cancel after departure price
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </span>
                                                <input type="number" name="cancellation_after_departure_price" class="form-control m-input"
                                                       placeholder="Cancel after departure price"
                                                       value="{{ isset($flight->cancellation_after_departure_price) ? $flight->cancellation_after_departure_price : old('cancellation_after_departure_price') }}">
                                            </div>
                                           
                                                <span class="m-form__help">
                                                Cancel after departure price
                                                </span>
                                        </div>

                                        <div class="col-lg-3">
                                            <label>
                                                absence?
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-star"></i>
                                                </span>
                                                <select name="absence" class="form-control m-input">
                                                    <option value="1" {{ old('absence') ? old('absence') === '1' ? 'selected' : '' : $flight->absence === '1' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                    <option value="0" {{ old('absence') ? old('absence') === '0' ? 'selected' : '' : $flight->absence === '0' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- <span class="m-form__help">
                                                Please select yes if you want to show this flight in best offer section
                                            </span> -->
                                        </div>

                                        <div class="col-lg-3">
                                            <label>
                                                absence price
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </span>
                                                <input type="number" name="absence_price" class="form-control m-input"
                                                       placeholder="absence price"
                                                       value="{{ isset($flight->absence_price) ? $flight->absence_price : old('absence_price') }}">
                                            </div>
                                           
                                                <span class="m-form__help">
                                                absence price
                                                </span>
                                        </div>

                                        <div class="col-lg-3">
                                            <label>
                                                Change before departure?
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-star"></i>
                                                </span>
                                                <select name="change_before_departure" class="form-control m-input">
                                                    <option value="1" {{ old('change_before_departure') ? old('change_before_departure') === '1' ? 'selected' : '' : $flight->change_before_departure === '1' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                    <option value="0" {{ old('change_before_departure') ? old('change_before_departure') === '0' ? 'selected' : '' : $flight->change_before_departure === '0' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- <span class="m-form__help">
                                                Please select yes if you want to show this flight in best offer section
                                            </span> -->
                                        </div>

                                        <div class="col-lg-3">
                                            <label>
                                                Change before departure price
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </span>
                                                <input type="number" name="change_before_departure_price" class="form-control m-input"
                                                       placeholder="Change before departure price"
                                                       value="{{ isset($flight->change_before_departure_price) ? $flight->change_before_departure_price : old('change_before_departure_price') }}">
                                            </div>
                                           
                                                <span class="m-form__help">
                                                Change before departure price
                                                </span>
                                        </div>

                                        <div class="col-lg-6">
                                            <label>
                                                Change after departure?
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-star"></i>
                                                </span>
                                                <select name="change_after_departure" class="form-control m-input">
                                                    <option value="1" {{ old('change_after_departure') ? old('change_after_departure') === '1' ? 'selected' : '' : $flight->change_after_departure === '1' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                    <option value="0" {{ old('change_after_departure') ? old('change_after_departure') === '0' ? 'selected' : '' : $flight->change_after_departure === '0' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- <span class="m-form__help">
                                                Please select yes if you want to show this flight in best offer section
                                            </span> -->
                                        </div>

                                        <div class="col-lg-6">
                                            <label>
                                                Change after departure price
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </span>
                                                <input type="number" name="change_after_departure_price" class="form-control m-input"
                                                       placeholder="Change after departure price"
                                                       value="{{ isset($flight->change_after_departure_price) ? $flight->change_after_departure_price : old('change_after_departure_price') }}">
                                            </div>
                                           
                                                <span class="m-form__help">
                                                Change after departure price
                                                </span>
                                        </div>




                                        <div class="col-lg-4">
                                            <label>
                                                Flight Name:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </span>
                                                <input type="text" name="name[en]" class="form-control m-input"
                                                       placeholder="Enter flight name"
                                                       value="{{ $flight->name['en'] ? $flight->name['en'] : old('name.en') }}">
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
                                        <div class="col-lg-4">
                                            <label>
                                                Price (Adult):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="la la-dollar"></i>
                                    </span>
                                                <input type="text" name="price[adult]" class="form-control m-input"
                                                       placeholder="Enter flight price for adult"
                                                       value="{{ $flight->price['adult'] ? $flight->price['adult'] : old('price.adult') }}">
                                            </div>
                                            @if(isset($errors->messages()['price.adult']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['price.adult'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter your flight price for adult
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>
                                                Price (Children):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="la la-dollar"></i>
                                    </span>
                                                <input type="text" name="price[children]" class="form-control m-input"
                                                       placeholder="Enter flight price for children"
                                                       value="{{ $flight->price['children'] ? $flight->price['children'] : old('price.children') }}">
                                            </div>
                                            @if(isset($errors->messages()['price.children']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['price.children'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter your flight price for children
                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4">
                                            <label>
                                                Price (baby):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="la la-dollar"></i>
                                    </span>
                                                <input type="text" name="price[baby]" class="form-control m-input"
                                                       placeholder="Enter flight price for baby"
                                                       value="{{ $flight->price['baby'] ? $flight->price['baby'] : old('price.baby') }}">
                                            </div>
                                            @if(isset($errors->messages()['price.baby']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['price.baby'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter your flight price for baby
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>
                                                Show in best offer section ?
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-star"></i>
                                                </span>
                                                <select name="best_offer" class="form-control m-input">
                                                    <option value="1" {{ old('best_offer') ? old('best_offer') === '1' ? 'selected' : '' : $flight->best_offer === '1' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                    <option value="0" {{ old('best_offer') ? old('best_offer') === '0' ? 'selected' : '' : $flight->best_offer === '0' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                </select>
                                            </div>
                                            <span class="m-form__help">
                                                Please select yes if you want to show this flight in best offer section
                                            </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>
                                                Ticket:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-ticket"></i>
                                    </span>
                                                <select name="ticket" class="form-control m-input" id="ticket"
                                                        data-ticket="{{ $flight->ticket }}"
                                                        data-url="{{ route('showFlight',['flight' => $flight->id]) }}">
                                                    <option value="RoundTrip" {{ old('ticket') ? old('ticket') === 'RoundTrip' ? 'selected' : '' : $flight->ticket === 'RoundTrip' ? 'selected' : '' }}>
                                                        Round Trip
                                                    </option>
                                                    <option value="OneWay" {{ old('ticket') ? old('ticket') === 'OneWay' ? 'selected' : '' : $flight->ticket === 'OneWay' ? 'selected' : '' }}>
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
                                                       value="{{  $flight->aircraft_operator['en'] ? $flight->aircraft_operator['en'] : old('aircraft_operator.en') }}">
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
                                                       value="{{ $flight->airplane_type['en'] ? $flight->airplane_type['en'] : old('airplane_type.en') }}">
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
                                                       placeholder="Enter flight class"
                                                       value="{{ $flight->class['en'] ? $flight->class['en'] : old('class.en') }}">
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
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Seats Type:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="seat_type[en]" class="form-control m-input"
                                                       placeholder="Enter flight seats type"
                                                       value="{{ $flight->seat_type['en'] ? $flight->seat_type['en'] : old('seat_type.en') }}">
                                            </div>
                                            @if(isset($errors->messages()['seat_type.en']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['seat_type.en'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight seats type
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Electric Port:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="electric_port[en]" class="form-control m-input"
                                                       placeholder="Enter flight electric port"
                                                       value="{{ $flight->electric_port['en'] ? $flight->electric_port['en'] : old('electric_port.en') }}">
                                            </div>
                                            @if(isset($errors->messages()['electric_port.en']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['electric_port.en'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight electric port
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Display:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="display[en]" class="form-control m-input"
                                                       placeholder="Enter flight displays"
                                                       value="{{ $flight->display['en'] ? $flight->display['en'] : old('display.en') }}">
                                            </div>
                                            @if(isset($errors->messages()['display.en']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['display.en'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight displays
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
                                                <select class="form-control m-select2 going_from_country"
                                                        id="m_select2_1"
                                                        name="trip_information[common][going][from_country]">
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}"
                                                                {{ $flight->trip_information['common']['going']['from_country'] == $country->id ? 'selected' : ''}}
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

                                                <select class="form-control m-select2 going_to_country" id="m_select2_1"
                                                        name="trip_information[common][going][to_country]">
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}"
                                                                {{ $flight->trip_information['common']['going']['to_country'] == $country->id ? 'selected' : ''}}
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
                                        <div class="col-lg-3">
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
                                        <div class="col-lg-1">
                                            <img src="{{ Storage::url($flight->aircraft_logo) }}"
                                                 class="thumbnail-image">
                                        </div>
                                        <div class="col-lg-3">
                                            <label>
                                                Thumb:
                                            </label>
                                            <div class="m-input-icon m-input-icon--right">
                                                <input type="file" name="thumb" class="form-control m-input">
                                            </div>
                                            @if(isset($errors->messages()['thumb']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['thumb'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please select your flight thumb.
                                </span>
                                        </div>
                                        <div class="col-lg-1">
                                            <img src="{{ Storage::url($flight->thumb) }}" class="thumbnail-image">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>
                                                Stop ability ?
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-star"></i>
                                                </span>
                                                <select name="stop" class="form-control m-input">
                                                    <option value="1" {{ old('stop') ? old('stop') === '1' ? 'selected' : '' : $flight->stop === '1' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                    <option value="0" {{ old('stop') ? old('stop') === '0' ? 'selected' : '' : $flight->stop === '0' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                </select>
                                            </div>
                                            <span class="m-form__help">
                                                Please select yes if you want to show this flight in best offer section
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="m_tabs_5_2" role="tabpanel">
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-12">
                                            <label>
                                                Flight Name:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                                <input type="text" name="name[ar]" class="form-control m-input"
                                                       placeholder="Enter flight name"
                                                       value="{{ $flight->name['ar'] ? $flight->name['ar'] : old('name.ar') }}">
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
                                                <input type="text" name="aircraft_operator[ar]"
                                                       class="form-control m-input"
                                                       placeholder="Enter flight aircraft operator"
                                                       value="{{ $flight->aircraft_operator['ar'] ? $flight->aircraft_operator['ar'] : old('aircraft_operator.ar') }}">
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
                                                       value="{{ $flight->airplane_type['ar'] ? $flight->airplane_type['ar'] : old('airplane_type.ar') }}">
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
                                                       placeholder="Enter flight class"
                                                       value="{{ $flight->class['ar'] ? $flight->class['ar'] : old('class.ar') }}">
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
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Seats Type:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="seat_type[ar]" class="form-control m-input"
                                                       placeholder="Enter flight seats type"
                                                       value="{{ $flight->seat_type['ar'] ? $flight->seat_type['ar'] : old('seat_type.ar') }}">
                                            </div>
                                            @if(isset($errors->messages()['seat_type.ar']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['seat_type.ar'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight seats type
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Electric Port:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="electric_port[ar]" class="form-control m-input"
                                                       placeholder="Enter flight electric port"
                                                       value="{{ $flight->electric_port['ar'] ? $flight->electric_port['ar'] : old('electric_port.ar') }}">
                                            </div>
                                            @if(isset($errors->messages()['electric_port.ar']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['electric_port.ar'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight electric port
                                </span>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="">
                                                Display:
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="display[ar]" class="form-control m-input"
                                                       placeholder="Enter flight displays"
                                                       value="{{ $flight->display['ar'] ? $flight->display['ar'] : old('display.ar') }}">
                                            </div>
                                            @if(isset($errors->messages()['display.ar']))
                                                <div class="form-control-feedback" style="color: #f4516c;">
                                                    {{  $errors->messages()['display.ar'][0] }}
                                                </div>
                                            @endif
                                            <span class="m-form__help">
                                    Please enter flight displays
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
                                                <input type="datetime-local" class="form-control m-input"
                                                       name="trip_information[common][going][start_date]"
                                                       placeholder="Enter your flight start date (going)"
                                                       value="{{ $flight->trip_information['common']['going']['start_date'] ?  $flight->trip_information['common']['going']['start_date'] : old('trip_information.en.going.start_date') }}">

                                                <!-- <input type="datetime-local" class="form-control m-input"
                                                       name="trip_information[common][going][start_date]"
                                                       placeholder="Enter your flight start date (going)"
                                                       value="{{ $flight->trip_information['common']['going']['start_date'] ? \Carbon\Carbon::parse($flight->trip_information['common']['going']['start_date']): old('trip_information.en.going.start_date') }}"> -->
                                                              
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
                                                <input type="datetime-local" class="form-control m-input"
                                                       name="trip_information[common][going][end_date]"
                                                       placeholder="Enter your flight end date (going)"
                                                       value="{{ $flight->trip_information['common']['going']['end_date'] ? $flight->trip_information['common']['going']['end_date'] : old('trip_information.common.going.end_date') }}">

                                                       <!-- <input type="datetime-local" class="form-control m-input"
                                                       name="trip_information[common][going][end_date]"
                                                       placeholder="Enter your flight end date (going)"
                                                       value="{{ $flight->trip_information['common']['going']['end_date'] ? \Carbon\Carbon::parse($flight->trip_information['common']['going']['end_date'])->format('Y-m-d') : old('trip_information.common.going.end_date') }}"> -->
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
                                                       value="{{ $flight->trip_information['en']['going']['from_airport'] ? $flight->trip_information['en']['going']['from_airport'] : old('trip_information.en.going.from_airport') }}">
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
                                                       value="{{ $flight->trip_information['en']['going']['to_airport'] ? $flight->trip_information['en']['going']['to_airport'] : old('trip_information.en.going.to_airport') }}">
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
                                                       value="{{ $flight->trip_information['en']['going']['from_city'] ? $flight->trip_information['en']['going']['from_city'] : old('trip_information.en.going.from_city') }}">
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
                                                       value="{{ $flight->trip_information['en']['going']['to_city'] ? $flight->trip_information['en']['going']['to_city'] : old('trip_information.en.going.to_city') }}">
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
                                                       value="{{ $flight->trip_information['en']['going']['from_lounge'] ? $flight->trip_information['en']['going']['from_lounge'] : old('trip_information.en.going.from_lounge') }}">
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
                                                       value="{{ $flight->trip_information['en']['going']['to_lounge'] ? $flight->trip_information['en']['going']['to_lounge'] : old('trip_information.en.going.to_lounge') }}">
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
                                                       value="{{ $flight->trip_information['ar']['going']['from_airport'] ? $flight->trip_information['ar']['going']['from_airport'] : old('trip_information.ar.going.from_airport') }}">
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
                                                       value="{{ $flight->trip_information['ar']['going']['to_airport'] ? $flight->trip_information['ar']['going']['to_airport'] : old('trip_information.ar.going.to_airport') }}">
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
                                                       value="{{ $flight->trip_information['ar']['going']['from_city'] ? $flight->trip_information['ar']['going']['from_city'] : old('trip_information.ar.going.from_city') }}">
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
                                                       value="{{ $flight->trip_information['ar']['going']['to_city'] ? $flight->trip_information['ar']['going']['to_city'] : old('trip_information.ar.going.to_city') }}">
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
                                                       value="{{ $flight->trip_information['ar']['going']['from_lounge'] ? $flight->trip_information['ar']['going']['from_lounge'] : old('trip_information.ar.going.from_lounge') }}">
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
                                                       value="{{ $flight->trip_information['ar']['going']['to_lounge'] ? $flight->trip_information['ar']['going']['to_lounge'] : old('trip_information.ar.going.to_lounge') }}">
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
                                    <div class="form-group m-form__group row coming-section {{ old('ticket') ? old('ticket') === 'OneWay' ? 'm--hide' : '' : $flight->ticket === 'OneWay' ? 'm--hide' : ''}}">
                                        <div class="col-lg-6">
                                            <label class="">
                                                Coming (Start Date):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                                <input type="datetime-local" class="form-control m-input coming-input"
                                                       id="coming_start_date_en"
                                                       name="trip_information[common][coming][start_date]"
                                                       placeholder="Enter your flight start date (coming)"
                                                       value="{{ $flight->trip_information['common']['coming']['start_date'] ? $flight->trip_information['common']['coming']['start_date'] : old('trip_information.common.coming.start_date') }}">
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
                                                <input type="datetime-local" class="form-control m-input coming-input"
                                                       id="coming_end_date_en"
                                                       name="trip_information[common][coming][end_date]"
                                                       placeholder="Enter flight end date (coming)"
                                                       value="{{ $flight->trip_information['common']['coming']['end_date'] ? $flight->trip_information['common']['coming']['end_date'] : old('trip_information.common.coming.end_date') }}">
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
                                    <div class="form-group m-form__group row coming-section {{ old('ticket') ? old('ticket') === 'OneWay' ? 'm--hide' : '' : $flight->ticket === 'OneWay' ? 'm--hide' : ''}}">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (from airport):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][coming][from_airport]"
                                                       id="coming_from_airport_en"
                                                       class="form-control m-input coming-input"
                                                       placeholder="Enter flight from airport (coming)"
                                                       value="{{ $flight->trip_information['en']['coming']['from_airport'] ? $flight->trip_information['en']['coming']['from_airport'] : old('trip_information.en.coming.from_airport') }}">
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
                                                       id="coming_to_airport_en"
                                                       class="form-control m-input coming-input"
                                                       placeholder="Enter flight to airport (coming)"
                                                       value="{{ $flight->trip_information['en']['coming']['to_airport'] ? $flight->trip_information['en']['coming']['to_airport'] : old('trip_information.en.coming.to_airport') }}">
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
                                                       id="coming_from_city_en"
                                                       class="form-control m-input coming-input"
                                                       placeholder="Enter flight airport's city (coming)"
                                                       value="{{ $flight->trip_information['en']['coming']['from_city'] ? $flight->trip_information['en']['coming']['from_city'] : old('trip_information.en.coming.from_city') }}">
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
                                    <div class="form-group m-form__group row coming-section {{ old('ticket') ? old('ticket') === 'OneWay' ? 'm--hide' : '' : $flight->ticket === 'OneWay' ? 'm--hide' : ''}}">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (to city):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                                <input type="text" name="trip_information[en][coming][to_city]"
                                                       id="coming_to_city_en"
                                                       class="form-control m-input coming-input"
                                                       placeholder="Enter flight airport's city (coming)"
                                                       value="{{ $flight->trip_information['en']['coming']['to_city'] ? $flight->trip_information['en']['coming']['to_city'] : old('trip_information.en.coming.to_city') }}">
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
                                                       id="coming_from_lounge_en"
                                                       class="form-control m-input coming-input"
                                                       placeholder="Enter flight airport's from lounge (coming)"
                                                       value="{{ $flight->trip_information['en']['coming']['from_lounge'] ? $flight->trip_information['en']['coming']['from_lounge'] : old('trip_information.en.coming.from_lounge') }}">
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
                                                       id="coming_to_lounge_en"
                                                       class="form-control m-input coming-input"
                                                       placeholder="Enter flight airport's to lounge (coming)"
                                                       value="{{ $flight->trip_information['en']['coming']['to_lounge'] ? $flight->trip_information['en']['coming']['to_lounge'] : old('trip_information.en.coming.to_lounge') }}">
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
                                    <div class="form-group m-form__group row coming-section {{ old('ticket') ? old('ticket') === 'OneWay' ? 'm--hide' : '' : $flight->ticket === 'OneWay' ? 'm--hide' : ''}}">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (from airport):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][coming][from_airport]"
                                                       id="coming_from_airport_ar"
                                                       class="form-control m-input coming-input"
                                                       placeholder="Enter flight from airport (coming)"
                                                       value="{{ $flight->trip_information['ar']['coming']['from_airport'] ? $flight->trip_information['ar']['coming']['from_airport'] : old('trip_information.ar.coming.from_airport') }}">
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
                                                       id="coming_to_airport_ar"
                                                       class="form-control m-input coming-input"
                                                       placeholder="Enter flight to airport (coming)"
                                                       value="{{ $flight->trip_information['ar']['coming']['to_airport'] ? $flight->trip_information['ar']['coming']['to_airport'] : old('trip_information.ar.coming.to_airport') }}">
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
                                                       id="coming_from_city_ar"
                                                       class="form-control m-input coming-input"
                                                       placeholder="Enter flight airport's city (coming)"
                                                       value="{{ $flight->trip_information['ar']['coming']['from_city'] ? $flight->trip_information['ar']['coming']['from_city'] : old('trip_information.ar.coming.from_city') }}">
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
                                    <div class="form-group m-form__group row coming-section {{ old('ticket') ? old('ticket') === 'OneWay' ? 'm--hide' : '' : $flight->ticket === 'OneWay' ? 'm--hide' : ''}}">
                                        <div class="col-lg-4">
                                            <label class="">
                                                Coming (to city):
                                            </label>
                                            <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                                <input type="text" name="trip_information[ar][coming][to_city]"
                                                       id="coming_to_city_ar"
                                                       class="form-control m-input coming-input"
                                                       placeholder="Enter flight airport's city (coming)"
                                                       value="{{ $flight->trip_information['ar']['coming']['to_city'] ? $flight->trip_information['ar']['coming']['to_city'] : old('trip_information.ar.coming.to_city') }}">
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
                                                       id="coming_from_lounge_ar"
                                                       class="form-control m-input coming-input"
                                                       placeholder="Enter flight airport's from lounge (coming)"
                                                       value="{{ $flight->trip_information['ar']['coming']['from_lounge'] ? $flight->trip_information['ar']['coming']['from_lounge'] : old('trip_information.ar.coming.from_lounge') }}">
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
                                                       id="coming_to_lounge_ar"
                                                       class="form-control m-input coming-input"
                                                       placeholder="Enter flight airport's to lounge (coming)"
                                                       value="{{ $flight->trip_information['ar']['coming']['to_lounge'] ? $flight->trip_information['ar']['coming']['to_lounge'] : old('trip_information.ar.coming.to_lounge') }}">
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
                                        Save Changes
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
                $('.coming-section').removeClass('m--hide');
                $('#tab_5_5').removeClass('disabled');
                $('#tab_5_6').removeClass('disabled');
                if ($(this).data('ticket') === 'RoundTrip') {
                    $.get($(this).data('url'), function (data) {
                        $('#coming_start_date_en').val(data.flight.trip_information.common.coming.start_date);
                        $('#coming_end_date_en').val(data.flight.trip_information.common.coming.end_date);
                        $('.going_from_country').val(data.flight.trip_information.common.going.from_country);
                        $('.going_to_country').val(data.flight.trip_information.common.going.to_country);
                        $('#coming_from_airport_en').val(data.flight.trip_information.en.coming.from_airport);
                        $('#coming_to_airport_en').val(data.flight.trip_information.en.coming.to_airport);
                        $('#coming_from_airport_ar').val(data.flight.trip_information.ar.coming.from_airport);
                        $('#coming_to_airport_ar').val(data.flight.trip_information.ar.coming.to_airport);
                        $('#coming_from_city_en').val(data.flight.trip_information.en.coming.from_city);
                        $('#coming_to_city_en').val(data.flight.trip_information.en.coming.to_city);
                        $('#coming_from_city_ar').val(data.flight.trip_information.ar.coming.from_city);
                        $('#coming_to_city_ar').val(data.flight.trip_information.ar.coming.to_city);
                        $('#coming_from_lounge_en').val(data.flight.trip_information.en.coming.from_lounge);
                        $('#coming_to_lounge_en').val(data.flight.trip_information.en.coming.to_lounge);
                        $('#coming_from_lounge_ar').val(data.flight.trip_information.ar.coming.from_lounge);
                        $('#coming_to_lounge_ar').val(data.flight.trip_information.ar.coming.to_lounge);
                    });
                }
            } else if ($(this).val() === 'OneWay') {
                $('.coming-section').addClass('m--hide');
                $('.coming-input').val("");
                $('#tab_5_5').addClass('disabled');
                $('#tab_5_6').addClass('disabled');
            }
        });
    </script>
@endsection
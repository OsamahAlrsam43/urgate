@extends('layouts.master')

@section('page-title')
    Travels
@endsection

@section('sub-header')
    Travels- Update
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
                                Travel Details.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('updateTravel',['travel' => $travel->id]) }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <ul class="nav nav-pills nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#m_tabs_5_7">
                                    General
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#m_tabs_5_2">
                                    Pricing
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane active" id="m_tabs_5_7" role="tabpanel">
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4">
                                        <label>
                                            Travel Name (En):
                                        </label>
                                        <input type="text" name="name[en]" class="form-control m-input"
                                               placeholder="Enter travel name"
                                               value="{{ $travel->name['en'] ? $travel->name['en'] : old('name.en') }}">
                                        @if(isset($errors->messages()['name.en']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['name.en'][0] }}
                                            </div>
                                        @endif
                                        <span class="m-form__help">
                                    Please enter travel name in english
                                </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            Travel Name (Ar):
                                        </label>
                                        <input type="text" name="name[ar]" class="form-control m-input"
                                               placeholder="Enter travel name"
                                               value="{{ $travel->name['ar'] ? $travel->name['ar'] : old('name.ar') }}">
                                        @if(isset($errors->messages()['name.ar']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['name.ar'][0] }}
                                            </div>
                                        @endif
                                        <span class="m-form__help">
                                    Please enter travel name in english
                                </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4">
                                        <label>
                                            Commission Value:
                                        </label>
                                        <div class="input-group m-input-group m-input-group--square">
                                            <input type="text" name="commission" class="form-control m-input"
                                                   placeholder="Enter commission value"
                                                   value="{{ $travel->commission ? $travel->commission : old('commission') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            Commission Calculation:
                                        </label>
                                        <div class="input-group m-input-group m-input-group--square">
                                            <select name="is_percent" class="form-control m-input">
                                                <option value="0" {{ old('is_percent') ? old('is_percent') == 0 ? 'selected' : '' : $travel->is_percent == 0 ? 'selected' : '' }}>
                                                    Fixed amount
                                                </option>
                                                <option value="1" {{ old('is_percent') ? old('is_percent') == 1 ? 'selected' : '' : $travel->is_percent == 1 ? 'selected' : '' }}>
                                                    Percentage
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="">
                                            Start Date:
                                        </label>
                                        <input type="date" class="form-control m-input" name="from_date"
                                               value="{{ $travel->from_date ? $travel->from_date->format('Y-m-d') : old('from_date') }}">
                                        @if(isset($errors->messages()['from_date']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['from_date'][0] }}
                                            </div>
                                        @endif
                                        <span class="m-form__help">
                                    Please enter your travel start date
                                </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="">
                                            Start Time:
                                        </label>
                                        <input type="text" class="form-control m-input" name="from_time"
                                               value="{{ $travel->from_time ? $travel->from_time : old('from_time') }}">
                                        <span class="m-form__help">
                                    Please enter your travel start time
                                </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4">
                                        <label class="">
                                            End Date:
                                        </label>
                                        <input type="date" class="form-control m-input" name="to_date"
                                               value="{{ $travel->to_date ? $travel->to_date->format('Y-m-d') : old('to_date') }}">
                                        @if(isset($errors->messages()['to_date']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['to_date'][0] }}
                                            </div>
                                        @endif
                                        <span class="m-form__help">
                                    Please enter your travel end date
                                </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            Period:
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <input type="text" name="period[en]" class="form-control m-input"
                                                   placeholder="For example, 5 days,4 nights"
                                                   value="{{ $travel->period['en'] ? $travel->period['en'] : old('period.en') }}">
                                        </div>
                                        @if(isset($errors->messages()['period.en']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['period.en'][0] }}
                                            </div>
                                        @endif
                                        <span class="m-form__help">
                                    Please enter your travel period.
                                </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            Period (Ar):
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <input type="text" name="period[ar]" class="form-control m-input"
                                                   placeholder="For example, 5 days,4 nights"
                                                   value="{{ $travel->period['ar'] ? $travel->period['ar'] : old('period.ar') }}">
                                        </div>
                                        @if(isset($errors->messages()['period.ar']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['period.ar'][0] }}
                                            </div>
                                        @endif
                                        <span class="m-form__help">
                                    Please enter your travel period.
                                </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4">
                                        <label>
                                            From (Country Or City):
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <select class="form-control m-select2" id="m_select2_1" name="from_country">
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                            {{ $travel->from_country == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name['en'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                        <span>
                                            <i class="la la-map-marker"></i>
                                        </span>
                                    </span>
                                        </div>
                                        @if(isset($errors->messages()['from_country.en']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['from_country.en'][0] }}
                                            </div>
                                        @endif
                                        <span class="m-form__help">
                                    Please enter Country Or City.
                                </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            To (Country Or City):
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <select class="form-control m-select2" id="m_select2_1" name="to_country">
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                            {{ $travel->to_country == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name['en'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                        <span>
                                            <i class="la la-map-marker"></i>
                                        </span>
                                    </span>
                                        </div>
                                        @if(isset($errors->messages()['to_country.en']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['to_country.en'][0] }}
                                            </div>
                                        @endif
                                        <span class="m-form__help">
                                    Please enter Country Or City.
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
                                                   value="{{ $travel->flight_number ? $travel->flight_number : old('flight_number') }}">
                                        </div>
                                        <span class="m-form__help">
                                    Please enter flight number
                                </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="">
                                            Aircraft Operator:
                                        </label>
                                        <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="fa fa-plane"></i>
                                    </span>
                                            <input type="text" name="aircraft_operator"
                                                   class="form-control m-input"
                                                   placeholder="Enter flight aircraft operator"
                                                   value="{{  $travel->aircraft_operator ? $travel->aircraft_operator : old('aircraft_operator') }}">
                                        </div>
                                        <span class="m-form__help">
                                    Please enter flight aircraft operator
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
                                            <input type="text" name="class" class="form-control m-input"
                                                   placeholder="Enter flight class"
                                                   value="{{ $travel->class ? $travel->class : old('class') }}">
                                        </div>
                                        <span class="m-form__help">
                                    Please enter flight class
                                </span>
                                    </div>
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
                                        <img src="{{ Storage::url("app/public/".$travel->aircraft_logo) }}"
                                             class="thumbnail-image">
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
                                                <option value="1" {{ old('best_offer') ? old('best_offer') === '1' ? 'selected' : '' : $travel->best_offer === '1' ? 'selected' : '' }}>
                                                    Yes
                                                </option>
                                                <option value="0" {{ old('best_offer') ? old('best_offer') === '0' ? 'selected' : '' : $travel->best_offer === '0' ? 'selected' : '' }}>
                                                    No
                                                </option>
                                            </select>
                                        </div>
                                        <span class="m-form__help">
                                                Please select yes if you want to show this travel in best offer section
                                            </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-11">
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
                                    Please select your travel thumb.
                                </span>
                                    </div>
                                    <div class="col-lg-1">
                                        <img src="{{ Storage::url($travel->thumb) }}" class="thumbnail-image">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12">
                                        <label>
                                            Gallery:
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <input type="file" name="images[]" class="form-control m-input" multiple>
                                        </div>
                                        @if(isset($errors->messages()['images']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['images'][0] }}
                                            </div>
                                        @endif
                                        <span class="m-form__help">
                                    Please enter Travel Gallery.
                                </span>
                                    </div>
                                    <div class="col-lg-12">
                                        <ul class="gallery-container">
                                            @foreach($travel->images as $image)
                                                <li id="image-{{ $image->id }}" style="display: inline;">
                                                    <img src="{{ Storage::url($image->image) }}" class="gallery-image">
                                                    <img src="{{ asset('custom/images/error.png') }}"
                                                         data-toggle="modal" data-target="#m_modal_1"
                                                         class="remove-modal x-icon"
                                                         data-url="{{ route('deleteImage',['image' => $image->id]) }}">
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-6">
                                        <label>
                                            Program:
                                        </label>
                                        <textarea name="description[en]" class="ckeditor form-control m-input"
                                                  placeholder="Enter your travel program">{{ $travel->description['en'] ? $travel->description['en'] : old('description.en') }}</textarea>
                                        @if(isset($errors->messages()['description.en']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['description.en'][0] }}
                                            </div>
                                        @endif
                                        <span class="m-form__help">
                                    Please enter travel Program.
                                </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>
                                            Program (Ar):
                                        </label>
                                        <textarea name="description[ar]" class="ckeditor form-control m-input"
                                                  placeholder="Enter your travel program">{{ $travel->description['ar'] ? $travel->description['ar'] :old('description.ar') }}</textarea>
                                        @if(isset($errors->messages()['description.ar']))
                                            <div class="form-control-feedback" style="color: #f4516c;">
                                                {{  $errors->messages()['description.ar'][0] }}
                                            </div>
                                        @endif
                                        <span class="m-form__help">
                                    Please enter travel Program.
                                </span>
                                    </div>
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
                                                  placeholder="Enter flight instructions">{{ $travel->instructions ? $travel->instructions : old('instructions') }}</textarea>
                                    </div>
                                    <span class="m-form__help">
                                    Please enter flight instructions
                                </span>
                                </div>
                            </div>

                            <div class="tab-pane" id="m_tabs_5_2" role="tabpanel">
                                <div id="pricing-form-repeater">
                                    <div data-repeater-list="price">
										<?php
										$price = $travel->price;
										$classes = [
											"أحادية",
											"ثنائية",
											"ثلاثية",
										];
										?>
                                        @foreach($classes as $class=>$title)
                                            <div class="form-group row m--padding-bottom-10"
                                                 style="margin-right: 15px;margin-left: 15px;border-bottom: 1px solid #dfdfdf;"
                                                 data-repeater-item>
                                                <div class="col-lg-2">
                                                    <label>Seats</label>
                                                    <input type="number" name="seats" class="form-control m-input"
                                                           value="{{isset($price[$class]['seats']) ? $price[$class]['seats'] : ''}}">
                                                    <input type="hidden" name="reserved_seats"
                                                           value="{{isset($price[$class]['reserved_seats']) ? $price[$class]['reserved_seats'] : 0}}">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Price [Adult]</label>
                                                    <input type="text" name="adult"
                                                           class="form-control m-input"
                                                           placeholder="Price for adult"
                                                           value="{{isset($price[$class]['adult'])? $price[$class]['adult'] : ''}}">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Price [Children]</label>
                                                    <input type="text" name="children"
                                                           class="form-control m-input"
                                                           placeholder="Price for children"
                                                           value="{{isset($price[$class]['children']) ? $price[$class]['children'] : ''}}">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Price [Baby]</label>
                                                    <input type="text" name="baby" class="form-control m-input"
                                                           placeholder="Price for baby"
                                                           value="{{isset($price[$class]['baby']) ? $price[$class]['baby'] : ''}}">
                                                </div>
                                                <div class="col-lg-2">
                                                    <h3 style="margin-top: 30px;">{{$title}}</h3>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    {!! csrf_field() !!}
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-8">
                                    <button type="submit" class="btn btn-primary">
                                        Save Changes
                                    </button>
                                    <a href="{{ route('listTravels') }}" class="btn btn-secondary">
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

    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Delete Image
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure that you want to remove this image ?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-danger" id="delete" data-dismiss="modal">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

@endsection

@section('scripts')
    <script src="{{ asset('default-assets/demo/default/custom/components/forms/widgets/ckeditor/ckeditor.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('default-assets/demo/default/custom/components/forms/widgets/select2.js') }}"
            type="text/javascript"></script>
    <script>
        $(document).on('click', '.remove-modal', function () {
            $('#delete').val($(this).data('url'));
        });

        $("#delete").click(function () {
            $.get($(this).val(), function (data) {
                $('#image-' + data.image.id).remove();
            });
        });

        $('#pricing-form-repeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            isFirstItemUndeletable: true,

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    </script>
@endsection
@extends('layouts.master')

@section('page-title')
    Travels
@endsection

@section('sub-header')
    Travels- Create
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
                      action="{{ route('storeTravel') }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label>
                                    Travel Name (En):
                                </label>
                                <input type="text" name="name[en]" class="form-control m-input"
                                       placeholder="Enter travel name" value="{{ old('name.en') }}">
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
                                       placeholder="Enter travel name" value="{{ old('name.ar') }}">
                                @if(isset($errors->messages()['name.ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['name.ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter travel name in english
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
                                           placeholder="Enter travel price for adult"
                                           value="{{ old('price.adult') }}">
                                </div>
                                @if(isset($errors->messages()['price.adult']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['price.adult'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter your travel price for adult
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
                            <div class="col-lg-4">
                                <label>
                                    Price (Children):
                                </label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="la la-dollar"></i>
                                    </span>
                                    <input type="text" name="price[children]" class="form-control m-input"
                                           placeholder="Enter travel price for children"
                                           value="{{ old('price.children') }}">
                                </div>
                                @if(isset($errors->messages()['price.children']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['price.children'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter your travel price for children
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    Price (baby):
                                </label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="la la-dollar"></i>
                                    </span>
                                    <input type="text" name="price[baby]" class="form-control m-input"
                                           placeholder="Enter travel price for baby"
                                           value="{{ old('price.baby') }}">
                                </div>
                                @if(isset($errors->messages()['price.baby']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['price.baby'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter your travel price for baby
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label class="">
                                    Start Date:
                                </label>
                                <input type="date" class="form-control m-input" name="from_date"
                                       value="{{ old('from_date') }}">
                                @if(isset($errors->messages()['from_date']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['from_date'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter your travel start date
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label class="">
                                    End Date:
                                </label>
                                <input type="date" class="form-control m-input" name="to_date"
                                       value="{{ old('to_date') }}">
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
                                           placeholder="For example, 5 days,4 nights" value="{{ old('period.en') }}">
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
                                           placeholder="For example, 5 days,4 nights" value="{{ old('period.ar') }}">
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
                                            <option value="{{ $country->id }}">{{ $country->name['en'] }}</option>
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
                                            <option value="{{ $country->id }}">
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
                            <div class="col-lg-4">
                                <label>
                                    Show in best offer section ?
                                </label>
                                <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-star"></i>
                                                </span>
                                    <select name="best_offer" class="form-control m-input">
                                        <option value="1" {{ old('best_offer') === '1' ? 'selected' : '' }}>
                                            Yes
                                        </option>
                                        <option value="0" {{ old('best_offer') ? old('best_offer') === '0' ? 'selected' : '' : 'selected' }}>
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
                            <div class="col-lg-6">
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
                            <div class="col-lg-6">
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
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    Program:
                                </label>
                                <textarea name="description[en]" class="ckeditor form-control m-input"
                                          placeholder="Enter your travel program">{{ old('description.en') }}</textarea>
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
                                          placeholder="Enter your travel program">{{ old('description.ar') }}</textarea>
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
                    </div>
                    {!! csrf_field() !!}
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-8">
                                    <button type="submit" class="btn btn-primary">
                                        Add Travel
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

@endsection

@section('scripts')
    <script src="{{ asset('default-assets/demo/default/custom/components/forms/widgets/ckeditor/ckeditor.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('default-assets/demo/default/custom/components/forms/widgets/select2.js') }}"
            type="text/javascript"></script>

@endsection
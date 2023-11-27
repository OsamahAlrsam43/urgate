@extends('layouts.master')

@section('page-title')
    Visa
@endsection

@section('sub-header')
    Visa- Create
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
                                Visa Details.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('storeVisa') }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label>
                                    Name (En):
                                </label>
                                <input type="text" name="name[en]" class="form-control m-input"
                                       placeholder="Enter visa name" value="{{ old('name.en') }}">
                                @if(isset($errors->messages()['name.en']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['name.en'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter name in english
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    Name (Ar):
                                </label>
                                <input type="text" name="name[ar]" class="form-control m-input"
                                       placeholder="Enter visa name" value="{{ old('name.ar') }}">
                                @if(isset($errors->messages()['name.ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['name.ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter name in arabic
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    Price:
                                </label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="la la-dollar"></i>
                                    </span>
                                    <input type="text" name="price" class="form-control m-input"
                                           placeholder="Enter visa price" value="{{ old('price') }}">
                                </div>
                                @if(isset($errors->messages()['price']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['price'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter your visa price
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
                            <div class="col-lg-6">
                                <label>
                                    Type (En):
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="text" name="visa_type[en]" class="form-control m-input"
                                           placeholder="enter visa type." value="{{ old('visa_type.en') }}">
                                </div>
                                @if(isset($errors->messages()['visa_type.en']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['visa_type.en'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter visa type.
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    Type (Ar):
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="text" name="visa_type[ar]" class="form-control m-input"
                                           placeholder="enter visa type." value="{{ old('visa_type.ar') }}">
                                </div>
                                @if(isset($errors->messages()['visa_type.ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['visa_type.ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter visa type.
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    papers (En):
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="text" name="papers[en]" class="form-control m-input"
                                           placeholder="enter required papers" value="{{ old('papers.en') }}">
                                    <span class="m-input-icon__icon m-input-icon__icon--right">
                                        <span>
                                            <i class="la la-map-marker"></i>
                                        </span>
                                    </span>
                                </div>
                                @if(isset($errors->messages()['papers.en']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['papers.en'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter required papers.
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    papers (Ar):
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="text" name="papers[ar]" class="form-control m-input"
                                           placeholder="enter required papers" value="{{ old('papers.ar') }}">
                                    <span class="m-input-icon__icon m-input-icon__icon--right">
                                        <span>
                                            <i class="la la-map-marker"></i>
                                        </span>
                                    </span>
                                </div>
                                @if(isset($errors->messages()['papers.ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['papers.ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter required papers.
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-8">
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
                                    Please select your visa thumb.
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
                                    Please select yes if you want to show this visa in best offer section
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    Description:
                                </label>
                                <textarea name="description[en]" class="ckeditor form-control m-input"
                                          placeholder="Enter your visa description">{{ old('description.en') }}</textarea>
                                @if(isset($errors->messages()['description.en']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['description.en'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter visa description.
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    Description (Ar):
                                </label>
                                <textarea name="description[ar]" class="ckeditor form-control m-input"
                                          placeholder="Enter your visa description">{{ old('description.ar') }}</textarea>
                                @if(isset($errors->messages()['description.ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['description.ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter visa description.
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
                                        Add Visa
                                    </button>
                                    <a href="{{ route('listVisas') }}" class="btn btn-secondary">
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
@endsection
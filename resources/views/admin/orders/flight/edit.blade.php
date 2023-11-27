@extends('layouts.master')

@section('page-title')
    Orders-edit
@endsection

@section('sub-header')
    Flight
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
                                Flight Order Details.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('updateFlightOrder',['flight' => $flight->id,'order' => $order->id]) }}"
                      enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label>
                                    First Name:
                                </label>
                                <input type="text" name="first_name" class="form-control m-input"
                                       placeholder="Enter first name"
                                       value="{{ $order->first_name ? $order->first_name : old('first_name') }}">
                                @if(isset($errors->messages()['first_name']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['first_name'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter travel name
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    last Name:
                                </label>
                                <input type="text" name="last_name" class="form-control m-input"
                                       placeholder="Enter last name"
                                       value="{{ $order->last_name ? $order->last_name : old('last_name') }}">
                                @if(isset($errors->messages()['last_name']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['last_name'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter last name
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    birth place:
                                </label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="la la-dollar"></i>
                                    </span>
                                    <input type="text" name="birth_place" class="form-control m-input"
                                           placeholder="Enter birth place"
                                           value="{{ $order->birth_place ? $order->birth_place : old('birth_place') }}">
                                </div>
                                <span class="m-form__help">
                                    Please enter birth place
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label>
                                    birth date:
                                </label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="la la-dollar"></i>
                                    </span>
                                    <input type="date" name="birth_date" class="form-control m-input"
                                           value="{{ $order->birth_date ? $order->birth_date->format('Y-m-d') : old('birth_date') }}">
                                </div>
                                <span class="m-form__help">
                                    Please enter birth date
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    nationality:
                                </label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="la la-dollar"></i>
                                    </span>
                                    <input type="text" name="nationality" class="form-control m-input"
                                           placeholder="Enter nationality"
                                           value="{{ $order->nationality ? $order->nationality : old('nationality') }}">
                                </div>
                                <span class="m-form__help">
                                    Please enter nationality
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label class="">
                                    passport number:
                                </label>
                                <input type="text" class="form-control m-input" name="passport_number"
                                       value="{{ $order->passport_number ? $order->passport_number : old('passport_number') }}">
                                <span class="m-form__help">
                                    Please enter passport number
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label class="">
                                    passport issuance Date:
                                </label>
                                <input type="date" class="form-control m-input" name="passport_issuance_date"
                                       value="{{ $order->passport_issuance_date ? $order->passport_issuance_date->format('Y-m-d') : old('passport_issuance_date') }}">
                                <span class="m-form__help">
                                    Please enter passport issuance date
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label class="">
                                    passport expire Date:
                                </label>
                                <input type="date" class="form-control m-input" name="passport_expire_date"
                                       value="{{ $order->passport_expire_date ? $order->passport_expire_date->format('Y-m-d') : old('passport_expire_date') }}">

                                @if(isset($errors->messages()['passport_expire_date']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['passport_expire_date'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter passport expire date
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    father name:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="text" name="father_name" class="form-control m-input"
                                           placeholder="For example, 5 days,4 nights"
                                           value="{{ $order->father_name ? $order->father_name : old('father_name') }}">
                                </div>
                                <span class="m-form__help">
                                    Please enter father name.
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label>
                                    mother name:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="text" name="mother_name" class="form-control m-input"
                                           placeholder="For example, 5 days,4 nights"
                                           value="{{ $order->mother_name ? $order->mother_name : old('mother_name') }}">
                                </div>
                                <span class="m-form__help">
                                    Please enter mother name.
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    passport image:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <a target="_blank" href="{{ Storage::url($order->passport_image) }}"
                                       class="btn btn-primary">
                                        Passport Image
                                    </a>
                                </div>
                                <span class="m-form__help">
                                    View personal image.
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    personal image:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <a target="_blank" href="{{ Storage::url($order->personal_image) }}"
                                       class="btn btn-primary">
                                        Personal Image
                                    </a>
                                </div>
                                <span class="m-form__help">
                                    View personal image.
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-10">
                                <label>
                                    Pdf:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="file" name="pdf" class="form-control m-input">
                                </div>
                                @if(isset($errors->messages()['pdf']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['pdf'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please select pdf (if you want to update flight pdf).
                                </span>
                            </div>
                            <div class="col-lg-2">
                                <label>
                                    Flight pdf:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <a target="_blank" href="{{ route('flightDownloadPdf',['flight' => $order->id]) }}"
                                       class="btn btn-primary">
                                        Download
                                    </a>
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
                                    <a href="{{ route('flightOrders',['flight' => $flight->id]) }}"
                                       class="btn btn-secondary">
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

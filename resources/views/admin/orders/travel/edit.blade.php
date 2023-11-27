@extends('layouts.master')

@section('page-title')
    Orders-edit
@endsection

@section('sub-header')
    Travel
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
                                Travel Order Details.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('updateTravelOrder',['travel' => $travel->id,'order' => $order->id]) }}"
                      enctype="multipart/form-data">
                    <div class="m-portlet__body">
						<?php $index = 0; ?>
                        @foreach($order->passengers as $passenger)
                            <input type="hidden" name="id[]" value="{{$passenger->id}}">
                            <div class="form-group m-form__group row">
                                <div class="form-group col-lg-3 col-md-4 custom-form-group">
                                    <label for="inputEmail4">
                                        Title
                                        <b>*</b>
                                    </label>
                                    <!-- Start custom-input -->
                                    <div class="custom-input d-flex align-items-stretch">
                                        <!-- Start input-icon -->
                                        <div class="input-icon d-flex align-items-center">
                                            <i class="icons8-edit-file"></i>
                                        </div>
                                        <!-- End input-icon -->
                                        <select type="text" name="title[]" class="form-control">
                                            <option @if($passenger->title == __('charter.mr')) selected @endif>{{__('charter.mr')}}</option>
                                            <option @if($passenger->title == __('charter.mrs')) selected @endif>{{__('charter.mrs')}}</option>
                                            <option @if($passenger->title == "INF") selected @endif>INF</option>
                                        </select>
                                    </div>
                                    <!-- End custom-input -->
                                </div>
                                <div class="col-lg-4">
                                    <label>
                                        First Name:
                                    </label>
                                    <input type="text" name="first_name[]" class="form-control m-input"
                                           placeholder="Enter first name"
                                           value="{{ $passenger->first_name ? $passenger->first_name : old('first_name') }}">
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
                                    <input type="text" name="last_name[]" class="form-control m-input"
                                           placeholder="Enter last name"
                                           value="{{ $passenger->last_name ? $passenger->last_name : old('last_name') }}">
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
                                        birth date:
                                    </label>
                                    <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon">
                                        <i class="la la-dollar"></i>
                                    </span>
                                        <input type="date" name="birth_date[]" class="form-control m-input"
                                               value="{{ $passenger->birth_date ? $passenger->birth_date->format('Y-m-d') : old('birth_date') }}">
                                    </div>
                                    <span class="m-form__help">
                                    Please enter birth date
                                </span>
                                </div>
                                <div class="col-lg-4">
                                    <label>
                                        nationality:
                                    </label>
                                    <select class="form-control" name="nationality[]">
                                        <option></option>
                                        @foreach($nationalities as $country)
                                            <option value="{{ $country->id }}"
                                                    {{ ($country->id == 104 or old('nationality.'.$index) == $country->id) ? 'selected' : ''}}>{{ $country->name["en"] }}</option>
                                        @endforeach
                                    </select>
                                    <span class="m-form__help">
                                    Please enter nationality
                                </span>
                                </div>
                                <div class="col-lg-4">
                                    <label class="">
                                        passport number:
                                    </label>
                                    <input type="text" class="form-control m-input" name="passport_number[]"
                                           value="{{ $passenger->passport_number ? $passenger->passport_number : old('passport_number') }}">
                                    <span class="m-form__help">
                                    Please enter passport number
                                </span>
                                </div>
                                <div class="col-lg-4">
                                    <label class="">
                                        passport expire Date:
                                    </label>
                                    <input type="date" class="form-control m-input" name="passport_expire_date[]"
                                           value="{{ $passenger->passport_expire_date ? $passenger->passport_expire_date->format('Y-m-d') : old('passport_expire_date') }}">

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
                                        passport image:
                                    </label>
                                    <div class="m-input-icon m-input-icon--right">
                                        <a target="_blank" href="{{ Storage::url($passenger->passport_image) }}"
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
                                        <a target="_blank" href="{{ Storage::url($passenger->personal_image) }}"
                                           class="btn btn-primary">
                                            Personal Image
                                        </a>
                                    </div>
                                    <span class="m-form__help">
                                    View personal image.
                                </span>
                                </div>
                            </div>
                            <hr>
							<?php $index ++; ?>
                        @endforeach
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
                                    <a href="{{ route('travelOrders',['travel' => $travel->id]) }}"
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

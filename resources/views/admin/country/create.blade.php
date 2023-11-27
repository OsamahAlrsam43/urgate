@extends('layouts.master')

@section('page-title')
    Airports
@endsection

@section('sub-header')
    Airports - Create
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
                                Airport Details.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('storeCountry') }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label>
                                    Name (en):
                                </label>
                                <input type="text" name="name[en]" class="form-control m-input"
                                       placeholder="Enter country name in english"
                                       value="{{ old('name.en') }}">
                                @if(isset($errors->messages()['name.en']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['name.en'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter airport name in english
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    Name (ar):
                                </label>
                                <input type="text" name="name[ar]" class="form-control m-input"
                                       placeholder="Enter country name in arabic"
                                       value="{{ old('name.ar') }}">
                                @if(isset($errors->messages()['name.ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['name.ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter airport name in arabic
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    Code:
                                </label>
                                <input type="text" name="code" class="form-control m-input"
                                       placeholder="Enter code"
                                       value="{{ old('code') }}">
                                <span class="m-form__help">
                                    Please enter airport code
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
                                        Add Country
                                    </button>
                                    <a href="{{ route('listCountries') }}" class="btn btn-secondary">
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
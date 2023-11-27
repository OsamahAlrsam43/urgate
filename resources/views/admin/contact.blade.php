@extends('layouts.master')

@section('page-title')
    Contact
@endsection

@section('sub-header')
    Contact
@endsection

@section('content')
    @include('includes.info-box')

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
                                Update Contact Page.
                            </h3>
                        </div>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('updateContact') }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-12">
                                <label>
                                    Mail:
                                </label>
                                <input type="text" name="mail" class="form-control m-input"
                                       placeholder="Enter contact mail in english"
                                       value="{{ old('mail') ? old('mail') : $setting->mail }}">
                                @if(isset($errors->messages()['mail']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['mail'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter about title in english
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    Content (en):
                                </label>
                                <textarea name="contact[en]" class="ckeditor form-control m-input" rows="4"
                                          placeholder="Enter contact content in english">{{ old('contact.en') ? old('contact.en') : $setting->contact['en'] }}</textarea>
                                @if(isset($errors->messages()['contact.en']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['contact.en'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter contact content in english
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    Content (ar):
                                </label>
                                <textarea name="contact[ar]" class="ckeditor form-control m-input" rows="4"
                                          placeholder="Enter contact content in arabic">{{ old('contact.ar') ? old('contact.ar') : $setting->contact['ar'] }}</textarea>
                                @if(isset($errors->messages()['contact.ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['contact.ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter contact content in arabic
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
                                        Save Changes
                                    </button>
                                    <a href="{{ route('home') }}" class="btn btn-secondary">
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
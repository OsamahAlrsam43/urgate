@extends('layouts.master')

@section('page-title')
    Settings
@endsection

@section('sub-header')
    Settings
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
                                Update settings.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('settings-form') }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">

                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    Phone:
                                </label>
                                <input type="text" name="phone" class="form-control m-input"
                                       placeholder="Enter phone"
                                       value="{{ old('phone') ? old('phone') : $setting->phone }}">
                                <span class="m-form__help">
                                    Please enter phone
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    Address:
                                </label>
                                <input type="text" name="address" class="form-control m-input"
                                       placeholder="Enter address"
                                       value="{{ old('address') ? old('address') : $setting->address }}">
                                <span class="m-form__help">
                                    Please enter address
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    Mail:
                                </label>
                                <input type="text" name="mail" class="form-control m-input"
                                       placeholder="Enter mail"
                                       value="{{ old('mail') ? old('mail') : $setting->mail }}">
                                <span class="m-form__help">
                                    Please enter mail
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    Facebook:
                                </label>
                                <input type="text" name="facebook" class="form-control m-input"
                                       placeholder="Enter facebook"
                                       value="{{ old('facebook') ? old('facebook') : $setting->facebook }}">
                                <span class="m-form__help">
                                    Please enter facebook
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    Instagram:
                                </label>
                                <input type="text" name="instagram" class="form-control m-input"
                                       placeholder="Enter instagram"
                                       value="{{ old('instagram') ? old('instagram') : $setting->instagram }}">
                                <span class="m-form__help">
                                    Please enter instagram
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    Twitter:
                                </label>
                                <input type="text" name="twitter" class="form-control m-input"
                                       placeholder="Enter facebook"
                                       value="{{ old('twitter') ? old('twitter') : $setting->twitter }}">
                                <span class="m-form__help">
                                    Please enter twitter
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    Youtube:
                                </label>
                                <input type="text" name="youtube" class="form-control m-input"
                                       placeholder="Enter youtube"
                                       value="{{ old('youtube') ? old('youtube') : $setting->youtube }}">
                                <span class="m-form__help">
                                    Please enter youtube
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    Linked in:
                                </label>
                                <input type="text" name="linked" class="form-control m-input"
                                       placeholder="Enter linked"
                                       value="{{ old('linked') ? old('linked') : $setting->linked }}">
                                <span class="m-form__help">
                                    Please enter linked
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-12">
                                <label>
                                    Charter Instructions
                                </label>
                                <textarea name="charter" class="form-control m-input" rows="5">{{ old('charter') ? old('charter') : $setting->charter }}</textarea>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    Create Charter Instructions [ar]
                                </label>
                                <textarea name="create_charter[ar]" class="form-control m-input" rows="5">{{ old('create_charter.ar') ? old('create_charter.ar') : $setting->create_charter['ar'] }}</textarea>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    Create Charter Instructions [en]
                                </label>
                                <textarea name="create_charter[en]" class="form-control m-input" rows="5">{{ old('create_charter.en') ? old('create_charter.en') : $setting->create_charter['en'] }}</textarea>
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
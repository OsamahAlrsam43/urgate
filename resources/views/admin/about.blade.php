@extends('layouts.master')

@section('page-title')
    About
@endsection

@section('sub-header')
    About
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
                                Update About page.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('updateAbout') }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    About Title (en):
                                </label>
                                <input type="text" name="about_title[en]" class="form-control m-input"
                                       placeholder="Enter about title in english"
                                       value="{{ old('about_title.en') ? old('about_title.en') : $setting->about_title['en'] }}">
                                @if(isset($errors->messages()['about_title.en']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['about_title.en'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter about title in english
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    About Title (ar):
                                </label>
                                <input type="text" name="about_title[ar]" class="form-control m-input"
                                       placeholder="Enter about title in arabic"
                                       value="{{ old('about_title.ar') ? old('about_title.ar') : $setting->about_title['ar'] }}">
                                @if(isset($errors->messages()['about_title.ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['about_title.ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter about title in arabic
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    About Content (en):
                                </label>
                                <textarea name="about_content[en]"  class=" form-control m-input" rows="4"
                                          placeholder="Enter about content in english">{{ old('about_content.en') ? old('about_content.en') : $setting->about_content['en'] }}</textarea>
                                @if(isset($errors->messages()['about_content.en']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['about_content.en'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter about content in english
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    About Content (ar):
                                </label>
                                <textarea name="about_content[ar]" class=" form-control m-input" dir="rtl" rows="4"
                                          placeholder="Enter about content in arabic">{{ old('about_content.ar') ? old('about_content.ar') : $setting->about_content['ar'] }}</textarea>
                                @if(isset($errors->messages()['about_content.ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['about_content.ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter about content in arabic
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
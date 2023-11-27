@extends('layouts.master')

@section('page-title')
    Pages
@endsection

@section('sub-header')
    Pages- Create
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
                                Pages Details.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('storePage') }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    name (en):
                                </label>
                                <input type="text" name="name[en]" class="form-control m-input"
                                       placeholder="Enter page name in english" value="{{ old('name.en') }}">
                                @if(isset($errors->messages()['name.en']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['name.en'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter Pages name in english
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    name (ar):
                                </label>
                                <input type="text" name="name[ar]" class="form-control m-input"
                                       placeholder="Enter page name in arabic" value="{{ old('name.ar') }}">
                                @if(isset($errors->messages()['name.ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['name.ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter page name in arabic
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    title (en):
                                </label>
                                <input type="text" name="title[en]" class="form-control m-input"
                                       placeholder="Enter page title in english" value="{{ old('title.en') }}">
                                @if(isset($errors->messages()['title.en']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['title.en'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter Pages title in english
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    title (ar):
                                </label>
                                <input type="text" name="title[ar]" class="form-control m-input"
                                       placeholder="Enter page title in arabic" value="{{ old('title.ar') }}">
                                @if(isset($errors->messages()['title.ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['title.ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter page title in arabic
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    content (en):
                                </label>
                                <textarea name="page_content[en]" class="form-control m-input ckeditor"
                                          placeholder="Enter page content in english">{{ old('page_content.en') }}</textarea>
                                @if(isset($errors->messages()['page_content.en']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['page_content.en'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter Pages content in english
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    content (ar):
                                </label>
                                <textarea name="page_content[ar]" class="form-control m-input ckeditor"
                                          placeholder="Enter page content in arabic">{{ old('page_content.ar') }}</textarea>
                                @if(isset($errors->messages()['page_content.ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['page_content.ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter page content in arabic
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label>
                                    Page type:
                                </label>
                                <select name="page_type" id="page_type" class="form-control">
                                    <option value="news" selected>News</option>
                                    <option value="page">Page</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    Sticky news:
                                </label>
                                <select name="sticky" id="sticky" class="form-control">
                                    <option value="0" selected>Not sticky</option>
                                    <option value="1">Sticky</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    Sticky expire:
                                </label>
                                <input type="date" name="sticky_date" id="sticky_date" class="form-control" />
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
                                        Add page
                                    </button>
                                    <a href="{{ route('listPages') }}" class="btn btn-secondary">
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
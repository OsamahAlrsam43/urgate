@extends('layouts.master')

@section('page-title')
    Message
@endsection

@section('sub-header')
    Message- Create
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
                                Message Details.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{route('storeMessage')}}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    title (en):
                                </label>
                                <input type="text" name="title_en" required class="form-control m-input"
                                       placeholder="Enter Message title in english" value="{{ old('title_en') }}">
                                @if(isset($errors->messages()['title_en']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['title_en'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter Message content in english
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    title (ar):
                                </label>
                                <input type="text" name="title_ar" required class="form-control m-input"
                                       placeholder="Enter Message title in arabic" value="{{ old('title_ar') }}">
                                @if(isset($errors->messages()['title_ar']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['title_ar'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter Message title in arabic
                                </span>
                            </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                    <div class="form-group m-form__group row">
                        <div class="col-lg-6">
                            <label>
                                Description English:
                            </label>
                            <textarea required name="details_en" class="ckeditor form-control m-input"
                                      placeholder="Enter your Message description">{{ old('details_en') }}</textarea>
                            @if(isset($errors->messages()['details_en']))
                                <div class="form-control-feedback" style="color: #f4516c;">
                                    {{  $errors->messages()['details_en'][0] }}
                                </div>
                            @endif
                            <span class="m-form__help">
                                    Please enter Message description.
                                </span>
                        </div>
                        <div class="col-lg-6">
                            <label>
                                Description (Ar):
                            </label>
                            <textarea name="details_ar" class="ckeditor form-control m-input"
                                      placeholder="Enter your Message description" required>{{ old('details_ar') }}</textarea>
                            @if(isset($errors->messages()['details_ar']))
                                <div class="form-control-feedback" style="color: #f4516c;">
                                    {{  $errors->messages()['details_ar'][0] }}
                                </div>
                            @endif
                            <span class="m-form__help">
                                    Please enter Message description.
                                </span>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                @if(isset($errors->messages()['users']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['users'][0] }}
                                    </div>
                                @endif <br>
                             <div class="col-md-12" style="color: #f4516c; font-weight: bold"><input type="checkbox" id="selectAll">Select All </div>
                        @foreach($users as $user)
                            <div class="col-md-4">
                                <input class="mt-4" name="users[]" type="checkbox" value="{{$user->id}}"><span>{{$user->name}}</span>
                            </div>
                        @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-8">
                                    <button type="submit" class="btn btn-primary">
                                        Add Message
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
    <script>
        $("#selectAll").click(function(){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));

        });
    </script>
@endsection
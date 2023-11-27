@extends('layouts.master')

@section('page-title')
    Users
@endsection

@section('sub-header')
    Users- Update
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
                                User Details.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('updateUser',['user' => $user->id]) }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-3">
                                <label>
                                    Name:
                                </label>
                                <input type="text" name="name" class="form-control m-input"
                                       placeholder="Enter username"
                                       value="{{ $user->name ? $user->name : old('name') }}">
                                @if(isset($errors->messages()['name']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['name'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter username
                                </span>
                            </div>
                            <div class="col-lg-3">
                                <label>
                                    Email:
                                </label>
                                <input type="email" name="email" class="form-control m-input"
                                       placeholder="Enter user email"
                                       value="{{ $user->email ? $user->email : old('email') }}">
                                @if(isset($errors->messages()['email']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['email'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter user email
                                </span>
                            </div>

                            <div class="col-lg-3">
                                <label>
                                    Role:
                                </label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <select name="type" class="form-control m-input">
                                        <option value="User" {{ old('type') === 'User' ? 'selected' : '' }}>User</option>
                                        @if(Auth::user()->type === 'Super Admin')
                                            <option value="Super Admin" {{ old('type') === 'Super Admin' ? 'selected' : '' }}>
                                                Super
                                                Admin
                                            </option>
                                            <option value="Ticket" {{ old('type') === 'Ticket' ? 'selected' : '' }}>
                                                Ticket
                                            </option>
                                            <option value="GSA" {{ old('type') === 'GSA' ? 'selected' : '' }}>
                                                GSA
                                            </option>
                                        @endif
                                    </select>
                                </div>
                                @if(isset($errors->messages()['type']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['type'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter user role
                                </span>
                            </div>

                            <div class="col-lg-3">
                                <label>
                                    Show Invoices:
                                </label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <select name="showInvoices" class="form-control m-input">
                                        <option value="0" {{ old('showInvoices') ? old('showInvoices') === 0 ? 'selected' : '' : $user->showInvoices === 0 ? 'selected' : '' }}>
                                            Hide
                                        </option>
                                        <option value="1" {{ old('showInvoices') ? old('showInvoices') === 1 ? 'selected' : '' : $user->showInvoices === 1 ? 'selected' : '' }}>
                                            Show
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="{{ Auth::user()->type === 'Super Admin' ? 'col-lg-3': 'd-none' }}">
                                <label>
                                    Parent:
                                </label>
                                <input type="hidden" value="{{ $user->parent }}" name="parent" readonly>
                            </div>
                            <div class="col-lg-{{ Auth::user()->type === 'Super Admin' ? '3': '6' }}">
                                <label>
                                    Company Name:
                                </label>
                                <input class="form-control m-input" type="text"
                                       value="{{ $user->company }}" name="company">
                            </div>

                            <div class="col-lg-3">
                                <label>
                                    Address:
                                </label>
                                <input class="form-control m-input" type="text"
                                       value="{{ $user->address }}" name="address">
                            </div>

                            <div class="col-lg-3">
                                <label>
                                    Phone:
                                </label>
                                <input class="form-control m-input" type="text"
                                       value="{{ $user->phone }}" name="phone">
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            {{--<div class="col-lg-4">--}}
                                {{--<label>--}}
                                    {{--Old Password:--}}
                                {{--</label>--}}
                                {{--<div class="m-input-icon m-input-icon--right">--}}
                                    {{--<input type="password" name="old_password" class="form-control m-input"--}}
                                           {{--placeholder="enter user old password.">--}}
                                {{--</div>--}}
                                {{--@if(isset($errors->messages()['old_password']))--}}
                                    {{--<div class="form-control-feedback" style="color: #f4516c;">--}}
                                        {{--{{  $errors->messages()['old_password'][0] }}--}}
                                    {{--</div>--}}
                                {{--@endif--}}
                                {{--<span class="m-form__help">--}}
                                    {{--Please enter user old password.--}}
                                {{--</span>--}}
                            {{--</div>--}}
                            <div class="col-lg-6">
                                <label>
                                    New Password:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="password" name="new_password" class="form-control m-input"
                                           placeholder="enter user new password.">
                                </div>
                                @if(isset($errors->messages()['new_password']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['new_password'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please enter user new password.
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    Re-type Password:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="password" name="new_password_confirmation" class="form-control m-input"
                                           placeholder="re-enter user new password.">
                                </div>
                                @if(isset($errors->messages()['new_password_confirmation']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['new_password_confirmation'][0] }}
                                    </div>
                                @endif
                                <span class="m-form__help">
                                    Please re-enter user new password.
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
                                    <a href="{{ route('listUsers') }}" class="btn btn-secondary">
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
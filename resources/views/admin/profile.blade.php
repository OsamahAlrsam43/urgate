@extends('layouts.master')

@section('page-title')
    Profile
@endsection

@section('sub-header')
    Profile
@endsection

@section('styles')
    <style>
        .font-hg{
            font-size: 23px;
        }

        .font-red-flamingo{
            color: #EF4836!important;
        }

        .theme-font{
            color: #32c5d2!important;
        }

        .font-purple{
            color: #8E44AD!important;
        }

        .font-blue-sharp{
            color: #5C9BD1!important;
        }

        .font-grey-mint{
            color: #525e64!important;
        }

        .font-lg {
            font-size: 18px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="m-portlet m-portlet--full-height">
                <div class="m-portlet__body">
                    <div class="m-card-profile">
                        <div class="m-card-profile__title m--hide">
                            Your Profile
                        </div>
                        <div class="m-card-profile__pic">
                            <div class="m-card-profile__pic-wrapper">
                                <img src="{{ Auth::user()->avatar ? url('/storage/app/public/'.Auth::user()->avatar) : asset('custom/images/avatar.jpg') }}"
                                     alt=""/>
                            </div>

                            <button class="btn btn-sm btn-info change-avatar" style="margin-bottom: 10px;">
                                Change Logo
                            </button>

                            <form action="{{route('changeAvatar')}}" method="post"
                                  style="margin-bottom: 15px;display: none;" enctype="multipart/form-data"
                                  class="change-avatar-form">
                                <input type="file" name="avatar"/>
                                {!! csrf_field() !!}
                            </form>
                        </div>
                        <div class="m-card-profile__details">
                            <span class="m-card-profile__name">
                                {{ Auth::user()->name }}
                            </span>
                            <a class="m-card-profile__email m-link" style="display: block;">
                                {{ Auth::user()->email }}
                            </a>
                            <span class="m-card-profile__email m-link">
                                ID: <span style="color:#000000;">{{ Auth::user()->id }}</span>
                            </span>
                        </div>
                    </div>
                    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                        <li class="m-nav__separator m-nav__separator--fit"></li>
                        <li class="m-nav__section m--hide">
                            <span class="m-nav__section-text">
                                Section
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="m-portlet m-portlet--full-height">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Statistics
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="row list-separated">
                        <div class="col">
                            <div class="font-grey-mint font-sm"> Total Points </div>
                            <div class="uppercase font-hg font-red-flamingo"> {{$points}}
                                <span class="font-lg font-grey-mint">Points</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="font-grey-mint font-sm"> Balance </div>
                            <div class="uppercase font-hg theme-font"> {{ Auth::user()->balance }}
                                <span class="font-lg font-grey-mint">$</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="font-grey-mint font-sm"> Total Commission </div>
                            <div class="uppercase font-hg font-purple"> {{$totalCommission}}
                                <span class="font-lg font-grey-mint">$</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="font-grey-mint font-sm"> Charter Commission </div>
                            <div class="uppercase font-hg font-blue-sharp"> {{$charterCommission}}
                                <span class="font-lg font-grey-mint">$</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="font-grey-mint font-sm"> Visa Commission </div>
                            <div class="uppercase font-hg font-blue-sharp"> {{$visaCommission}}
                                <span class="font-lg font-grey-mint">$</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Edit information
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <ul class="nav nav-tabs m-tabs m-tabs-line w-100 m-tabs-line--left m-tabs-line--primary"
                        role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1"
                               role="tab">
                                <i class="flaticon-share m--hide"></i>
                                Profile
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2"
                               role="tab">
                                Password
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content d-table w-100">
                        <div class="tab-pane active" id="m_user_profile_tab_1">
                            <form class="" method="post"
                                  action="{{ route('updateProfile') }}">
                                <div class="m-portlet__body p-0">
                                    <div class="form-group m--margin-top-10">
                                        @include('includes.info-box')
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input">
                                            Name
                                        </label>
                                        <input class="form-control m-input" type="text"
                                               value="{{ Auth::user()->name }}" name="name" @foruser(readonly)>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="">
                                            Email
                                        </label>
                                        <input class="form-control m-input" type="text"
                                               value="{{ Auth::user()->email }}" name="email" @foruser(readonly)>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="">
                                            Company Name
                                        </label>
                                        <input class="form-control m-input" type="text"
                                               value="{{ Auth::user()->company }}" name="company" @foruser(readonly)>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="">
                                            Address
                                        </label>
                                        <input class="form-control m-input" type="text"
                                               value="{{ Auth::user()->address }}" name="address" @foruser(readonly)>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="">
                                            Phone
                                        </label>
                                        <input class="form-control m-input" type="text"
                                               value="{{ Auth::user()->phone }}" name="phone" @foruser(readonly)>
                                    </div>
                                </div>
                                {!! csrf_field() !!}

                                @isadmin()
                                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                    Save changes
                                </button>
                                &nbsp;&nbsp;
                                <button type="reset"
                                        class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    Cancel
                                </button>
                                @endisadmin
                            </form>
                        </div>
                        <div class="tab-pane" id="m_user_profile_tab_2">
                            <form method="post"
                                  action="{{ route('updatePassword') }}">
                                <div class="m-portlet__body p-0">
                                    <div class="form-group m--margin-top-10">
                                        @include('includes.info-box')
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input">
                                            Password
                                        </label>
                                        <input class="form-control m-input" type="password" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input">
                                            New password
                                        </label>
                                        <input class="form-control m-input" type="password" name="new_password">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input">
                                            Re-enter your password
                                        </label>
                                        <input class="form-control m-input" type="password"
                                               name="new_password_confirmation">
                                    </div>
                                </div>
                                {!! csrf_field() !!}

                                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                    Save changes
                                </button>
                                &nbsp;&nbsp;
                                <button type="reset"
                                        class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    Cancel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('[name=avatar]').change(function () {
            $(this).parent('form').submit();
        });

        $('.change-avatar').click(function () {
            $('.change-avatar-form').slideToggle();
        });
    </script>
@endsection
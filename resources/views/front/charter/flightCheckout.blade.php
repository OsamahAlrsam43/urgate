@extends('layouts.master-front')

@section('title')
    {{ $flight->name[App::getLocale()] }}
@endsection

@section('page-header')
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span>{{ $flight->name[App::getLocale()] }}</span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
@endsection

@section('content')
    @if(session()->has('fail'))
        <div class="alert m-alert m-alert--default alert-danger" role="alert">
            {{ session()->get('fail') }}
        </div>
    @elseif(session()->has('success'))
        <div class="alert m-alert m-alert--default alert-success" role="alert">
            {{session()->get('success') }}
        </div>
    @endif
    <!-- Start visa-inner -->
    <div class="visa-inner">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start inner-head-gp -->
            <div class="inner-head-gp d-flex align-items-center justify-content-between">
                <!-- Start inner-head -->
                <div class="inner-head d-flex align-items-center">
                    <i class="icons8-view-details"></i>
                    <div>
                        <span>@lang("alnkel.travel-order-confirmation"):</span>
                    </div>
                </div>
                <!-- End inner-head -->
            </div>
            <!-- End inner-head-gp -->

            <!-- Start checkout-table -->
            <table class="table checkout-table">
                <thead>
                <tr>
                    <th scope="col">@lang("alnkel.travel-current-balance")</th>
                    <th scope="col">@lang("alnkel.travel-passengers-number")</th>
                    <th scope="col">@lang("alnkel.travel-final-price")</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>
                        <span class="Allowed">{{ Auth::user()->balance }} @lang("alnkel.visa-dollar")</span>
                    </th>
                    <th>
                        <span class="someInfo">
                            @if($travelersCount === 1)
                                @lang("alnkel.visa-person")
                            @else
                                {{ $travelersCount }} @lang("alnkel.visa-people")
                            @endif
                        </span>
                    </th>
                    <th>
                        <span class="notAllowed">{{ $price }} @lang("alnkel.visa-dollar")</span>
                    </th>
                </tr>
                </tbody>
            </table>
            <!-- End checkout-table -->
            <!-- Start action-btns -->
            <div class="action-btns d-flex align-items-center justify-content-center">
                <a href="{{ route('charter-checkout-form',['flight' => $flight->id]) }}" id="blockButton"
                   class="btn-reset submit-btn d-flex align-items-center justify-content-center">
                    <i class="icons8-done"></i>
                    <span>@lang("alnkel.visa-final-price")</span>
                </a>
            </div>
            <!-- End action-btns -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End visa-inner -->
@endsection

@section('scripts')
    <script src="{{ asset('front-assets/js/jquery.blockUI.js') }}"></script>
    <script>
        $('#blockButton').click(function () {
            $.blockUI({
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                }
            });
        });
    </script>
@endsection
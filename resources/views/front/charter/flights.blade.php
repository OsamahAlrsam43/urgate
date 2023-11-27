@extends('layouts.master-front')

@section('title')
    @lang("alnkel.flights")
@endsection

@section('page-header')
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span>@lang("alnkel.flights")</span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
@endsection

@section('content')
    @auth
        <section class="container">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8 white-class">
                    <div class="row ">
                        <div class="col-sm-6 border-r">
                            <h5 class="text-center p-3">@lang('alnkel.create_booking')</h5>
                            <a href="{{route('charter.create')}}"
                               class="text-center icon-search fa fa-plus-circle fa-3x">

                            </a>
                        </div>
                        <div class="col-sm-6">
                            <h5 class="text-center p-3">@lang('alnkel.search_booking')</h5>
                            <a href="{{route('charter.search')}}"
                               class="text-center icon-search fa fa-search-plus fa-3x">

                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </section>
    @endauth
    <section class="garter-offers" style="margin-top: 75px !important;">
        @if(count($oneWayFlights) > 0)
            <div class="slider-box text-center">
                <h1 class="gartert-btn slider-button" style="border-bottom: 2px dotted;width: 31%;margin: auto;margin-bottom: 35px;padding: 16px 16px;">@lang("charter.available_flights_oneway")</h1>

              
              <div class="container" style="color:white;position:sticky;top: 0;z-index: 999;">
                <div class="row">
                  <div class="col-md-12">
                    
                <table class="table" style="width:100%;margin: auto;color:white;" dir="{{ Lang::locale() == 'ar' ? 'rtl' : 'ltr'}}">
    <tr style="    height: 60px;">
      <th style="background: #1B6FB6 !important;width: 16%;" scope="col">@lang("alnkel.datech")  </th>
      <th style="background: #1B6FB6 !important;" scope="col">@lang("alnkel.men")</th>
      <th style="background: #1B6FB6 !important;    width: 18%;" scope="col">@lang("alnkel.kn") </th>
      <th style="background: #1B6FB6 !important;    width: 12%;" scope="col">@lang("alnkel.ela")</th>
       <th style="background: #1B6FB6 !important;width: 15%;" scope="col">@lang("alnkel.ncount")</th>
       <th style="background: #1B6FB6 !important;" scope="col">@lang("alnkel.price")</th>
       <th style="background: #1B6FB6 !important;width: 15%;" scope="col">@lang("alnkel.rev")</th>
    </tr>
              </table>
                    
                    </div>
                  
                </div>
                
              </div>
              
              
                <div class="slider-content">
                    <ul class="slider">
                        <li>
                            @foreach($oneWayFlights as $charter)
                                @include("includes.front.charter_item")
                            @endforeach
                        </li>
                        <li></li>
                    </ul>
                </div>
            </div>
        @endif

        @if(count($twoWayFlights) > 0)
            <div class="slider-box text-center">
            <button class="gartert-btn slider-button">@lang("charter.available_flights_twoway")</button>

            <div class="slider-content">
                <ul class="slider">
                    <li>
                        @foreach($twoWayFlights as $charter)
                            @include("includes.front.charter_item")
                        @endforeach
                    </li>
                    <li></li>
                </ul>
            </div>
        </div>
        @endif
    </section>

@endsection

@section('styles')
    <style>
        .border-r {
            border-right: 1px solid #baba;
        }

        .icon-search {
            width: 100%;
            margin-top: 20px;
            padding-bottom: 20px;
        }

        .white-class {
            border: 1px solid #baba;
            background-color: #fff;
            padding: 10px;
            margin-top: 40px;
            border-radius: 4px;
        }
    </style>
@stop
@section('scripts')
    <script>
        $('[data-toggle="tooltip"]').tooltip();
    </script>
@endsection
@extends('layouts.master-front')
@section('title', 'النخيل |  الرئيسية')
@section('content')
    <style>
        .visa-container {
            background: #333;
            color: #fff;
        }

        .visa-papers small {
            font-size: 13px;
            color: #d0d0d0;
        }

        .visa-title {
            font-size: 16px;
            margin-bottom: 5px;
            position: relative;
            top: -10px;
            height: 40px;
        }

        .visa-img {
            height: 130px;
            width: 150px;
            max-width: initial;
            border-radius: 5px;
        }

        .visa-papers {
            height: 46px;
            overflow: hidden;
        }

        .visa-price {
            font-size: 22px;
            position: absolute;
            bottom: 2px;
            left: -61px;
            background: rgba(0, 0, 0, 0.72);
            width: 65px;
            padding: 0 5px;
            text-align: center;
            border-radius: 5px;
        }

        .visa-container .card-body {
            padding-bottom: 0;
        }

        .garter-offers .slider-box .slider-content ul li .content {
            box-shadow: 0 0 2px 1px rgba(107, 107, 107, 0.17);
        }

        .home-section-title {
            background: #333;
            color: #fff;
            text-align: center;
            margin: 40px auto;
            display: table;
            padding: 10px;
            width: 200px;
            border-radius: 30px;
            box-shadow: 0 0 1px 1px #333;
        }

        .home-section-title.travel-title {
            background: #FF378F;
            box-shadow: 0 0 1px 1px #FF378F;
        }

        .travel-section{
            background-image: url(/front-assets/images/travel_background.jpg);
            padding: 70px 0;
            position: relative;
            background-size: cover;
            margin-top: -90px;
        }

        .reserve-btn {
            background: #f71468;
            border-radius: 20px;
            border-color: transparent;
            padding: 4px 40px;
        }
    </style>

    <section class="garter-offers">
        <div class="slider-box text-center">
            <button class="gartert-btn slider-button">@lang("alnkel.Charter Offers")</button>
            <div class="slider-content">
                <ul class="slider">
                    <li>
                        @foreach($charters as $charter)
                            @include("includes.front.charter_item")
                        @endforeach
                    </li>
                    <li></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="travel-section">
        <div class="home-section-title travel-title">@lang("alnkel.Travel Offers")</div>
        <div class="container">
            <div class="row">
                @foreach($travels as $travel)
                    <div class="col-md-4">
                        @include('includes.front.cards.travels',compact('travel'))
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section>
        <div class="home-section-title">@lang("alnkel.Visa Offers")</div>
        <div class="container">
            <div class="row">
                @foreach($visas as $visa)
                    <div class="col-md-4">
                        @include('includes.front.cards.visa',compact('visa'))
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@extends('layouts.master-front')
@section('content')
      <style>
        
        
       .container.text-right {
    border: 2px solid #1B6FB6 !important;
}
        
        @media only screen and (max-width: 600px) {
          .tbl-css{
                 display: none;
            }
          
          .main-button{
            width:30%;
          }
        }
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
.nav-options {
    background: gold;
    padding: 5px 88px 1px 88px;
    margin-bottom: 0;
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
.nav-options{    background: gold;
    padding: 5px 88px 1px 88px;
    margin-bottom: 0;
}
        .reserve-btn {
            background: #f71468;
            border-radius: 20px;
            border-color: transparent;
            padding: 4px 40px;
        }
        .btn-group>.btn-group:not(:first-child)>.btn, .btn-group>.btn:not(:first-child) {
    border-top-left-radius: 0;background:gold;color:#000;border:none;
    margin: 0px 12px;}
    .btn-group>.btn-group:not(:last-child)>.btn, .btn-group>.btn:not(:last-child):not(.dropdown-toggle) {
    background: #1B6FB6;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border:none;
}.card-block:after {
    content: "";
    position: absolute;
    background: rgba(2, 41, 63,0);
    border: none;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    z-index: 1;
    transition: all ease-in-out .5s;
}.mb-3, .my-3 {
    margin-bottom: 0rem !important;
}.home-section-title.travel-title {
    font-size: 33px;
    background: transparent;
    box-shadow: none;
}.garter-offers .slider-box .gartert-btn {
    background-color: transparent;
    margin-bottom: 23px;
    font-size: 33px;
}
.home-section-title.travel-title {
    background: transparent;
    box-shadow: none;
}.home-section-title {
    background: transparent;
    color: #000;
    text-align: center;
    margin: 40px auto;
    display: table;
    padding: 10px;
    font-size: 33px;
    width: 100%;
    border-radius: 30px;
    box-shadow: none;
}a.card-block {
    margin: 12px;}.garter-offers .slider-box .slider-content ul li {
    display: block;
    margin: 0;
    margin-bottom: 137px;
}
.slider-button {
    width: 100%;
    margin: auto;
    border-radius: 25px;
    color: #1B6FB6;
    background-color: #1B6FB6;
    padding: 14px;
    display: inline-block;
    font-weight: 700;
    border: none;
    -webkit-box-shadow: 1px 1px 7px rgba(0, 0, 0, 0.5);
    box-shadow: none;
}
        
        @media screen and (max-width: 768px){.btn-group-sm>.btn, .btn-sm {
    padding: .2rem .1rem;
    font-size: .475rem;
    line-height: 1.5;
    border-radius: .2rem;
  position:relative ;
  top:3px
  
}.main-header .trips ul li {
    background-color: #fff;
    padding: 10px;
    width: auto;
    font-size: 11px;
}
.main-header .trips .tipr-box {
    direction: ltr;
    background-color: #f2f2f2;
    width: 94%;
    margin: auto;
    padding: 0px;}
    .btn-group-vertical>.btn, .btn-group>.btn {
    font-size: 12px;}
    .options {
    position: relative;
    right: 0px;
    width: 115%;
}.filter input[type="text"] {
    padding: 9px 32px;
}.main-nv .nav-options ul li {
    font-size: 10px;}.main-header .trips ul li {
    background-color: #fff;
    padding: 10px;
    width: 100px;}
    .visa-img {
    height: 130px;
    width: 100%;}.main-nv ul li, .main-header ul li {
    display: inline-block;
    margin-left: 0;
}.main-header .trips ul li {
    background-color: #fff;
    padding: 10px;
    width: auto;
    font-size: 11px;
}.main-nv .site-links ul li a {
    margin-right: 0!important;
}
}
    </style>


 <section class="garter-offers">
        <div class="slider-box text-center">
            <h1 class="gartert-btn slider-button" style="font-size: 28px;">@lang("alnkel.newsh")</h1>
            <div class="slider-content">
              
                <ul class="slider">
                    <li>
                        @foreach($news as $item)
                            @include("includes.front.news_item")
                        @endforeach
                    </li>
                    <li></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="garter-offers" style="margin-top: -74px !important; margin-top: -74px !important;
    border-bottom: 4px dashed #1B6FB6; border-radius: 20px;">
        <div class="slider-box text-center" >
            <h1 class="gartert-btn slider-button" style="font-size: 28px;" >@lang("alnkel.Charter Offers")</h1>
            <div class="slider-content" style=" height: 322px;overflow: auto;width: 80%;margin: auto;">
              
              
              <div class="container" style="color:white;position:sticky;top: 0;z-index: 999;">
                <div class="row">
                  <div class="col-md-12">
              
              <table class="table tbl-css" style="width: 100%;margin: auto;color:white" dir="{{ Lang::locale() == 'ar' ? 'rtl' : 'ltr'}}">
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
              
              
                <ul class="slider slider-chart">
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






    <section class="travel-section" style="margin-top: 1px !important;">
        <div class="home-section-title travel-title">@lang("alnkel.Travel Offers")</div>
        <div class="container">
            <div class="row">
                @foreach($travels as $travel)
                    <div class="col-md-4 col-xs-4">
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
                    <div class="col-md-4 col-xs-4">
                        @include('includes.front.cards.visa',compact('visa'))
                    </div>
                @endforeach
            </div>
        </div>
    </section>


@endsection

@extends('layouts.master-front')

@section('title')
{{ App::getLocale() == 'ar' ? 'عنا' : 'About Us' }}
@endsection

@section('page-header')
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span>{{ App::getLocale() == 'ar' ? 'عنا' : 'About Us' }}</span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
@endsection

@section('content')
    <div class="travel-inner">
        <!-- Start container-fluid -->
        <div class="container">
            <!-- Start inner-head-gp -->
            <div class="inner-head-gp d-flex align-items-center justify-content-between">
                <!-- Start inner-head -->
                <div class="inner-head d-flex align-items-center">
                    <i class="icons8-view-details"></i>
                    <div>
                        <span>{{ $setting->about_title[App::getLocale()] }}:</span>
                    </div>
                </div>
                <!-- End inner-head -->
            </div>
            <!-- End inner-head-gp -->
            <!-- Start travel-post -->
            <div class="travel-post">
                <!-- Start travel-post-text -->
                <div class="travel-post-text">
                    {!! $setting->about_content[App::getLocale()] !!}
                </div>
                <!-- End  travel-post-text -->
            </div>
            <!-- End travel-post -->
        </div>
        <!-- End container-fluid -->
    </div>
@endsection
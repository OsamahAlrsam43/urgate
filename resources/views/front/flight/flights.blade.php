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
    <!-- Start categorylist -->
    <div class="categorylist section">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start row -->
            <div class="row">
                @foreach($flights as $flight)
                    <div class="col-md-4">
                        @include('includes.front.cards.flights',compact('flight'))
                    </div>
                @endforeach
            </div>
            <!-- End row -->
            @include('includes.front.pagination',['item' => $flights])
        </div>

        <!-- End container-fluid -->
    </div>
    <!-- End categorylist -->
@endsection
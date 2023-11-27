@extends('layouts.master')

@section('page-title')
    Charter days
@endsection

@section('sub-header')
    Charter days
@endsection

@section('content')
    @include('includes.info-box')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                       ({{$charter->name['en']}}) Days & Seats
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="m-datatable" id="html_table">
                <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        All Seats
                    </th>
                    <th>
                        Sold Seats
                    </th>
                    <th>
                        Available Seats
                    </th>
                </tr>
                <tbody>
                    @foreach($charter->price as $i => $price)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td>{{$price['date']}}</td>
                            <td>{{$price['seats']}}</td>
                            <td>{{$price['reserved_seats']}}</td>
                            <td>{{$price['seats'] - $price['reserved_seats']}}</td>
                        </tr>
                    @endforeach
                </tbody>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('default-assets/demo/default/custom/components/datatables/base/html-table.js') }}"
            type="text/javascript"></script>
@endsection
@extends('layouts.master')

@section('page-title')
    Flights
@endsection

@section('sub-header')
    Flights
@endsection

@section('content')
    @include('includes.info-box')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Flights Controller
                        <small>
                            Controller your flights
                        </small>
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <div class="col-md-4">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input m-input--solid"
                                           placeholder="Search..." id="generalSearch">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span>
                                            <i class="la la-search"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <a href="{{ route('createFlight') }}"
                           class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>
                                    New Flight
                                </span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <table class="m-datatable" id="html_table" width="100%">
                <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Ticket Type
                    </th>
                    <th>
                        Class
                    </th>
                    <th>
                        Price
                    </th>
                    <th>
                        Aircraft Operator
                    </th>
                    <th>
                        Aircraft Logo
                    </th>
                    <th>
                        Trip Information
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($flights as $flight)
                    <tr>
                        <td>
                            {{ $flight->name['en'] }}
                        </td>
                        <td>
                            {{ $flight->ticket }}
                        </td>
                        <td>
                            {{ $flight->class['en'] }}
                        </td>
                        <td>
                            <ul>
                                <li>Adult: {{ $flight->price['adult'] }}</li>
                                <li>Children: {{ $flight->price['children'] }}</li>
                                <li>Baby: {{ $flight->price['baby'] }}</li>
                            </ul>
                        </td>
                        <td>
                            {{ $flight->aircraft_operator['en'] }}
                        </td>
                        <td>
                            <img src="{{ Storage::url($flight->aircraft_logo) }}" alt="" class="table-image">
                        </td>
                        <td>
                            <a href="#!" class="trip-info-modal btn btn-brand" data-toggle="modal"
                               data-target="#m_modal_2"
                               data-ticket="{{ $flight->ticket }}"
                               data-from-country="{{ route('showCountry',['country' => $flight->trip_information['common']['going']['from_country']]) }}"
                               data-to-country="{{ route('showCountry',['country' => $flight->trip_information['common']['going']['to_country']]) }}"
                               data-information="{{ json_encode($flight->trip_information) }}">
                                View
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('flightOrders',['flight' => $flight->id]) }}"
                               class="btn btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
                                <i class="fa flaticon-cart"></i>
                            </a>
                            <a href="{{ route('editFlight',['flight' => $flight->id]) }}"
                               class="btn btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
                                <i class="fa flaticon-edit-1"></i>
                            </a>
                            <a href="#!" data-url="{{ route('deleteFlight',['flight' => $flight->id]) }}"
                               data-toggle="modal" data-target="#m_modal_1"
                               class="delete-modal btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                <i class="fa flaticon-delete"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!--end: Datatable -->
        </div>
    </div>

    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Delete Flight
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure that you want to remove this flight ?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-danger" id="delete">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Trip Information
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Start date
                            </th>
                            <th>
                                End date
                            </th>
                            <th>
                                Country (from)
                            </th>
                            <th>
                                Country (to)
                            </th>
                            <th>
                                Airport (From)
                            </th>
                            <th>
                                Airport (To)
                            </th>
                            <th>
                                City (From)
                            </th>
                            <th>
                                City (To)
                            </th>
                            <th>
                                Lounge (From)
                            </th>
                            <th>
                                Lounge (To)
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="going">
                            <th scope="row">
                                Going
                            </th>
                            <td id="going-start-date">
                                -
                            </td>
                            <td id="going-end-date">
                                -
                            </td>
                            <td id="going-country-from">
                                -
                            </td>
                            <td id="going-country-to">
                                -
                            </td>
                            <td id="going-airport-from">
                                -
                            </td>
                            <td id="going-airport-to">
                                -
                            </td>
                            <td id="going-city-from">
                                -
                            </td>
                            <td id="going-city-to">
                                -
                            </td>
                            <td id="going-lounge-from">
                                -
                            </td>
                            <td id="going-lounge-to">
                                -
                            </td>
                        </tr>
                        <tr id="coming" class="m--hide">
                            <th scope="row">
                                Coming
                            </th>
                            <td id="coming-start-date">
                                -
                            </td>
                            <td id="coming-end-date">
                                -
                            </td>
                            <td id="coming-country-from">
                                -
                            </td>
                            <td id="coming-country-to">
                                -
                            </td>
                            <td id="coming-airport-from">
                                -
                            </td>
                            <td id="coming-airport-to">
                                -
                            </td>
                            <td id="coming-city-from">
                                -
                            </td>
                            <td id="coming-city-to">
                                -
                            </td>
                            <td id="coming-lounge-from">
                                -
                            </td>
                            <td id="coming-lounge-to">
                                -
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
@endsection

@section('scripts')
    <script src="{{ asset('default-assets/demo/default/custom/components/datatables/base/html-table.js') }}"
            type="text/javascript"></script>
    <script>
        $(document).on('click', '.delete-modal', function () {
            $('#delete').val($(this).data('url'));
        });

        $("#delete").click(function () {
            window.location = $(this).val();
        });

        $(document).on('click', '.trip-info-modal', function () {
            information = $(this).data('information');
            ticket = $(this).data('ticket');

            // add going trip info
            $('#going-start-date').text(information.common.going.start_date);
            $('#going-end-date').text(information.common.going.end_date);
            $.get($(this).data('from-country'), function (data) {
                $('#going-country-from').text(data.country.name.en);
            });
            $.get($(this).data('to-country'), function (data) {
                $('#going-country-to').text(data.country.name.en);
            });
            $('#going-airport-from').text(information.en.going.from_airport);
            $('#going-airport-to').text(information.en.going.to_airport);
            $('#going-city-from').text(information.en.going.from_city);
            $('#going-city-to').text(information.en.going.to_city);
            $('#going-lounge-from').text(information.en.going.from_lounge);
            $('#going-lounge-to').text(information.en.going.to_lounge);

            // add coming trip info if exist.
            if (ticket === 'RoundTrip') {
                $('#coming').removeClass('m--hide');
                $('#coming-start-date').text(information.common.coming.start_date);
                $('#coming-end-date').text(information.common.coming.end_date);
                $.get($(this).data('to-country'), function (data) {
                    $('#coming-country-from').text(data.country.name.en);
                });
                $.get($(this).data('from-country'), function (data) {
                    $('#coming-country-to').text(data.country.name.en);
                });
                $('#coming-airport-from').text(information.en.coming.from_airport);
                $('#coming-airport-to').text(information.en.coming.to_airport);
                $('#coming-city-from').text(information.en.coming.from_city);
                $('#coming-city-to').text(information.en.coming.to_city);
                $('#coming-lounge-from').text(information.en.coming.from_lounge);
                $('#coming-lounge-to').text(information.en.coming.to_lounge);
            }
        });
    </script>
@endsection
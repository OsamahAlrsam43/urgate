@extends('layouts.master')

@section('page-title')
    Charter Flights
@endsection

@section('sub-header')
    @if(!$isArchive) Charter Flights @else Archived Flighted @endif
@endsection

@section('content')
    @include('includes.info-box')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                @if(!$isArchive)
                <a href="{{ route('createCharter') }}"
                   class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill pull-right mt-3">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>New Charter Flight</span>
                            </span>
                </a>
                @endif

                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        @if(!$isArchive) Charter Flights @else Archived Flighted @endif
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            @if(!$isArchive)
            <div class="row mb-3">
                <div class="col-lg-12 mb-2">
                    <h4>Search flights</h4>
                </div>

                <div class="col-lg-3">
                    <label>Flight <span class="text-danger">type</span></label>
                    <div class="input-group m-input-group m-input-group--square">
                        <select name="flight_type" class="form-control m-input">
                            <option value="">All Types</option>
                            <option value="OneWay">One Way</option>
                            <option value="RoundTrip">Round Trip</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <label><span class="text-danger">From</span> Date</label>
                    <div class="input-group m-input-group m-input-group--square">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="date" name="from_date" class="form-control m-input date-picker"
                               value="{{ old('from_date') }}">
                    </div>
                </div>

                <div class="col-lg-3">
                    <label><span class="text-danger">To</span> Date</label>
                    <div class="input-group m-input-group m-input-group--square">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="date" name="to_date" class="form-control m-input date-picker"
                               value="{{ old('to_date') }}">
                    </div>
                </div>

                <div class="col-lg-3 pt-2">
                    <button type="button" class="btn btn-primary mt-4" id="search-flights">
                        Search Flights
                    </button>
                </div>

                <div class="col-lg-12 mt-5">
                    <h4>List flights</h4>
                </div>
            </div>
            @endif
            <!--begin: Datatable -->
            <table id="data-tables" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Flight Type</th>
                    <th>Air craft</th>
                    <th>Departure Date</th>
                    <th>Departure Time</th>
                    <th>Business Seats</th>
                    <th>Economy Seats</th>
                    <th>Commission</th>
                    <th>Special Commission</th>
                    <th>Locked Seats</th>
                    <th>Copy Flight</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
            <!--end: Datatable -->
        </div>

        <!--begin::Modal-->
        <div class="modal fade" id="delete-charter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
    </div>
@endsection

@section('styles')
    <style>
        tr.locked {
            background: rgba(113, 106, 203, 0.25) !important;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

    <script>
        $(function () {
            $(document).on('click', '.delete-modal', function () {
                $('#delete').val($(this).data('url'));
            });

            $("#delete").click(function () {
                window.location = $(this).val();
            });

            var table = $('#data-tables').DataTable({
                serverSide: true,
                processing: true,
                scrollX: true,
                fixedColumns: {
                    leftColumns: 1,
                    rightColumns: 1,
                },
                ajax: {
                    url: "{{ route('charterData', ['show' => request()->get("show")]) }}",
                    type: 'GET',
                    data: function (d) {
                        d.flight_type = $('[name=flight_type]').val();
                        d.from_date = $('[name=from_date]').val();
                        d.to_date = $('[name=to_date]').val();
                    }
                },
                order: [[ 3, "asc" ]],
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'flight_type'},
                    {data: 'aircraft_id'},
                    {data: 'flight_date'},
                    {data: 'departure_time'},
                    {data: 'business_seats'},
                    {data: 'economy_seats'},
                    {data: 'commission'},
                    {data: 'special_commission'},
                    {data: 'locked_seats'},
                    {data: 'Copy_Flight'},
                    {data: 'actions'},
                ],
                rowCallback: function (row, data, index) {
                    if (data.locked == 1) {
                        $(row).addClass('locked');
                    }

                    var css = {
                        td: {
                            padding: 0,
                            background: '#716acb'
                        },
                        ul: {
                            "padding": "0",
                            "margin": "0",
                            "listStyle": "none"
                        },
                        li: {
                            "float": "left",
                            "width": "calc(100%/3)",
                            "lineHeight": "51px",
                            "textAlign": "center",
                            "fontSize": "14px",
                            "color": "#fff",
                            "fontFamily": "tahoma",
                            "fontWeight": "600"
                        },
                        lastLi: {
                            "background": "#34bfa3"
                        },
                        midLi: {
                            "background": "#41A3F6"
                        }
                    };


                    if (data.business_seats !== 0) {
                        $(row).find('td:eq(6)').css(css.td);
                        $(row).find('td:eq(6)').find('ul').css(css.ul);
                        $(row).find('td:eq(6)').find('ul').find('li').css(css.li);
                        $(row).find('td:eq(6)').find('ul').find('li').eq(1).css(css.midLi);
                        $(row).find('td:eq(6)').find('ul').find('li').last().css(css.lastLi);
                    }

                    if (data.economy_seats !== 0) {
                        $(row).find('td:eq(7)').css(css.td);
                        $(row).find('td:eq(7)').find('ul').css(css.ul);
                        $(row).find('td:eq(7)').find('ul').find('li').css(css.li);
                        $(row).find('td:eq(7)').find('ul').find('li').eq(1).css(css.midLi);
                        $(row).find('td:eq(7)').find('ul').find('li').last().css(css.lastLi);
                    }
                }
            });

            $('#search-flights').on('click', function () {
                table.draw();
            });
        });
    </script>
@endsection
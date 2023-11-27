@extends('layouts.master')

@section('page-title')
    Flight ({{$charter->name}}) orders
@endsection

@section('sub-header')
    Orders
@endsection

@section('content')
    @include('includes.info-box')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <a href="#" data-link="{{route('charterOrdersDownload', ['charter' => $charter->id])}}"
                   class="btn btn-brand btn-sm pull-right mt-4" id="download-passengers">
                    <i class="fa fa-download" style="font-size: 14px;"></i> Download Passengers Data
                </a>

                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Flight ({{$charter->name}}) orders
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">

            <!--begin: Datatable -->
            <table id="data-tables" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Flight Name</th>
                    <th>Order Type</th>
                    <th>Flight Date</th>
                    <th>Company</th>
                    <th>Price</th>
                    <th>Commission</th>
                    <th>PNR</th>
                    <th>Phone</th>
                    <th>Note</th>
                    <th>Created at</th>
                    <th>Flight Class</th>
                    <th>Flights</th>
                    <th>Passengers</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
            <!--end: Datatable -->

            <div class="d-table w-100">
                <table class="table pull-right w-50 mt-4">
                    <tr>
                        <th>Buy/Total (Economy Seats)</th>
                        <th class="text-right">
                            <span class="text-danger"> {{$stats['sold_economy_seats']}}  {{--  $users->count() --}}</span>
                            /
                            <span class="text-success">{{$stats['total_economy_seats']}}</span>
                        </th>
                    </tr>
                    <tr>
                        <th>Buy/Total (Business Seats)</th>
                        <th class="text-right">
                            <span class="text-danger">{{$stats['sold_business_seats']}}</span>
                            /
                            <span class="text-success">{{$stats['total_business_seats']}}</span>
                        </th>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <th class="text-right">${{$stats['total_amount']}}</th>
                    </tr>
                    <tr>
                        <th>Total Agent Commission</th>
                        <th class="text-right">${{$stats['total_commission']}}</th>
                    </tr>
                    <tr>
                        <th>Total Price (Excluding Commissions)</th>
                        <th class="text-right">${{$stats['total_profit']}}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!--begin::Modal-->
    <div class="modal fade" id="flights-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Order Flights
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <table class="table table-bordered" id="flight-table">
                        <thead>
                        <tr>
                            <th>Flight</th>
                            <th>Departure Date</th>
                            <th>Price</th>
                            <th>Commission</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
@endsection

@section('styles')
    <link href="{{asset('public/assets/css/styles.css')}}" rel="stylesheet">
    <style>
        tr.cancelled {
            background: #f4516c59 !important;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('default-assets/demo/default/custom/components/forms/widgets/select2.js') }}"
            type="text/javascript"></script>

    <script type="template" id="select-user">
        <div class="form-group">
            <h5>Select User</h5>
            <select class="form-control" id="user">
                <option value="0">All Users</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}">({{$user->id}}) - {{$user->name}}</option>
                @endforeach
            </select>
        </div>
    </script>

    <script>
        $('#download-passengers').on('click', function (e) {
            e.preventDefault();

            let link = $(this).data("link");
            $.confirm({
                title: 'Download Passengers Data',
                columnClass: 'col-md-6 col-md-offset-4',
                buttons: {
                    download: {
                        text: 'Download',
                        action: function () {
                            let user = $('#user').val();
                            window.location = `${link}?user=${user}`
                        }
                    },
                    cancel: {}
                },
                content: $('#select-user').html()
            });
        });
    </script>

    <script>
        $('body').on('click', '.confirm-cancel', function () {
            let $this = $(this),
                isRebook = $(this).hasClass("rebook-order");

            let link = isRebook ? '{{route('rebookCharterForm')}}' : '{{route('cancelCharterForm')}}';
            link += `?id=${$this.data('id')}`;

            $.confirm({
                title: $this.data("title"),
                columnClass: 'col-md-6 col-md-offset-4',
                buttons: {
                    formSubmit: {
                        text: 'Confirm',
                        action: function () {
                            this.$content.find('form')[0].submit();
                        }
                    },
                    cancel: {}
                },
                content: function () {
                    var self = this;
                    return $.ajax({
                        url: link,
                        method: 'get'
                    }).done(function (response) {
                        response = isRebook ? response.replace('{form-action}', '{{route('rebook-charter-ticket', ['charter'=>$charter->id])}}?order=' + $this.data('id')) : response.replace('{form-action}', '{{route('cancel-charter-ticket', ['charter'=>$charter->id])}}?order=' + $this.data('id'));

                        self.setContent(response);
                    }).fail(function () {
                        self.setContent('Something went wrong.');
                    });
                },
                onContentReady: function () {
                    // bind to events
                }
            })
        });

        var table = $('#data-tables').DataTable({
            serverSide: true,
            processing: true,
            scrollX: true,
            ajax: "{{route('charterOrdersData', ['charter' => $charter->id])}}",
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 3,
            },
            order: [[ 0, "desc" ]],
            columns: [
                {data: 'id'},
                {data: 'status'},
                {data: 'name'},
                {data: 'flight_type'},
                {data: 'date'},
                {data: 'user_id'},
                {data: 'price'},
                {data: 'commission'},
                {data: 'pnr'},
                {data: 'phone'},
                {data: 'note'},
                {data: 'created_at'},
                {data: 'flight_class'},
                {data: 'flights'},
                {data: 'passengers'},
                {data: 'actions'},
            ],
            rowCallback: function (row, data, index) {
                if (data.status === 'Cancelled') {
                    $(row).addClass('cancelled');
                }
            }
        });

        $('#data-tables tbody').on('click', '.show-flights', function () {
            var $this = $(this);
            $.ajax({
                url: "{{route('charterOrderFlights')}}?order=" + $this.data('id'), success: function (results) {
                    var flightTable = $("#flight-table");
                    flightTable.find('tbody').html('');

                    $.each(JSON.parse(results), function (index, result) {
                        var charter = result.charter;

                        flightTable.find('tbody').append('<tr>' +
                            '<td>' + charter.name + '</td>' +
                            '<td>' + charter.flight_date + '</td>' +
                            '<td>' + result.price + '</td>' +
                            '<td>' + result.commission + '</td>' +
                            '</tr>');
                    });

                    $("#flights-modal").modal('show');
                }
            });
        });
    </script>
@endsection
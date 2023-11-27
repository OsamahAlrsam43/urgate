@extends('layouts.master')

@section('page-title')
    Orders
@endsection

@section('sub-header')
    Flight
@endsection

@section('styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet"
          type="text/css"/>

    <style>
        .days-filter {
            margin: 20px 0;
            width: 250px;
        }

        .days-filter label {
            font-weight: bold;
        }
    </style>
@endsection


@section('content')
    @include('includes.info-box')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Flight order history
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">

            <div class="days-filter">
                <form style="margin-bottom: 10px;">
                    <label>Filter by day</label>
					<?php
					$day = Request()->get( "day" );
					if ( ! isset( $day ) ) {
						$day = "all";
					}

					$classes = [
						"أحادية",
						"ثنائية",
						"ثلاثية",
					];
					?>
                    <select name="day" class="form-control" onchange="this.form.submit()">
                        <option value="all" @if($day == "all") selected @endif>All Orders</option>
                        @foreach($travel->price as $k=>$price)
                            <option value="{{$k+1}}" @if($day == $k+1) selected @endif>{{$classes[$k]}}</option>
                        @endforeach
                    </select>
                </form>

                <a href="{{route("travelOrdersDownload", ["travels" => $travel])}}?day={{$day}}" class="btn btn-brand">Download
                    Passengers Data</a>
            </div>

            <hr>

            <!--begin: Datatable -->
            <table id="ticketsTable" class="display nowrap example" style="width:100%">
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Flight no.
                    </th>
                    <th>
                        Price
                    </th>
                    <th>
                        PNR
                    </th>
                    <th>
                        Company
                    </th>
                    <th>
                        Flight Date
                    </th>
                    <th>
                        Created at
                    </th>
                    <th>
                        Ticket
                    </th>
                    <th>
                        Edit
                    </th>
                    <th>
                        Cancel
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($travels as $flight)
					<?php rowDrawer( $flight, $travel ) ?>
                @endforeach
                </tbody>
            </table>
            <!--end: Datatable -->
        </div>
    </div>

    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Cancel travels
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="cancel-form">
                        <div class="form-group">
                            <label>Return fees?</label>
                            <input type="number" class="form-control" value="0" name="fees">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-danger" id="cancel">
                        Yes, Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Upload Flight Document
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#!"
                          method="post" enctype="multipart/form-data" id="upload-document">
                        <div class="form-group m-form__group row">
                            {!! csrf_field() !!}
                            <div class="col-lg-12">
                                <label>
                                    Thumb:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="file" name="pdf" class="form-control m-input">
                                </div>
                                <span class="m-form__help">
                                    Please select your flight document.
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-danger" id="upload">
                        Upload
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

	<?php
	function rowDrawer($flight, $travel) {
	?>
    <tr>
        <td>
            {{ $flight->id }}
        </td>
        <td>
            {{ $travel->name['en'] }}
        </td>
        <td>
            {{ $travel->flight_number }}
        </td>
        <td>
            {{ $flight->price }}
        </td>
        <td>
            {{ $flight->pnr }}
        </td>
        <td>
            {{ $flight->user->company }}
        </td>
        <td>
            {{ $travel->from_date }} ({{ $travel->from_time }})
        </td>
        <td>
            {{ $flight->created_at->format('Y-m-d (h:s A)') }}
        </td>
        <td>
            @if($flight->status == "canceled")
                Cancelled
            @else
                <a href="{{ route('download-travel-ticket', ['order' => $flight->pnr]) }}"
                   class="trip-info-modal btn btn-brand">
                    <i class="fa fa-download"></i>
                    Ticket
                </a>
            @endif
        </td>
        <td>
            @if($flight->status !== 'canceled')
                <a href="{{ route('editTravelOrder', ['order' => $flight->id, 'travel' => $travel->id]) }}"
                   class="trip-info-modal btn btn-brand">
                    <i class="fa fa-edit"></i>
                    Edit
                </a>
            @else
                Cancelled
            @endif
        </td>
        <td>
            @if($flight->status == "canceled")
                Cancelled
            @else
				<?php
				$commission = 0;
				if ( $travel->commission > 0 ) {
					$commissionObject = getCommission( $travel );
					$commission       = $commissionObject['commission'];

					if ( $commissionObject['is_percent'] ) {
						$commission = ( $flight->price * $commissionObject['commission'] ) / 100;
					}
				}
				?>
                <a href="#!"
                   data-url="{{ route('cancel-travel-ticket', ['order' => $flight->id, 'travel' => $travel->id]) }}"
                   data-toggle="modal" data-target="#m_modal_2" data-price="{{($flight->price - $commission)}}"
                   class="cancel-chart-modal btn btn-danger">
                    <i class="fa fa-close"></i>
                    Cancel
                </a>
            @endif
        </td>
    </tr>
	<?php
	}
	?>
@endsection

@section('scripts')
    <script src="{{ asset('default-assets/demo/default/custom/components/datatables/base/html-table.js') }}"
            type="text/javascript"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"
            type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"
            type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"
            type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"
            type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"
            type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            var table = $('#ticketsTable').DataTable({
                responsive: true,
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "oSelectorOpts": {filter: 'applied', order: 'current'},
                "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                "order": [[0, 'desc']]
            });

            @if(Request()->get("pnr"))
            table.search('{{Request()->get("pnr")}}').draw();
            @endif
        });
    </script>
    <script>
        $(document).on('click', '.change-status', function () {
            $('#upload-document').attr('action', $(this).data('approve'));
        });
        $("#upload").click(function () {
            $('#upload-document').submit();
        });

        $('.cancel-chart-modal').on('click', function () {
            var price = $(this).data('price');
            $('[name=fees]').val(price);

            var flights = $(this).data('flights');

            var options = '<option value="0">All Flight</option>';
            $.each(flights, function (i, flight) {
                options += '<option value="' + flight[0] + '">' + flight[1] + '</option>';
            });

            $('[name=flight]').html(options);

            $('#cancel-form').attr('action', $(this).data('url') + '?fees=' + price + '&flight=0');
        });

        $('#cancel').on('click', function () {
            $('#cancel-form').submit();
        });
    </script>
@endsection
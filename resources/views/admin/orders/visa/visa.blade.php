@extends('layouts.master')

@section('page-title')
    Orders
@endsection

@section('sub-header')
    Visa
@endsection

@section('styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
@endsection

@section('content')
    @include('includes.info-box')
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Search Details.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
            <!-- <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="get"
                      action="{{ route('searchUserHistory') }}" enctype="multipart/form-data"> -->
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-6">
                            <label for="date">
                                Date (from):
                            </label>
                        <!-- <input id="date" type="date" name="from" class="form-control m-input"
                                       value="{{ old('from') }}"> -->
                            <input name="min" id="min" type="text" class="form-control m-input">
                            <span class="m-form__help">
                                    Please enter valid date
                                </span>
                        </div>
                        <div class="col-lg-6">
                            <label for="date">
                                Date (to):
                            </label>
                        <!-- <input id="date" type="date" name="to" class="form-control m-input"
                                       value="{{ old('to') }}"> -->
                            <input name="max" id="max" type="text" class="form-control m-input">
                            <span class="m-form__help">
                                    Please enter valid date
                                </span>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--solid">
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-8">
                                <!-- <button type="submit" class="btn btn-primary">
                                    Search
                                </button> -->
                            <!-- <a href="{{ route('user-profile') }}" class="btn btn-secondary">
                                        Cancel
                                    </a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </form> -->
                <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Visa order history
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
                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <table id="example" class="display  example " >
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Visa Type
                    </th>
                    <th>
                        First name
                    </th>
                    <th>
                        Last name
                    </th>
                    <th>
                        Birth date
                    </th>
                    <th>
                        Passport number
                    </th>
                    <th>
                        Passport issuance date
                    </th>
                    <th>
                        Passport expire date
                    </th>
                    <th>
                        Price
                    </th>
                    <th>
                        Pnr
                    </th>
                    <th>
                        Created at
                    </th>
                    <th>
                        Passport image
                    </th>
                    <th>
                        Personal image
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Delivered By
                    </th>
                    <th>
                        Delivered To
                    </th>
                    <th>
                        Actions
                    </th>
                    <th>
                        Reject
                    </th>
                    <th>
                        Cancel
                    </th>
                    <th>
                        Receive
                    </th>
                    <th>
                        Edit
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($visas as $visa)
                    <tr>

                        <td>
                            {{ $visa->id }}
                        </td>
                        <td>
                            {{ $visa->visa ? $visa->visa->visa_type['en'] : "" }}
                        </td>
                        <td>
                            {{ $visa->first_name }}
                        </td>
                        <td>
                            {{ $visa->last_name }}
                        </td>
                        <td>
                            {{ $visa->birth_date ? $visa->birth_date->format('Y-m-d') : "" }}
                        </td>
                        <td>
                            {{ $visa->passport_number }}
                        </td>
                        <td>
                            {{ $visa->passport_issuance_date ? $visa->passport_issuance_date->format('Y-m-d') : "" }}
                        </td>
                        <td>
                            {{ $visa->passport_expire_date ? $visa->passport_expire_date->format('Y-m-d') : "" }}
                        </td>
                        <td>
                            {{ $visa->price }}
                        </td>
                        <td>
                            {{ $visa->pnr ?? '' }}
                        </td>
                        <td>
                            {{ $visa->created_at->format('Y-m-d (h:s A)') }}
                        </td>
                        <td>
                            <img src="{{ Storage::url($visa->passport_image) }}" alt=""
                                 style="width: 100px;height: 100px;">
                        </td>
                        <td>
                            <img src="{{ Storage::url($visa->personal_image) }}" alt=""
                                 style="width: 100px;height: 100px;">
                        </td>
                        <td>
                            @if($visa->status === '1')
                                Delivered
                            @elseif($visa->status === 'rejected')
                                Rejected
                            @elseif($visa->status === 'canceled')
                                Canceled
                            @elseif($visa->status === 'received')
                                Received
                            @else
                                Pending
                            @endif
                        </td>
                        <td>
                            {{ $visa->delivered_by ? $visa->deliveredBy->name : '-' }}
                        </td>
                        <td>
                            {{ $visa->user ? $visa->user->name : "" }}
                        </td>
                        <td>
                            @if($visa->status === '0'||$visa->status === 'received')
                                <a href="#!" data-toggle="modal" data-target="#m_modal_1"
                                   data-approve="{{ route('changeVisaStatus',['visa' => $visa->visa_id,'order' => $visa->id]) }}"
                                   class="change-status trip-info-modal btn btn-brand">
                                    Approve
                                </a>
                            @elseif($visa->status === '1')
                                <a href="#!" class="trip-info-modal btn btn-success">
                                    Delivered
                                </a>
                            @else
                                {{ $visa->status  }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('changeVisaStatusToReject',['visa' => $visa->visa_id,'order' => $visa->id]) }}"
                               class="trip-info-modal btn btn-brand">
                                Reject
                            </a>
                        </td>

                        <td>
                            <a href="{{ route('changeVisaStatusToCancel',['visa' => $visa->visa_id,'order' => $visa->id]) }}"
                               class="trip-info-modal btn btn-brand">
                                Cancel
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('changeVisaStatusToReceive',['visa' => $visa->visa_id,'order' => $visa->id]) }}"
                               class="trip-info-modal btn btn-brand">
                                Receive
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('editVisaOrder',['visa' => $visa->visa_id,'order' => $visa->id]) }}"
                               class="trip-info-modal btn btn-brand">
                                Edit
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
                        Upload Visa Document
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
                                    Please select your flight thumb.
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
            $('#example').DataTable({
                responsive: true,
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "oSelectorOpts": {filter: 'applied', order: 'current'},
                "mColumns": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                "order" : [[0,'desc']]

            });

            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min').datepicker("getDate");
                    var max = $('#max').datepicker("getDate");
                    var startDate = new Date(data[12]);
                    if (min == null && max == null) { return true; }
                    if (min == null && startDate <= max) { return true;}
                    if(max == null && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }

            );


            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            var table = $('.example').DataTable();

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
        });
    </script>
    <script>
        $(document).on('click', '.change-status', function () {
            $('#upload-document').attr('action', $(this).data('approve'));
        });
        $("#upload").click(function () {
            $('#upload-document').submit();
        });
    </script>
@endsection
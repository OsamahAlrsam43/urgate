@extends('layouts.master')

@section('page-title')
    History
@endsection

@section('sub-header')
    History Search
@endsection

@section('styles')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
    <script src="https://cdn.datatables.net/plug-ins/1.10.19/filtering/row-based/range_dates.js"></script>      

@endsection

@section('content')
    @if(!$travels->count() && !$flights->count() && !$visas->count())
        <div class="alert m-alert m-alert--default alert-danger" role="alert">
            No records found.
        </div>
    @endif
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
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="get"
                      action="{{ route('searchUserHistory') }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label for="date">
                                    Date (from):
                                </label>
                                <input id="date" type="date" name="from" class="form-control m-input"
                                       value="{{ $_GET['from'] }}">
                                <span class="m-form__help">
                                    Please enter valid date
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label for="date">
                                    Date (to):
                                </label>
                                <input id="date" type="date" name="to" class="form-control m-input"
                                       value="{{ $_GET['to'] }}">
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
                                    <button type="submit" class="btn btn-primary">
                                        Search
                                    </button>
                                    <a href="{{ route('user-profile') }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                        orders history
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Datatable -->
            <table id="" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>
                        Type
                    </th>
                    <th>
                        First name
                    </th>
                    <th>
                        Last name
                    </th>
                    <th>
                        Birth place
                    </th>
                    <th>
                        Birth date
                    </th>
                    <th>
                        Nationality
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
                        Father name
                    </th>
                    <th>
                        Mother name
                    </th>
                    <th>
                        Price
                    </th>
                    <th>
                        Created at
                    </th>
                    <th>
                        Delivered By
                    </th>
                    <th>
                        Delivered To
                    </th>
                    <th>
                        Status
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($flights as $flight)
                    <tr>
                        <td>
                            Flight
                        </td>
                        <td>
                            {{ $flight->first_name }}
                        </td>
                        <td>
                            {{ $flight->last_name }}
                        </td>
                        <td>
                            {{ $flight->birth_place }}
                        </td>
                        <td>
                            {{ $flight->birth_date->format('Y-m-d') }}
                        </td>
                        <td>
                            {{ $flight->nationality }}
                        </td>
                        <td>
                            {{ $flight->passport_number }}
                        </td>
                        <td>
                            {{ $flight->passport_issuance_date->format('Y-m-d') }}
                        </td>
                        <td>
                            {{ $flight->passport_expire_date->format('Y-m-d') }}
                        </td>
                        <td>
                            {{ $flight->father_name }}
                        </td>
                        <td>
                            {{ $flight->mother_name }}
                        </td>
                        <td>
                            {{ $flight->price }}
                        </td>
                        <td>
                            {{ $flight->created_at->format('Y-m-d (h:s A)') }}
                        </td>
                        <td>
                            {{ $flight->delivered_by ? $flight->deliveredBy->name : '-' }}
                        </td>
                        <td>
                            {{ $flight->user->name }}
                        </td>
                        <td>
                            @if($flight->status === '1')
                                Delivered
                                <a href="{{ route('flightDownloadPdf',['flight' => $flight->id]) }}">@lang("Download pdf")</a>
                            @else
                                {{ $flight->status === '0' ? 'Pending' : $flight->status }}
                            @endif
                        </td>
                    </tr>
                @endforeach

                @foreach($travels as $travel)
                    <tr>
                        <td>
                            Travel
                        </td>
                        <td>
                            {{ $travel->first_name }}
                        </td>
                        <td>
                            {{ $travel->last_name }}
                        </td>
                        <td>
                            {{ $travel->birth_place }}
                        </td>
                        <td>
                            {{ $travel->birth_date->format('Y-m-d') }}
                        </td>
                        <td>
                            {{ $travel->nationality }}
                        </td>
                        <td>
                            {{ $travel->passport_number }}
                        </td>
                        <td>
                            {{ $travel->passport_issuance_date->format('Y-m-d') }}
                        </td>
                        <td>
                            {{ $travel->passport_expire_date->format('Y-m-d') }}
                        </td>
                        <td>
                            {{ $travel->father_name }}
                        </td>
                        <td>
                            {{ $travel->mother_name }}
                        </td>
                        <td>
                            {{ $travel->price }}
                        </td>
                        <td>
                            {{ $travel->created_at->format('Y-m-d (h:s A)') }}
                        </td>
                        <td>
                            {{ $travel->delivered_by ? $travel->deliveredBy->name : '-' }}
                        </td>
                        <td>
                            {{ $travel->user->name }}
                        </td>
                        <td>
                            @if($travel->status === '1')
                                Delivered
                                <a href="{{ route('travelDownloadPdf',['travel' => $travel->id]) }}">Download pdf</a>
                            @else
                                {{ $travel->status === '0' ? 'Pending' : $travel->status }}
                            @endif
                        </td>
                    </tr>
                @endforeach

                @foreach($visas as $visa)
                    <tr>
                        <td>
                            Visa
                        </td>
                        <td>
                            {{ $visa->first_name }}
                        </td>
                        <td>
                            {{ $visa->last_name }}
                        </td>
                        <td>
                            {{ $visa->birth_place }}
                        </td>
                        <td>
                            {{ $visa->birth_date->format('Y-m-d') }}
                        </td>
                        <td>
                            {{ $visa->nationality }}
                        </td>
                        <td>
                            {{ $visa->passport_number }}
                        </td>
                        <td>
                            {{ $visa->passport_issuance_date->format('Y-m-d') }}
                        </td>
                        <td>
                            {{ $visa->passport_expire_date->format('Y-m-d') }}
                        </td>
                        <td>
                            {{ $visa->father_name }}
                        </td>
                        <td>
                            {{ $visa->mother_name }}
                        </td>
                        <td>
                            {{ $visa->price }}
                        </td>
                        <td>
                            {{ $visa->created_at->format('Y-m-d (h:s A)') }}
                        </td>
                        <td>
                            {{ $visa->delivered_by ? $visa->deliveredBy->name : '-' }}
                        </td>
                        <td>
                            {{ $visa->user->name }}
                        </td>
                        <td>
                            @if($visa->status === '1')
                                Delivered
                                <a href="{{ route('visaDownloadPdf',['visa' => $visa->id]) }}">Download pdf</a>
                            @else
                                {{ $visa->status === '0' ? 'Pending' : $visa->status }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!--end: Datatable -->
        </div>
    </div>

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        ({{ Auth::user()->name }}) transactions history
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Datatable -->
            <table id="" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>
                        Transaction Type
                    </th>
                    <th>
                        From
                    </th>
                    <th>
                        To
                    </th>
                    <th>
                        Amount
                    </th>
                    <th>
                        Date
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>
                            {{ $transaction->type }}
                        </td>
                        <td>
                            {{ $transaction->fromUser->name }}
                        </td>
                        <td>
                            {{ $transaction->toUser->name }}
                        </td>
                        <td>
                            {{ $transaction->amount }}
                        </td>
                        <td>
                            {{ $transaction->created_at->format('Y-m-d (h:s A)') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!--end: Datatable -->
        </div>
    </div>
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
            $('table.display').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                scrollX: true,
                buttons: [
                    'excel', 'pdf', 'print'
                ],
                "order" : [[0,'desc']]
            });
        });

        

    </script>
@endsection
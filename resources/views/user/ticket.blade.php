@extends('layouts.master')

@section('page-title')
    Search Tickets
@endsection

@section('sub-header')
    Search Tickets
@endsection

@section('content')
    @include('includes.info-box')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Search Tickets
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <form>
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">

                                        <input type="text" name="search" class="form-control m-input m-input--solid"
                                               placeholder="Search by PNR..." id="generalSearch">
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
            </form>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <table class="m-datatable" id="html_table" width="100%">
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Flight no.
                    </th>
                    <th>
                        PNR
                    </th>
                    <th>
                        Company
                    </th>
                    <th>
                        Phone
                    </th>
                    <th>
                        Created at
                    </th>
                    <th>
                        Ticket
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                            {{ $order->id }}
                        </td>
                        <td>
                            {{ $order->charter->flight_number }}
                        </td>
                        <td>
                            {{ $order->pnr }}
                        </td>
                        <td>
                            {{ $order->user->company }}
                        </td>
                        <td>
                            {{ $order->phone }}
                        </td>
                        <td>
                            {{ $order->created_at->format('Y-m-d (h:s A)') }}
                        </td>
                        <td>
                            @if($order->status !== 'canceled')
                                <a href="{{ route('charter-ticket', ['order' => $order->id]) }}" target="_blank"
                                   class="trip-info-modal btn btn-brand">
                                    <i class="fa fa-eye"></i>
                                    Ticket
                                </a>
                            @else
                                Cancelled
                            @endif
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
                        Cancel Flight
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure that you want to cancel this Flight ?
                    </p>
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

@endsection

@section('scripts')
    <script src="{{ asset('default-assets/demo/default/custom/components/datatables/base/html-table.js') }}"
            type="text/javascript"></script>
    <script>
        $(document).on('click', '.cancel-modal', function () {
            $('#cancel').val($(this).data('cancel-url'));
        });

        $("#cancel").click(function () {
            window.location = $(this).val();
        });
    </script>
@endsection
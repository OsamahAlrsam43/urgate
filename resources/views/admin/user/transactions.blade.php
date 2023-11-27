@extends('layouts.master')

@section('page-title')
    Transactions
@endsection

@section('sub-header')
    Transactions
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
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="get"
                      action="{{ route('userTransactions',['user' => $user->id]) }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label for="date">
                                    Date (from):
                                </label>
                                <input id="date" type="date" name="from" class="form-control m-input"
                                       value="{{ old('from') }}">
                                <span class="m-form__help">
                                    Please enter valid date
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label for="date">
                                    Date (to):
                                </label>
                                <input id="date" type="date" name="to" class="form-control m-input"
                                       value="{{ old('to') }}">
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
                        ({{ $user->name }}) transactions history
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Datatable -->
            <table id="example" class="display nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        From
                    </th>
                    <th>
                        Transaction Type
                    </th>
                    <th>
                        PNR
                    </th>
                    <th>
                        Related Process
                    </th>
                    <th>
                        Opening Balance
                    </th>
                    <th>
                        Amount
                    </th>
                    <th>
                        End Balance
                    </th>
                    <th>
                        comment
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
                            {{ $transaction->id }}
                        </td>
                        <td>
                            {{ $transaction->fromUser->name }}
                        </td>
                        <td>
                            @if($transaction->type == "withdrawal")
                                <span class="text-danger">Withdrawal</span>
                            @else
                                <span class="text-success">Deposit</span>
                            @endif
                        </td>
                        <td>
                            {{ $transaction->pnr }}
                        </td>
                        <td>
                            @if($transaction->connectedID != null )
                                @switch($transaction->connectedTable)
                                    @case("visa")
                                    <span>Visa #{{ $transaction->connectedID }}</span>
                                    @break
                                    @case("flight")
                                    <span>Flight #{{ $transaction->connectedID }}</span>
                                    @break
                                    @case("travel")
                                    <span>Travel #{{ $transaction->connectedID }}</span>
                                    @break
                                    @case("charter")
                                    <span>Charter #{{ $transaction->connectedID }}</span>
                                    @break
                                @endswitch
                            @else
                                Direct Transaction
                            @endif
                        </td>
                        <td>
                            {{ $transaction->creditBefore }}
                        </td>
                        <td>
                            {{ $transaction->amount }}
                        </td>
                        <td>
                            {{ $transaction->creditAfter }}
                        </td>
                        <td>
                            {{ $transaction->comment }}
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
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "order": [[0, 'desc']]
            });
        });
    </script>
@endsection
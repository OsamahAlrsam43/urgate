@extends('layouts.master')

@section('page-title')
    Invoices
@endsection

@section('sub-header')
    Invoices - Update
@endsection

@section('content')
    @if(session()->has('success'))
        <div class="alert m-alert m-alert--default alert-success" role="alert">
            {{session()->get('success') }}
        </div>
    @endif
    @if(count($errors) > 0)
        <div class="m-alert m-alert--icon alert alert-danger" role="alert" id="m_form_1_msg">
            <div class="m-alert__icon">
                <i class="la la-warning"></i>
            </div>
            <div class="m-alert__text">
                Oh snap! Change a few things up and try submitting again.
            </div>
            <div class="m-alert__close">
                <button type="button" class="close" data-close="alert" aria-label="Close"></button>
            </div>
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
                                Invoice Details.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('updateInvoice',['invoice' => $invoice->id]) }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label>
                                    Company Name
                                </label>
                                <input type="text" name="company" class="form-control m-input"
                                       placeholder="Enter company name"
                                       value="{{ $invoice->company ? $invoice->company : old('company') }}">
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    From Date
                                </label>
                                <input type="date" name="from_date" class="form-control m-input"
                                       placeholder="Enter from date"
                                       value="{{ $invoice->from_date ? $invoice->from_date : old('from_date') }}">
                            </div>
                            <div class="col-lg-4">
                                <label>
                                    To Date
                                </label>
                                <input type="date" name="to_date" class="form-control m-input"
                                       placeholder="Enter to date"
                                       value="{{ $invoice->to_date ? $invoice->to_date : old('to_date') }}">
                            </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-8">
                                    <button type="submit" class="btn btn-primary">
                                        Save Changes
                                    </button>
                                    <a href="{{ route('listInvoices') }}" class="btn btn-secondary">
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

            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption" style="position: relative;">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Invoice Items.
                            </h3>
                        </div>

                        <a href="{{route('downloadInvoice',['invoice' => $invoice->id, 'from' => $invoice->from_date, 'to'=>$invoice->to_date])}}" class="btn btn-primary" style="position: absolute;right: 10px;top: 20px;">
                            Download PDF
                        </a>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('insertItem',['invoice' => $invoice->id]) }}" enctype="multipart/form-data">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-2">
                                <label>
                                    Type
                                </label>
                                <select name="item_type" class="form-control" required>
                                    <option></option>
                                    <option value="debitor">دفع</option>
                                    <option value="creditor">سند قبض</option>
                                    <option value="credit">رصيد سابق</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label>Date</label>
                                <input type="date" name="date" class="form-control m-input" placeholder="Date" required>
                            </div>
                            <div class="col-lg-2">
                                <label>Credit</label>
                                <input type="text" name="credit" class="form-control m-input" placeholder="Credit"
                                       value="0">
                            </div>
                            <div class="col-lg-4">
                                <label>Details</label>
                                <input type="text" name="details" class="form-control m-input" placeholder="Details">
                            </div>
                            <div class="col-lg-2">
                                <label>.</label>
                                <button type="submit" class="btn btn-primary" style="display: block;width: 100%;">
                                    Add Item
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                </form>
                <!--end::Form-->

                <div class="m-portlet__body">
                    <!--begin: Datatable -->
                    <table class="m-datatable" id="html_table" width="100%">
                        <thead>
                        <tr>
                            <th>
                                رقم الوصل
                            </th>
                            <th>
                                تاريخ الوصل
                            </th>
                            <th>
                                نوع الوصل
                            </th>
                            <th>
                                مدين
                            </th>
                            <th>
                                دائن
                            </th>
                            <th>
                                الرصيد
                            </th>
                            <th>
                                التفاصيل
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
						<?php
						$i = 1;
						$types = [
							'debitor'  => 'دفع',
							'creditor' => 'سند قبض',
							'credit'   => 'رصيد سابق',
						];
						?>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    {{ str_pad($i, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>
                                    {{ $item->date }}
                                </td>
                                <td>
                                    {{ $types[$item->item_type] }}
                                </td>
                                <td>
                                    {{ $item->item_type == 'debitor' ? $item->credit : 0 }}
                                </td>
                                <td>
                                    {{ $item->item_type == 'creditor' ? $item->credit : 0 }}
                                </td>
                                <td>
                                    {{ $item->credit_after }}
                                </td>
                                <td>
                                    {{ $item->details }}
                                </td>
                                <td>
                                    @if($i == count($items))
                                    <a href="#!" data-url="{{ route('deleteItem',['item' => $item->id, 'invoice' => $invoice->id]) }}"
                                       data-toggle="modal" data-target="#m_modal_1"
                                       class="delete-modal btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                        <i class="fa flaticon-delete"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
							<?php $i ++ ?>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>

    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Delete Item
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure that you want to remove this item?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-danger" id="save">
                        Yes, Delete
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
            $('#save').val($(this).data('url'));
        });

        $("#save").click(function () {
            window.location = $(this).val();
        });
    </script>
@endsection
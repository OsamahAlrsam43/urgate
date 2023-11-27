@extends('layouts.master')

@section('page-title')
    Users
@endsection

@section('sub-header')
    Users
@endsection

@section('content')
    @include('includes.info-box')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <a href="{{ route('createUser') }}"
                   class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill pull-right mt-3">
                            <span>
                                <i class="la la-plus-circle"></i>
                                <span>New User</span>
                            </span>
                </a>
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        List Users
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Balance</th>
                    <th>Type</th>
                    @if (! Auth::user()->type === 'GSA')
                    <th>Employees</th>
                @endif
                    <th>GSA List</th>
                    <th>Activation</th>
                    <th>Orders</th>
                    <th>Transactions</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
            <!--end: Datatable  -->
        </div>
    </div>

    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Delete User
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure that you want to remove this user ?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <a class="btn btn-danger" id="deleteBtn">
                        Yes, Delete
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Add Credit to <span id="user-name"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#!"
                          method="post" enctype="multipart/form-data" id="add-amount">
                        <div class="form-group m-form__group row">
                            {!! csrf_field() !!}
                            <div class="col-lg-12">
                                <label>
                                    Amount:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="number" name="amount" class="form-control m-input">
                                </div>
                                <span class="m-form__help">
                                    Please enter desired amount.
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-12">
                                <label>
                                    Transaction Type:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <select name="type" class="form-control m-input">
                                        <option value="DepositOfCredit">Deposit Of Credit</option>
                                        <option value="withdrawal">withdrawal</option>
                                    </select>
                                </div>
                                <span class="m-form__help">
                                    Please select Transaction Type.
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-12">
                                <label>
                                    Comment:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <textarea name="comment" class="form-control m-input"></textarea>
                                </div>
                                <!-- <span class="m-form__help">
                                    Please enter desired amount.
                                </span> -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-danger" id="add-amount-btn">
                        Yes, Add
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
@endsection

@section('styles')
    <style>
        .dropdown-item {
            width: auto;
        }
    </style>
@endsection

@section('scripts')
    <script type="template" id="credit-form-template">
        <form method="post" id="add-credit-form">
            {!! csrf_field() !!}
            <div class="form-group">
                <label>Enter amount</label>
                <input type="number" name="amount" value="0" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Transaction type</label>
                <select name="type" class="form-control">
                    <option value="DepositOfCredit">Deposit</option>
                    <option value="withdrawal">Withdraw</option>
                </select>
            </div>
            <div class="form-group">
                <label>Comment</label>
                <textarea name="comment" class="form-control" placeholder="Transaction description"></textarea>
            </div>
        </form>
    </script>
    <script>
        $(document).on('click', '.add-amount-modal', function () {
            $('#user-name').text($(this).data('username'));
            $('#add-amount').attr('action', $(this).data('credit-url'));
        });

        $(document).on('click', '.delete-modal', function () {
            $('#deleteBtn').attr('href', $(this).data('url'));
        });

        $("#add-amount-btn").click(function () {
            $('#add-amount').submit();
        });

        $('body').on('click', '.add-credit', function () {
            let $this = $(this);
            $.confirm({
                title: 'Make transaction',
                content: $('#credit-form-template').html(),
                buttons: {
                    formSubmit: {
                        text: 'Process Transaction',
                        btnClass: 'btn-success',
                        action: function () {
                            this.showLoading();
                            $('#add-credit-form').attr("action", $this.data('link'));
                            $('#add-credit-form').submit();

                            return false
                        }
                    },
                    cancel: {},
                }
            });
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
                url: "{{ route('usersData') }}",
                type: 'GET',
                data: function (d) {

                }
            },
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'email'},
                {data: 'balance'},
                {data: 'type'},
                                  @if (! Auth::user()->type === 'GSA')

                {data: 'employees'},
              @endif 
                {data: 'GSA-List'},
                {data: 'activation'},
                {data: 'orders'},
                {data: 'transactions'},
                {data: 'actions'},
            ]
        });
    </script>
@endsection
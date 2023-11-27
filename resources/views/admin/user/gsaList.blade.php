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
                    <th>Employees</th>
                    <th>Change GSA List</th>
                    <th>Activation</th>
                    <th>Orders</th>
                    <th>Transactions</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($builder as $user)

                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td><button class="btn btn-success btn-sm add-credit" data-link="{{route('userAddAmount',['user' => $user->id])}}">{{number_format($user->balance, 2)}}</button></td>
                            <td>{{$user->type}}</td>
                            <td><a href="{{route( 'userEmployee', [ 'user' => $user->id ] )}}" class="btn btn-info btn-sm">Employees</a></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#m_modal_3_{{$user->id}}">Change Role</button>
                            </td>
                            <td>
                                @if ( $user->type == 'Super Admin' ) 
                                    $user->type
                                @else
                                    <a href="{{route( 'userActivation', [ 'user' => $user->id ] )}}"
                                                   class="btn-sm link-confirm btn btn-{{( $user->activation === '0' ? 'brand' : 'danger' )}} ">
                                                    {{( $user->activation === '0' ? 'Approve' : 'Disapprove' )}}
                                                </a>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-brand btn-sm dropdown-toggle" 
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Orders</button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="{{route( 'userTravelOrders', [ 'user' => $user->id ] ) }}">Travel Orders</a>
                                      <a class="dropdown-item" href="{{route( 'userFlightOrders', [ 'user' => $user->id ] ) }}">Flights Orders</a>
                                      <a class="dropdown-item" href="{{route( 'userVisaOrders', [ 'user' => $user->id ] ) }}">Visa Orders</a>
                                    </div> 
                                  </div>
                            </td>
                            <td><a href="{{route( 'userTransactions', [ 'user' => $user->id ] )}}" class="btn btn-info btn-sm">Transactions</a></td>
                            <td>
                                <a href="{{route('editUser',['user' => $user->id])}}"
                                    class="btn btn-brand m-btn btn-sm m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
                                     <i class="fa flaticon-edit-1"></i>
                                 </a>
                                 <a href="{{route('deleteUser',['user' => $user->id])}}" 
                                 class="link-confirm btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                     <i class="fa flaticon-delete"></i>
                                 </a>
                            </td>
                            <td>
                                <!--begin::Modal-->
                                <div class="modal fade" id="m_modal_3_{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Change User Role
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">
                                                        &times;
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{route('changeRole',[ 'user' => $user->id ])}}" id="changeRole">
                                                    {{ csrf_field() }}
                                                    <select name="role">
                                                        @foreach($gsa as $g)
                                                            <option value="{{$g->id}}">{{$g->name}}({{$g->type}})</option>
                                                        @endforeach
                                                        <option value="0">User</option>
                                                    </select>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="btn btn-success" form="changeRole" value="Submit">Submit</button> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Modal-->
                            </td>
                        </tr>

                    @endforeach
                </tbody>
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
</script>
        
@endsection
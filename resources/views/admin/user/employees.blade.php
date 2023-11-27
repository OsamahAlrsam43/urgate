@extends('layouts.master')

@section('page-title')
    Users
@endsection

@section('sub-header')
    Employees for "{{$user->company}}" company
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
        <div class="col-lg-6">
            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                User Details.
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('storeEmployee', ['user' => $user->id]) }}" enctype="multipart/form-data">
                    <input type="hidden" name="employee" value="{{$employee->id}}" />
                    <input type="hidden" name="parent" value="{{$user->id}}" />
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    Name:
                                </label>
                                <input type="text" name="name" class="form-control m-input"
                                       placeholder="Enter username" value="{{ old('name', $employee->name) }}">
                                @if(isset($errors->messages()['name']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['name'][0] }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    Email:
                                </label>
                                <input type="email" name="email" class="form-control m-input"
                                       placeholder="Enter user email" value="{{ old('email', $employee->email) }}">
                                @if(isset($errors->messages()['email']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['email'][0] }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-6 mt-3">
                                <label>
                                    Password:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="password" name="password" class="form-control m-input"
                                           placeholder="enter user password.">
                                </div>
                                @if(isset($errors->messages()['password']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['password'][0] }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-6 mt-3 ">
                                <label>
                                    Re-type Password:
                                </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="password" name="password_confirmation" class="form-control m-input"
                                           placeholder="re-enter user password.">
                                </div>
                                @if(isset($errors->messages()['password_confirmation']))
                                    <div class="form-control-feedback" style="color: #f4516c;">
                                        {{  $errors->messages()['password_confirmation'][0] }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-6 pt-3">
                                <button type="submit" class="btn btn-primary mt-3">
                                    @if($employee->id) Save Changes @else Add Employee @endif
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                </form>
                <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>

        <div class="col-lg-6">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Employees List
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
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        var table = $('#data-tables').DataTable({
            serverSide: true,
            processing: true,
            scrollX: true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1,
            },
            ajax: {
                url: "{{ route('employeesData', ['id' => $user->id]) }}",
                type: 'GET',
                data: function (d) {

                }
            },
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'email'},
                {data: 'actions'},
            ]
        });
    </script>
@endsection
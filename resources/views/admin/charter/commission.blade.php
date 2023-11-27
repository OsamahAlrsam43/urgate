@extends('layouts.master')

@section('page-title')
    Special Commission
@endsection

@section('sub-header')
    Special Commission
@endsection

@section('content')
    @include('includes.info-box')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        ({{$charter->name}}) Special Commission
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form class="m-form m-form--label-align-right m-form--group-seperator-dashed"
                  method="post"
                  action="{{ route('storeCommission', ['charter' => $charter->id]) }}" enctype="multipart/form-data">

                {!! csrf_field() !!}

                <input type="hidden" name="charter_id" value="{{$charter->id}}" />

                <div class="form-group m-form__group row going-section" style="background: #f7f7f7;margin: 0 0 20px;border: 1px solid #efeeee;">
                    <div class="col-lg-12 mb-3">
                        <h4>Add special commission for company</h4>
                    </div>

                    <div class="col-lg-3">
                        <label>Select <span class="text-danger">Company</span></label>
                        <div class="input-group m-input-group m-input-group--square">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <select class="form-control select2" name="user_id">
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">[{{ $company->id }}] {{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <label>
                            Commission <span class="text-danger">value</span>:
                        </label>
                        <div class="input-group m-input-group m-input-group--square">
                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                            <input type="number" name="commission"
                                   placeholder="Enter commission value" class="form-control m-input"
                                   value="{{ old('commission') }}" required>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <label><span class="text-danger">Commission</span> Calculation:</label>
                        <div class="input-group m-input-group m-input-group--square">
                            <select name="is_percent" class="form-control m-input">
                                <option value="0">Fixed amount</option>
                                <option value="1">Percentage</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary" style="margin-top: 25px;">
                            Add commission
                        </button>
                    </div>
                </div>

            </form>

            <table id="data-tables" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Company Name</th>
                    <th>Commission</th>
                    <th>Actions </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('footer')
    {!! deleteModalHTML('commission') !!}
@endsection

@section('scripts')
    <script>
        $('.select2').select2();

        var table = $('#data-tables').DataTable({
            serverSide: true,
            processing: true,
            scrollX: true,
            ajax: "{{route('commissionData', ['charter' => $charter->id])}}",
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 0,
            },
            columns: [
                {data: 'id'},
                {data: 'user_id'},
                {data: 'commission'},
                {data: 'actions'},
            ],
        });
    </script>
@endsection
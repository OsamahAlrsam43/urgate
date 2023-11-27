@extends('layouts.master')

@section('page-title')
    Locked Seats
@endsection

@section('sub-header')
    Locked Seats
@endsection

@section('content')
    @include('includes.info-box')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        ({{$charter->name}}) Locked Seats
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form class="m-form m-form--label-align-right m-form--group-seperator-dashed"
                  method="post"
                  action="{{ route('storeLocked', ['charter' => $charter->id]) }}" enctype="multipart/form-data">

                {!! csrf_field() !!}

                <input type="hidden" name="charter_id" value="{{$charter->id}}"/>

                <div class="form-group m-form__group row going-section"
                     style="background: #f7f7f7;margin: 0 0 20px;border: 1px solid #efeeee;">
                    <div class="col-lg-12 mb-3">
                        <h4>Add locked seats for company</h4>
                    </div>

                    <div class="col">
                        <label>Select <span class="text-danger">Company</span></label>
                        <div class="input-group m-input-group m-input-group--square">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <select class="form-control select2" name="user_id">
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">[{{ $company->id }}
                                        ] {{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        <label>
                            Number of <span class="text-danger">seats</span>:
                        </label>
                        <div class="input-group m-input-group m-input-group--square">
                            <span class="input-group-addon"><i class="fa fa-plane"></i></span>
                            <input type="number" name="seats" value="1"
                                   placeholder="Number of seats" class="form-control m-input" required>
                        </div>
                    </div>
                    
                    <div class="col">
                        <label>
                            Flight <span class="text-danger">Class</span>:
                        </label>
                        <div class="input-group m-input-group m-input-group--square">
                            <span class="input-group-addon"><i class="fa fa-plane"></i></span>
                            <select class="form-control select2" name="flight_class">
                                <option value="Economy">Economy</option>
                                <option value="Business">Business</option>
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        <label>
                            Single Seat Price:
                        </label>
                        <div class="input-group m-input-group m-input-group--square">
                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                            <input type="number" name="seat_price" value="0"
                                   placeholder="Seat price" class="form-control m-input" required>
                        </div>
                    </div>

                    <div class="col">
                        <label>
                            Total Price:
                        </label>
                        <div class="input-group m-input-group m-input-group--square">
                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                            <input type="number" name="price" value="0"
                                   placeholder="Total seats price" class="form-control m-input" required>
                        </div>
                    </div>

                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px;">
                            Add locked seats
                        </button>
                    </div>
                </div>

            </form>

            <table id="data-tables" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>Company Name</th>
                    <th>Locked Seats</th>
                    <th>Seat Price</th>
                    <th>Total Price</th>
                    <th>Reserved At</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="template" id="cancel-form-template">
        <form action="{{route("deleteLocked", ['locked' => 'xx', 'charter' => $charter->id])}}" id="cancel-form" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
                <label>Seats</label>
                <input type="number" class="amount form-control" name="seats" value="{seats}" max="{seats}" required/>
            </div>
            <div class="form-group">
                <label>Refund amount</label>
                <input type="number" class="amount form-control" name="price" value="{amount}" max="{amount}" required/>
            </div>
        </form>
    </script>

    <script>
        $('[name=seat_price], [name=price], [name=seats]').on('input', function () {
            let isTotal = $(this).attr("name") === "price",
                isSeats = $(this).attr("name") === "seats",
                value = isSeats ? $('[name=seat_price]').val() : $(this).val(),
                seats = $('[name=seats]').val();

            let single = $('[name=seat_price]'),
                total = $('[name=price]');

            if (isTotal) {
                single.val(seats / value);
            } else {
                total.val(seats * value);
            }
        });


        // Cancel seats
        $('body').on('click', '.subtract-seats', function (e) {
            e.preventDefault();

            let id = $(this).data('id'),
                total = $(this).data('total'),
                single = $(this).data('single'),
                seats = $(this).data('seats');

            let template = $('#cancel-form-template').html();
            template = template.replace("xx", id);
            template = template.replace("{seats}", seats);
            template = template.replace("{amount}", total);

            $.confirm({
                title: 'Subtract Seats',
                content: template,
                buttons: {
                    confirm: {
                        text: 'Confirm',
                        action: function () {
                            $('#cancel-form').submit();
                        }
                    },
                    cancel: {}
                }
            });
        });

        $('.select2').select2();

        var table = $('#data-tables').DataTable({
            serverSide: true,
            processing: true,
            scrollX: true,
            ajax: "{{route('lockedData', ['charter' => $charter->id])}}",
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 0,
            },
            columns: [
                {data: 'user_id'},
                {data: 'user_name'},
                {data: 'seats'},
                {data: 'seat_price'},
                {data: 'price'},
                {data: 'created_at'},
                {data: 'actions'},
            ],
        });
    </script>
@endsection
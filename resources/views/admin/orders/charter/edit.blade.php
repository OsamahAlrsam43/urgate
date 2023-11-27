@extends('layouts.master')

@section('page-title')
    @if($isEdit) Edit Passenger Details @elseif(request()->get('eye') == 1 )  Order  Details  @else Edit Charter Order @endif
@endsection

@section('sub-header')
    @if($isEdit) Edit Passenger Details @elseif(request()->get('eye') == 1 )  Order  Details @else Edit Charter Order @endif
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

            @if($order->status == "TimeLimit")
                <div class="m-portlet" @if($isEdit) hidden @endif>
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                                <h3 class="m-portlet__head-text">
                                    TICKETING TIMELIMIT
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="m-portlet__body" style="padding-top: 15px;">

                        <form method="post"
                              action="{{ route('updateCharterOrder',['flight' => $charter->id,'order' => $order->id]) }}">

                            {!! csrf_field() !!}

                            <div class="row">
                                <input type="hidden" name="do" value="modify">
                                <!-- Start form-group -->
                                <div class="col-lg-5 mb-3">
                                    <label><span class="text-danger">Expire</span> in</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <input type="text" name="price" id="priceprice" class="form-control m-input"
                                               value="{{$order->expire_at->diffForHumans()}}"
                                               disabled="disabled">
                                    </div>
                                </div>

                                <!-- Start form-group -->
                                <div class="col-lg-2 mb-3">
                                    <label><span class="text-danger">Add</span> Hours</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <input type="number" name="add" class="form-control m-input" value="0">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label><span class="text-danger">Subtract</span> Hours</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <input type="number" name="subtract" class="form-control m-input" value="0">
                                    </div>
                                </div>

                                <div class="col-lg-3 mb-3 pt-3">
                                    <button class="btn btn-primary btn-sm mt-3">Modify Limit</button>
                                    <button class="btn btn-danger btn-sm mt-3" name="cancel" value="yes">Cancel Order
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            @endif
          
          
          
             @if(request()->get('eye') == 1 )
             <div class="m-portlet" @if($isEdit) hidden @endif>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Order Details
                              
                             
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body" style="padding-top: 15px;">

                    <div class="row">

                        <!-- Start form-group -->
                        <div class="col-lg-2 mb-3">
                            <label><span class="text-danger">Order</span> Total</label>
                            <div class="input-group m-input-group m-input-group--square">
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                <input type="text" name="price" class="form-control m-input" value="{{$order->price}}"
                                       disabled="disabled">
                            </div>
                        </div>

                        <!-- Start form-group -->
                        <div class="col-lg-2 mb-3">
                            <label><span class="text-danger">Ticket</span> PNR</label>
                            <div class="input-group m-input-group m-input-group--square">
                                <input type="text" name="pnr" class="form-control m-input" value="{{$order->pnr}}"
                                       disabled="disabled">
                            </div>
                        </div>

                        <div class="col-lg-2 mb-3">
                            <label><span class="text-danger">Order</span> Phone</label>
                            <div class="input-group m-input-group m-input-group--square">
                                <input type="text" name="phone" class="form-control m-input"
                                       value="{{$order->phone}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label><span class="text-danger">Order</span> Note</label>
                            <div class="input-group m-input-group m-input-group--square">
                                <input type="text" name="note" class="form-control m-input"
                                       value="{{$order->note ? $order->note : '....'}}" disabled="disabled">
                            </div>
                        </div>

                    </div>
                  
                  
                  
                    <div class="m-portlet__body" style="padding-top: 15px;">

                        <div class="row mb-3 mt-3">
                            <div class="col-lg-3">
                                <label><span class="text-danger">Flight</span> Class</label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <select name="flight_class" class="form-control m-select2 select2 no-search" disabled="disabled">
                                        <option @if($order->flight_class === "Economy") selected @endif>Economy</option>
                                        <option @if($order->flight_class === "Business") selected @endif>Business
                                        </option>
                                    </select>
                                </div>
                            </div>

                            @foreach($order->flights as $flight)
                                <div class="col-lg-4 mb-3">
                                    <label><span class="text-danger">Flight #{{$flight->charter->id}}</span> Name - Date</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-plane"></i></span>
                                        <select disabled="disabled" name="flight_{{$flight->charter->id}}"
                                                class="form-control select-flight">
                                            <option value="{{$flight->charter->id}}">{{$flight->charter->id . ' - ' . $flight->charter->name . ' - ' . $flight->charter->flight_date}}</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <input type="hidden" name="do" value="change">

                        @foreach($order->passengers as $passenger)
                            <div class="row mb-3 mt-3">
                                <div class="col-lg-12">
                                    <label>{{$passenger->first_name . ' ' . $passenger->last_name}} <span
                                                class="text-danger">#{{$passenger->id}}</span>
                                        ({{ucfirst($passenger->age)}})</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">Current Price</span>
                                                <input type="text" name="price_{{$passenger->id}}"
                                                       class="form-control m-input"
                                                       value="{{$passenger->price}}" disabled/>
                                                <span class="input-group-addon">$</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">Modified Price</span>
                                                <input type="text" name="modified_price_{{$passenger->id}}"
                                                       class="form-control m-input modified_price"
                                                       value="{{$passenger->price}}" data-id="{{$passenger->id}}" disabled="disabled"/>
                                                <span class="input-group-addon">$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                  
                </div>
            </div>
          @else
          
          
           <div class="m-portlet" @if($isEdit) hidden @endif>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Order Details
                              
                             
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body" style="padding-top: 15px;">

                    <div class="row">

                        <!-- Start form-group -->
                        <div class="col-lg-2 mb-3">
                            <label><span class="text-danger">Order</span> Total</label>
                            <div class="input-group m-input-group m-input-group--square">
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                <input type="text" name="price" class="form-control m-input" value="{{$order->price}}"
                                       disabled="disabled">
                            </div>
                        </div>

                        <!-- Start form-group -->
                        <div class="col-lg-2 mb-3">
                            <label><span class="text-danger">Ticket</span> PNR</label>
                            <div class="input-group m-input-group m-input-group--square">
                                <input type="text" name="pnr" class="form-control m-input" value="{{$order->pnr}}"
                                       disabled="disabled">
                            </div>
                        </div>

                        <div class="col-lg-2 mb-3">
                            <label><span class="text-danger">Order</span> Phone</label>
                            <div class="input-group m-input-group m-input-group--square">
                                <input type="text" name="phone" class="form-control m-input"
                                       value="{{$order->phone}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label><span class="text-danger">Order</span> Note</label>
                            <div class="input-group m-input-group m-input-group--square">
                                <input type="text" name="note" class="form-control m-input"
                                       value="{{$order->note ? $order->note : '....'}}" disabled="disabled">
                            </div>
                        </div>

                    </div>
                  
                  

                    
                  
                </div>
            </div>


            <div class="m-portlet" @if($isEdit) hidden @endif>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Edit Order Flights
                            </h3>
                        </div>
                    </div>
                </div>

                <form class="m-form m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('updateCharterOrder',['flight' => $charter->id,'order' => $order->id] ) }}"
                      enctype="multipart/form-data">
                    <div class="m-portlet__body" style="padding-top: 15px;">

                        <div class="row mb-3 mt-3">
                            <div class="col-lg-3">
                                <label><span class="text-danger">Flight</span> Class</label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <select name="flight_class" class="form-control m-select2 select2 no-search">
                                        <option @if($order->flight_class === "Economy") selected @endif>Economy</option>
                                        <option @if($order->flight_class === "Business") selected @endif>Business
                                        </option>
                                    </select>
                                </div>
                            </div>

                            @foreach($order->flights as $flight)
                                <div class="col-lg-4 mb-3">
                                    <label><span class="text-danger">Flight #{{$flight->charter->id}}</span> Name - Date</label>
                                    <div class="input-group m-input-group m-input-group--square">
                                        <span class="input-group-addon"><i class="fa fa-plane"></i></span>
                                        <select name="flight_{{$flight->charter->id}}"
                                                class="form-control select-flight">
                                            <option value="{{$flight->charter->id}}">{{$flight->charter->id . ' - ' . $flight->charter->name . ' - ' . $flight->charter->flight_date}}</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <input type="hidden" name="do" value="change">

                        @foreach($order->passengers as $passenger)
                            <div class="row mb-3 mt-3">
                                <div class="col-lg-12">
                                    <label>{{$passenger->first_name . ' ' . $passenger->last_name}} <span
                                                class="text-danger">#{{$passenger->id}}</span>
                                        ({{ucfirst($passenger->age)}})</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">Current Price</span>
                                                <input type="text" name="price_{{$passenger->id}}"
                                                       class="form-control m-input"
                                                       value="{{$passenger->price}}" disabled/>
                                                <span class="input-group-addon">$</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group m-input-group m-input-group--square">
                                                <span class="input-group-addon">Modified Price</span>
                                                <input type="text" name="modified_price_{{$passenger->id}}"
                                                       class="form-control m-input modified_price"
                                                       value="{{$passenger->price}}" data-id="{{$passenger->id}}"/>
                                                <span class="input-group-addon">$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    {!! csrf_field() !!}
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <button type="submit" class="btn btn-primary change-button">
                                Save changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                @if($isEdit) Edit Passenger Details @else Passengers Data @endif
                              
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body pt-3 pb-3" @if($isEdit) hidden @endif>
                    <table id="data-tables" class="table table-striped table-bordered nowrap" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Title</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Birth Date</th>
                            <th>Nationality</th>
                            <th>Passport Number</th>
                            <th>Passport Expiration</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>

                    <button class="btn btn-info btn-sm mt-3" id="split-passengers"><i class="fa fa-random"></i> Split
                        selected passengers
                    </button>
                </div>

                <!--begin::Form-->
                <form class="m-form m-form--label-align-right m-form--group-seperator-dashed"
                      method="post"
                      action="{{ route('updateCharterOrder',['flight' => $charter->id,'order' => $order->id, 'passenger' => $passenger11->id ] ) }}"
                      enctype="multipart/form-data" @if(!$isEdit) hidden @endif>

                    <div class="m-portlet__body pt-3 pb-3">
                        <div class="row">
                            <div class="col-lg-3 mb-3">
                                <label>Title</label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <select name="title" class="form-control m-input">
                                        <option @if($passenger11->title === "MR") selected @endif>MR</option>
                                        <option @if($passenger11->title === "MRS") selected @endif>MRS</option>
                                        <option @if($passenger11->title === "INF") selected @endif>INF</option>
                                      
                                      
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="do" value="passenger">
                            <input type="hidden" name="passenger" value="{{$passenger11->id}}">

                            <div class="col-lg-3">
                                <label><span class="text-danger">First</span> Name</label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <input type="text" name="first_name" class="form-control m-input"
                                           value="{{$passenger11->first_name}}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label><span class="text-danger">Last</span> Name</label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <input type="text" name="last_name" class="form-control m-input"
                                           value="{{$passenger11->last_name}}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label><span class="text-danger">Birth</span> Date</label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="date" name="birth_date" class="form-control m-input date-picker"
                                           value="{{$passenger11->birth_date}}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label><span class="text-danger">Nationality</span></label>
                                <select class="form-control m-select2" id="m_select2_1"
                                        name="nationality">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}"
                                                @if($passenger11->nationality === $country->id) selected @endif>{{
                                            $country->name['en'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label><span class="text-danger">Passport</span> Number</label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <input type="text" name="passport_number" class="form-control m-input"
                                           value="{{$passenger11->passport_number}}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label><span class="text-danger">Passport </span> Expire Date</label>
                                <div class="input-group m-input-group m-input-group--square">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="date" name="passport_expire_date"
                                           class="form-control m-input date-picker"
                                           value="{{$passenger11->passport_expire_date}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {!! csrf_field() !!}
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                            <a href="{{url()->previous()}}" class="btn btn-default">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
          @endif
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
                        Delete Image
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure that you want to remove this image ?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-danger" id="delete" data-dismiss="modal">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

@endsection

@section('styles')
    <link href="{{asset('public/assets/css/styles.css')}}" rel="stylesheet">
@endsection

@section('scripts')
    <script>
        $('.select2.no-search').select2({
            placeholder: "Select an option",
            minimumResultsForSearch: -1
        });

        $('.select-flight').select2({
            placeholder: 'Change flight date',
            ajax: {
                url: "{{route('autoComplete')}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function (params) {
                    return {
                        search: params.term,
                        contentType: "application/json; charset=utf-8",
                        select: ['id', 'name', 'flight_date'],
                        item: 'charter',
                        id: 'id',
                        text: ['id', 'name', 'flight_date'],
                        join: ' - '
                    }
                },
                type: 'POST',
                dataType: 'json'
            }
        });

        $('.select-flight, [name=flight_class]').on('change', function () {
            var newClass = $('[name=flight_class]').val(),
                flight = $('.select-flight');

            var flights = [];
            for (var i = 0; i < flight.length; i++) {
                flights.push($(flight.get(i)).val());
            }

            $('.change-button').attr('disabled', true);

            $.ajax({
                url: "{{route('calculateCharterPrice')}}",
                data: {order: {{$order->id}}, newClass, flights},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    $('.change-button').removeAttr('disabled');

                    $('.modified_price').each(function () {
                        var id = $(this).data('id');
                        $('[name=modified_price_' + id + ']').val(data[id]);
                    });
                }
            });
        });

        $('[name=selected_flight]').change(function () {
            var selected = $('[name=selected_flight]:checked').val();
            $('.flight-date').attr("hidden", true);
            $('#date-' + selected).removeAttr("hidden");
        });

        $('#split-passengers').on('click', function () {
            var selectedPassengers = $("[name=selected_passengers]:checked");
            var passengers = selectedPassengers.map(function () {
                return $(this).val();
            }).get();

            if (selectedPassengers.length === 0) {
                alert("You have to select at least one passenger to split!");
                return;
            }

            if (selectedPassengers.length === $("[name=selected_passengers]").length) {
                alert("Sorry, You can split all passengers, you have to leave at least one passenger in this order!");
                return;
            }

            var $this = $(this);

            $this.find('i').removeClass('fa-random').addClass('fa-circle-o-notch').addClass('fa-spin');

            $.get(
                "{{ route('updateCharterOrder',['flight' => $charter->id,'order' => $order->id, 'do' => 'split']) }}",
                {passengers},
                function (data) {
                    $this.find('i').addClass('fa-random').removeClass('fa-spin').removeClass('fa-circle-o-notch');

                    if (data == "Done") {
                        window.location.reload()
                    } else {
                        alert("Something went wrong!");
                    }
                });
        });

        var table = $('#data-tables').DataTable({
            serverSide: true,
            processing: true,
            scrollX: true,
ajax: "{{route('charterPassengersData', ['order' => $order->id, 'charter' => $charter->id])}}",          
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 0,
            },
            columns: [
                {data: 'check'},
                {data: 'id'},
                {data: 'title'},
                {data: 'first_name'},
                {data: 'last_name'},
                {data: 'birth_date'},
                {data: 'nationality'},
                {data: 'passport_number'},
                {data: 'passport_expire_date'},
                {data: 'actions'},
            ],
        });
    </script>
@endsection

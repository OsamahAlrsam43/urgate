@extends('layouts.master')

@section('page-title')
    Charter Pricing
@endsection

@section('header')
    Charter Pricing - ({{$charter->name}})
@endsection

@section('content')
    @include('includes.info-box')
    <div class="row">
        <div class="col-md-7">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Charter Pricing
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet">
                    <div class="m-portlet__body">
                        <div class="accordion" id="pricing-list">
                            @foreach($pricing as $k=>$price)
                                <div class="card mb-3">
                                    <div class="card-header" id="heading-{{$k}}">
                                        <div class="row" data-toggle="collapse" data-target="#collapse{{$k}}"
                                             aria-expanded="false" aria-controls="collapse{{$k}}">
                                            <div class="col-md-3"><h6>{{$price->price_class}}</h6></div>
                                            <div class="col-md-3"><h6>{{$price->flight_class}}</h6></div>
                                            <div class="col-md-3"><h6>All seats: ({{$price->seats}})</h6></div>
                                            <div class="col-md-3"><h6>Available seats: (<span
                                                            class="text-success">{{$price->available_seats}}</span>)
                                                </h6></div>
                                        </div>
                                    </div>

                                    <div id="collapse{{$k}}" class="collapse" aria-labelledby="heading{{$k}}"
                                         data-parent="#pricing-list">
                                        <div class="card-body">
                                            <div class="pricing-item">
                                                <table class="table table-bordered">
                                                    <tr class="bg-light">
                                                        <th>AGE</th>
                                                        <th>ONE WAY PRICE</th>
                                                        <th>ROUND TRIP PRICE</th>
                                                    </tr>
                                                    <tr>
                                                        <th>ADULT</th>
                                                        <td>${{$price->price_adult_1}}</td>
                                                        <td>${{$price->price_adult_2}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>CHILD</th>
                                                        <td>${{$price->price_child_1}}</td>
                                                        <td>${{$price->price_child_2}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>INF</th>
                                                        <td>${{$price->price_inf_1}}</td>
                                                        <td>${{$price->price_inf_2}}</td>
                                                    </tr>
                                                </table>

                                                <h5>OPEN RETURN</h5>

                                                <table class="table table-bordered">
                                                    <tr class="bg-light">
                                                        <th>AGE</th>
                                                        <th>1 MONTH</th>
                                                        <th>3 MONTHS</th>
                                                        <th>6 MONTHS</th>
                                                        <th>1 YEAR</th>
                                                    </tr>
                                                    <tr>
                                                        <th>ADULT</th>
                                                        <td>${{$price->price_adult_3_1}}</td>
                                                        <td>${{$price->price_adult_3_3}}</td>
                                                        <td>${{$price->price_adult_3_6}}</td>
                                                        <td>${{$price->price_adult_3_12}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>CHILD</th>
                                                        <td>${{$price->price_child_3_1}}</td>
                                                        <td>${{$price->price_child_3_3}}</td>
                                                        <td>${{$price->price_child_3_6}}</td>
                                                        <td>${{$price->price_child_3_12}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>INF</th>
                                                        <td>${{$price->price_inf_3_1}}</td>
                                                        <td>${{$price->price_inf_3_3}}</td>
                                                        <td>${{$price->price_inf_3_6}}</td>
                                                        <td>${{$price->price_inf_3_12}}</td>
                                                    </tr>
                                                </table>

                                                <div class="mt-3">
                                                    <button class="btn btn-info btn-sm edit-pricing"
                                                            data-prices="{{json_encode($price)}}"
                                                            data-economy="{{ ($seatsData->economy_seats - $seatsData->economy_sold_seats)+$price->seats }}"
                                                            data-business="{{ ($seatsData->business_seats - $seatsData->business_sold_seats)+$price->seats }}"

                                                            data-flightclass="{{ $price->flight_class }}"
                                                            data-id="{{$price->id}}">Edit
                                                    </button>
                                                    <button class="btn btn-danger btn-sm delete-pricing"
                                                            data-id="{{$price->id}}">Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text form-title">
                                Add Price
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet">
                    <div class="m-portlet__body" id="pricing-container">
                        <form id="pricing-form">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Flight Class</label>
                                    <select name="flight_class" class="form-control m-input">
                                        <option value="Economy">Economy</option>
                                        <option value="Business">Business</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Price Class</label>
                                    <select name="price_class" class="form-control m-input">
                                        <option value="C1">C 1</option>
                                        <option value="C2">C 2</option>
                                        <option value="C3">C 3</option>
                                        <option value="C4">C 4</option>
                                        <option value="C5">C 5</option>
                                        <option value="C6">C 6</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Seats</label>
                                    <input type="number" name="seats" class="form-control m-input" min="0"
{{--                                           value="{{ $charter->economy_seats - $charter->economy_sold_seats }}"  max--}}
                                           data-economy="{{ $seatsData->economy_seats - $seatsData->economy_sold_seats }}"
                                           data-business="{{ $seatsData->business_seats - $seatsData->business_sold_seats }}"
                                    >
                                </div>

                                <!-- Adult Prices -->
                                <div class="col-md-12 mt-3"><h5>ADULT</h5></div>
                                <div class="col-md-6">
                                    <label>One Way</label>
                                    <input type="number" name="price_adult_1" class="form-control m-input" value="0">
                                </div>
                                <div class="col-md-6">
                                    <label>Round Trip</label>
                                    <input type="number" name="price_adult_2" class="form-control m-input" value="0">
                                </div>

                                <!-- Child Prices -->
                                <div class="col-md-6 mt-3"><h5>CHILD</h5></div>
                                <div class="col-md-6 mt-3"><h5>INFANT</h5></div>
                                <div class="col-md-3">
                                    <label>One Way</label>
                                    <input type="number" name="price_child_1" class="form-control m-input" value="0">
                                </div>
                                <div class="col-md-3">
                                    <label>Round Trip</label>
                                    <input type="number" name="price_child_2" class="form-control m-input" value="0">
                                </div>

                                <!-- Baby Prices -->
                                <div class="col-md-3">
                                    <label>One Way</label>
                                    <input type="number" name="price_inf_1" class="form-control m-input" value="0">
                                </div>
                                <div class="col-md-3">
                                    <label>Round Trip</label>
                                    <input type="number" name="price_inf_2" class="form-control m-input" value="0">
                                </div>

                                <!-- Open Prices -->
                                <div class="col-md-12 mt-3 mb-3"><h5>OPEN RETURN</h5></div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h6>Duration</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6>ADULT</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6>CHILD</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6>INF</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <input type="text" class="form-control m-input mb-2" value="1 Month" disabled>
                                    <input type="text" class="form-control m-input mb-2" value="3 Month" disabled>
                                    <input type="text" class="form-control m-input mb-2" value="6 Month" disabled>
                                    <input type="text" class="form-control m-input mb-2" value="1 Year" disabled>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="price_adult_3_1" class="form-control m-input mb-2"
                                           value="0">
                                    <input type="number" name="price_adult_3_3" class="form-control m-input mb-2"
                                           value="0">
                                    <input type="number" name="price_adult_3_6" class="form-control m-input mb-2"
                                           value="0">
                                    <input type="number" name="price_adult_3_12" class="form-control m-input mb-2"
                                           value="0">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="price_child_3_1" class="form-control m-input mb-2"
                                           value="0">
                                    <input type="number" name="price_child_3_3" class="form-control m-input mb-2"
                                           value="0">
                                    <input type="number" name="price_child_3_6" class="form-control m-input mb-2"
                                           value="0">
                                    <input type="number" name="price_child_3_12" class="form-control m-input mb-2"
                                           value="0">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="price_inf_3_1" class="form-control m-input mb-2"
                                           value="0">
                                    <input type="number" name="price_inf_3_3" class="form-control m-input mb-2"
                                           value="0">
                                    <input type="number" name="price_inf_3_6" class="form-control m-input mb-2"
                                           value="0">
                                    <input type="number" name="price_inf_3_12" class="form-control m-input mb-2"
                                           value="0">
                                </div>

                                <div class="col-md-6 pt-4">
                                    <input type="hidden" name="id" value="0">
                                    <button type="button" class="btn btn-info mt-1 add-pricing">
                                        Add Price
                                    </button>
                                    <button type="button" class="btn btn-dark mt-1 cancel">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.cancel').on('click', function () {
            location.reload();
        });

        $('[name="flight_class"]').change(function () {
            if ($('[name="id"]').val() === '0') {
                if ($(this).val() === 'Economy') {
                    var data = $("[name=\"seats\"]").attr('data-economy');
                } else if ($(this).val() === 'Business') {
                    var data = $("[name=\"seats\"]").attr('data-business');
                }
                $('[name="seats"]').attr('max', data).attr('value', data)
            }
        }).trigger('change');
        $('.add-pricing').on('click', function () {
            $('#pricing-container').block({
                message: '<h5 style="margin:0; padding: 5px;">Processing</h5>',
                css: {border: '1px solid #ccc', lineHeight: 30}
            });

            $.ajax({
                url: '{{route('charterAddPricing', ["charter" => $charter->id])}}',
                method: 'post',
                data: $('#pricing-form').serializeArray()
            }).then(function (response) {
                $('#pricing-container').unblock();

                if (response.error == true) {
                    $.alert(response.message, "Error");
                } else {
                    location.reload();
                }
            });
        });

        $('.delete-pricing').on('click', function () {
            let id = $(this).data("id");
            $.confirm({
                title: 'Confirm delete pricing class',
                content: 'Are you sure you want to delete this pricing class?',
                buttons: {
                    confirm: {
                        text: 'Confirm',
                        action: function () {
                            window.location = '{{route("charterDeletePricing", ["charter" => $charter->id])}}?id=' + id;
                        }
                    },
                    cancel: {}
                }
            });
        });

        $('.edit-pricing').on('click', function () {
            let id = $(this).data("id"),
                flightclass = $(this).data('flightclass'),
                prices = $(this).data('prices');

            $('[name=id]').val(id);
            $('.form-control').each(function () {
                let $this = $(this),
                    name = $this.attr("name");

                if (prices[name]) {
                    $this.val(prices[name]).attr('placeholder',prices[name]);
                }
            });

            if (flightclass === 'Economy') {
                var data = $(this).attr('data-economy');
            } else if (flightclass === 'Business') {
                var data = $(this).attr('data-business');
            }
            $('[name="seats"]').attr('max', data).val(data)


            $('.add-pricing').text("Save Changes");
            $('.form-title').text("Edit Pricing Class");
        });
    </script>
@endsection
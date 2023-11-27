@extends('layouts.master-front')

@section('title')
    @lang("alnkel.flights")
@endsection

@section('style')
    <style>
        .search {
            display: none;
        }
    </style>
@endsection

@section('page-header')
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span>@lang("charter.my_locked")</span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
@endsection

@section('content')
    <!-- Start categorylist -->
    <div class="search-box p-3 bg-light">
        <h3 class="text-center text-info">Reserved Seats</h3>
    </div>
    <div class="pt-3" style="min-height: 250px;">
        <!-- Start container-fluid -->
        <div class="container">
            <!-- Start row -->
            <div class="row">

                <table class="table table-sm table-striped table-bordered charter-table" data-col="7">
                    <thead>
                    <tr class="bg-dark text-light">
                        <th scope="col">@lang("charter.reserve")</th>
                        <th scope="col">@lang("charter.from")</th>
                        <th scope="col">@lang("charter.to")</th>
                        <th scope="col">@lang("charter.flight_number")</th>
                        <th scope="col">@lang("charter.airline")</th>
                        <th scope="col">@lang("charter.flight_date")</th>
                        <th scope="col">@lang("charter.flight_time")</th>
                        <th scope="col">@lang("charter.seats")</th>
                        <th scope="col">Seat Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($flights as $flight)
                       @if( \Carbon\Carbon::now()->diffInHours( \Carbon\Carbon::parse(\Carbon\Carbon::parse($flight->charter['flight_date'])->format('Y-m-d')." ".\Carbon\Carbon::parse($flight->charter['departure_time'])->format('h:i:s')),false)> 2)
                      
                      <tr>
                                <td>
                                    <input type="checkbox" name="flights" value="{{ $flight->id }}" />
                                </td>
                                <td>{{$flight->charter->from->name[App::getLocale()]}}</td>
                                <td>{{$flight->charter->to->name[App::getLocale()]}}</td>
                                <td>{{$flight->charter->flight_number}}</td>
                                <td>{{$flight->charter->aircraft->name}}</td>
                                <td>{{$flight->charter->flight_date->format('Y-m-d')}}</td>
                                <td>{{$flight->charter->departure_time}}</td>
                                <td>{{$flight->seats}}</td>
                                <td>{{$flight->seat_price}}</td>
                            </tr>
                      @endif
                    @endforeach
                    </tbody>
                </table>

                <a href="#" class="reserve btn btn-warning">
                    {{__('charter.reserve')}}
                </a>
            </div>
        </div>

        <!--begin::Modal-->
        <div class="modal fade" id="m_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="reserve-form" action="" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="locked" value="0">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{__("charter.select_passengers")}}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                charter: 24
                                roundtrip_charter:
                                reserve_adults: 1
                                reserve_children: 0
                                reserve_babies: 0
                                flight_class: Economy
                                flight_type: OneWay
                                coming_duration:
                                <input type="hidden" name="day">
                                <!-- Start input-gp -->
                                <div class="col">
                                    <label for="">@lang("charter.adult"):</label>
                                    <select class="passengers form-control" name="adult"></select>
                                </div>
                                <!-- End input-gp -->
                                <!-- Start input-gp -->
                                <div class="col">
                                    <label for="">@lang("charter.baby"):</label>
                                    <select class="passengers form-control" name="baby">
                                        @for($i=0;$i<=5;$i++)
                                            <option value="{{ $i }}" {{ old('baby') == $i ? 'selected' : ''}}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <!-- End input-gp -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>

                            <button type="submit" class="reserve-btn btn btn-warning">
                                {{__('charter.reserve')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Modal-->

        <!-- End container-fluid -->
    </div>
    <!-- End categorylist -->
@endsection

@section('scripts')
    <script>
        $('.charter-table tr').click(function(event) {
            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });

        $('.reserve').on('click', function (e) {
            e.preventDefault();

            let flights = $('[name="flights"]:checked').map(function() {
                return $(this).val();
            }).get();

            if(flights.length === 0) {
                $.alert("You have to select at least 1 flight");
                return false;
            }
            
            if(flights.length === 2) {
                var result =$.ajax({
                        url: '{{route('checkRound')}}',
                        method: 'post',
                        data: { flights },
                        async: false
                    }).done(function (response) {
                        console.log(response);
                    }).fail(function (e) {
                        console.log(e.responseText);
                        self.setContent('Something went wrong.');
                    });
                if(!result.responseJSON){
                    $.alert("You Must select RoundTrip of 2 flights");
                    return false;
                }
            }

            if(flights.length > 2) {
                $.alert("You can select maximum of 2 flights");
                return false;
            }

            $.confirm({
                title: 'Select Passengers',
                content: function () {
                    var self = this;
                    return $.ajax({
                        url: '{{route('charterLockedForm')}}',
                        method: 'post',
                        data: {
                            flights
                        }
                    }).done(function (response) {
                        // console.log(response);
                        self.setContent(response);
                    }).fail(function (e) {
                        console.log(e.responseText);
                        self.setContent('Something went wrong.');
                    });
                },
                buttons: {
                    sure: {
                        btnClass: 'btn-success',
                        text: 'Enter details',
                        action: function () {
                            this.$content.find('form').submit();
                        }
                    },
                    cancel: {}
                }
            });

        });

        $('._reserve').on('click', function () {
            var seats = $(this).data("seats");
            var id = $(this).data("id");
            var locked = $(this).data("locked");
            var action = "{{ route('charterCheckout',['charter' => 'xx']) }}";

            $("[name=locked]").val(locked);

            $('#reserve-form').attr('action', action.replace("xx", id));

            let options = '';
            for (let i=1; i<=seats; i++) {
                options += `<option>${i}</option>`;
            }

            $('[name=adult]').html(options);
        });

        $('.reserve-btn').on('click', function (e) {
            e.preventDefault();

            var adult = $('#reserve-form [name=adult]').val();
            var children = $('#reserve-form [name=children]').val();

            if (adult == 0 && baby == 0) {
                alert("{{__("charter.select_min_one")}}");
                return false;
            }

            $('#reserve-form').submit();
            return true;
        });

        $('[data-toggle="tooltip"]').tooltip();
    </script>
@endsection
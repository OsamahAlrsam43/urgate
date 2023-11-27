@extends('layouts.master-front')

@section('title')
    @lang("alnkel.createcharter")
@endsection

@section('styles')
    <style>
        .search-box {
            background-color: #f2f2f2;
            box-shadow: 1px 1px 20px rgba(0, 0, 0, 0.5);
        }

        .select2-container {
            background: #fff;
        }

        .btn-info:not(:disabled):not(.disabled).active, .btn-info:not(:disabled):not(.disabled):active {
            background: #333940;
            border-color: #333940;
        }
    </style>
@stop

@section('content')

    <section class="container">
        <div class="msg-height p-3 mb-3 text-center">
            {!! nl2br($setting->create_charter[App::getLocale()]) !!}
        </div>
    </section>

    <section>
        <form method="post" action="{{route("charter.create.results")}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="container">
                <div class="search-box search-box pt-3 pb-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="options aligen-items text-right" id="options">
                                                <input type="radio" id="one_way" value="OneWay" name="flight_type"
                                                       @if($data && $data->flight_type == "OneWay" || !$data) checked @endif>
                                                <label for="one_way">@lang("alnkel.one_way")</label>
                                                <input type="radio" id="two_way" value="RoundTrip" name="flight_type"
                                                       @if($data && $data->flight_type == "RoundTrip") checked @endif>
                                                <label for="two_way">@lang("alnkel.Round_Trip")</label>
                                                <input type="radio" id="open_return" value="OpenReturn"
                                                       name="flight_type"
                                                       @if($data && $data->flight_type == "OpenReturn") checked @endif>
                                                <label for="open_return">@lang("alnkel.open_return")</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-info active">
                                                  <input type="radio" name="search_type" id="search" value="search" checked> 					@lang("alnkel.Book_Flight")	
                                                </label>
                                                <label class="btn btn-info">
                                                    <input type="radio" name="search_type" id="locked" value="locked"> @lang("alnkel.Reserve_Seats")
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="container filter">
                                    <div class="row">
                                        <div class="col">
                                            <label class="d-block">@lang("charter.from")</label>
                                            <select class="form-control select2" name="from">
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                            {{ $data && $data->from == $country->id ? 'selected' : ''}}
                                                    >{{ $country->name['ar'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="d-block">@lang("charter.to")</label>
                                            <select class="form-control select2" name="to">
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                            {{ $data && $data->to == $country->id ? 'selected' : ''}}
                                                    >{{ $country->name['ar'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="d-block">@lang("charter.going")</label>
                                            <input class="form-control date hasDatepicker"   name="going" type="date"
                                                   value="{{isset($data->going) ? $data->going : null}}">
                                            <i class="far fa-calendar-alt"></i>
                                          <input type="number" name="pl1" class="form-control" value="3" style="width: 100%;float: left;text-align: center;">
                                  <i class="fa fa-plus" aria-hidden="true" style="position: absolute;top: 79px;z-index: 1000"></i>
                                        </div>


                                        <div class="col" id="coming-two-way">
                                            <label class="d-block">@lang("charter.coming")</label>
                                            <input class="form-control date" name="coming" type="date"
                                                   value="{{isset($data->coming) ? $data->coming : null}}">
                                            <i class="far fa-calendar-alt"></i>
                                           <input type="number" name="pl2" class="form-control" value="3" style="width: 100%;float: left;text-align: center;">
                                  <i class="fa fa-plus" aria-hidden="true" style="position: absolute;top: 79px"></i>
                                        </div>
                                        <div class="col" id="coming-open-return">
                                            <label class="d-block">@lang("alnkel.Duration")</label>
                                            <select class="form-control select2" name="coming_duration">
                                                <option value="1" {{isset($data->coming_duration) && $data->coming_duration == "1" ? "selected" : ""}}>
                                                    @lang("alnkel.One month")
                                                </option>
                                                <option value="3" {{isset($data->coming_duration) && $data->coming_duration == "3" ? "selected" : ""}}>
                                                    @lang("alnkel.Three months")
                                                </option>
                                                <option value="6" {{isset($data->coming_duration) && $data->coming_duration == "6" ? "selected" : ""}}>
                                                    @lang("alnkel.Six month")
                                                </option>
                                                <option value="12" {{isset($data->coming_duration) && $data->coming_duration == "12" ? "selected" : ""}}>
                                                   @lang("alnkel.One Year")
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="container filter">
                                    <div class="row">
                                        <div class="col">
                                            <label class="d-block">@lang("alnkel.Flight Class")</label>
                                            <select class="form-control select2" name="flight_class" id="flight_class">
                                                <option value="Economy" {{ $data && $data->flight_class == "Economy" ? "selected" : ""}} >
                                                    @lang("alnkel.Economy")
                                                </option>
                                                <option value="Business" {{$data && $data->flight_class == "Business" ? "selected" : ""}} >
                                                    @lang("alnkel.Business")
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="d-block" for="adult">
                                                @lang("alnkel.Adults")
                                            </label>
                                            <select class="form-control select2" name="adults">
                                                @for($i=1;$i<=10;$i++)
                                                    <option {{$data && $data->adults == $i ? "selected" : ""}}>{{$i}}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="d-block" for="adult">
                                                @lang("alnkel.Children")
                                            </label>
                                            <select class="form-control select2" name="children">
                                                @for($i=0;$i<=10;$i++)
                                                    <option {{$data && isset($data->children) && $data->children == $i ? "selected" : ""}}>
                                                        {{$i}}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="d-block" for="adult">
                                                @lang("alnkel.Babies")
                                            </label>
                                            <select class="form-control select2" name="babies">
                                                @for($i=0;$i<=10;$i++)
                                                    <option {{$data && isset($data->babies) && $data->babies == $i ? "selected" : ""}}>{{$i}}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col search-btn">
                                            <button class="btn main-button" id="submit-search">
                                                <i class="fas fa-search"> </i> @lang("alnkel.Search")
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </section>

@endsection

@section('scripts')
<script>

var flight_type = document.getElementsByName('flight_type');
  console.log(flight_type);
</script>
  
    
@stop


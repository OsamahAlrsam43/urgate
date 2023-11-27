@extends('layouts.master-front')

@section('title')
    @lang("alnkel.searchcharter")
@endsection

@section('page-header')
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span>@lang("alnkel.searchcharter")</span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
@endsection
@section('content')

<style>
/* START TOOLTIP STYLES */
[tooltip] {
  position: relative; /* opinion 1 */
}

/* Applies to all tooltips */
[tooltip]::before,
[tooltip]::after {
  text-transform: none; /* opinion 2 */
  font-size: .9em; /* opinion 3 */
  line-height: 1;
  user-select: none;
  pointer-events: none;
  position: absolute;
  display: none;
  opacity: 0;
}
[tooltip]::before {
  content: '';
  border: 5px solid transparent; /* opinion 4 */
  z-index: 1001; /* absurdity 1 */
}
[tooltip]::after {
  content: attr(tooltip); /* magic! */
  
  /* most of the rest of this is opinion */
  font-family: Helvetica, sans-serif;
  text-align: center;
  
  /* 
    Let the content set the size of the tooltips 
    but this will also keep them from being obnoxious
    */
  min-width: 3em;
  max-width: 21em;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  padding: 1ch 1.5ch;
  border-radius: .3ch;
  box-shadow: 0 1em 2em -.5em rgba(0, 0, 0, 0.35);
  background: #333;
  color: #fff;
  z-index: 1000; /* absurdity 2 */
}

/* Make the tooltips respond to hover */
[tooltip]:hover::before,
[tooltip]:hover::after {
  display: block;
}

/* don't show empty tooltips */
[tooltip='']::before,
[tooltip='']::after {
  display: none !important;
}

/* FLOW: UP */
[tooltip]:not([flow])::before,
[tooltip][flow^="up"]::before {
  bottom: 100%;
  border-bottom-width: 0;
  border-top-color: #333;
}
[tooltip]:not([flow])::after,
[tooltip][flow^="up"]::after {
  bottom: calc(100% + 5px);
}
[tooltip]:not([flow])::before,
[tooltip]:not([flow])::after,
[tooltip][flow^="up"]::before,
[tooltip][flow^="up"]::after {
  left: 50%;
  transform: translate(-50%, -.5em);
}

/* FLOW: DOWN */
[tooltip][flow^="down"]::before {
  top: 100%;
  border-top-width: 0;
  border-bottom-color: #333;
}
[tooltip][flow^="down"]::after {
  top: calc(100% + 5px);
}
[tooltip][flow^="down"]::before,
[tooltip][flow^="down"]::after {
  left: 50%;
  transform: translate(-50%, .5em);
}

/* FLOW: LEFT */
[tooltip][flow^="left"]::before {
  top: 50%;
  border-right-width: 0;
  border-left-color: #333;
  left: calc(0em - 5px);
  transform: translate(-.5em, -50%);
}
[tooltip][flow^="left"]::after {
  top: 50%;
  right: calc(100% + 5px);
  transform: translate(-.5em, -50%);
}

/* FLOW: RIGHT */
[tooltip][flow^="right"]::before {
  top: 50%;
  border-left-width: 0;
  border-right-color: #333;
  right: calc(0em - 5px);
  transform: translate(.5em, -50%);
}
[tooltip][flow^="right"]::after {
  top: 50%;
  left: calc(100% + 5px);
  transform: translate(.5em, -50%);
}

/* KEYFRAMES */
@keyframes tooltips-vert {
  to {
    opacity: .9;
    transform: translate(-50%, 0);
  }
}

@keyframes tooltips-horz {
  to {
    opacity: .9;
    transform: translate(0, -50%);
  }
}

/* FX All The Things */ 
[tooltip]:not([flow]):hover::before,
[tooltip]:not([flow]):hover::after,
[tooltip][flow^="up"]:hover::before,
[tooltip][flow^="up"]:hover::after,
[tooltip][flow^="down"]:hover::before,
[tooltip][flow^="down"]:hover::after {
  animation: tooltips-vert 300ms ease-out forwards;
}

[tooltip][flow^="left"]:hover::before,
[tooltip][flow^="left"]:hover::after,
[tooltip][flow^="right"]:hover::before,
[tooltip][flow^="right"]:hover::after {
  animation: tooltips-horz 300ms ease-out forwards;
}




</style>
    <div class="search-box p-3 bg-light">

        <form action="{{route('get.result')}}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="container">
                <h4 class="text-primary">@lang('alnkel.Search booking')</h4>

                <div class="row">
                    <div class="col-md-2">
                        <label class="d-block">@lang('alnkel.searchby')</label>
                        <select name="search-by" class="form-control">
                            <option value="pnr" {{request()->get("search-by") == "pnr" ? "selected" : ''}} >
                                @lang('alnkel.pnr')
                            </option>
                            <option value="ticket" {{request()->get("search-by") == "ticket" ? "selected" : ''}} >
                                @lang('alnkel.ticketnum')
                            </option>
                            <option value="firstname" {{request()->get("search-by") == "firstname" ? "selected" : ''}} >
                                @lang('alnkel.first_name')
                            </option>
                            <option value="lastname" {{request()->get("search-by") == "lastname" ? "selected" : ''}} >
                                @lang('alnkel.last_name')
                            </option>
                            <option value="date" {{request()->get("search-by") == "date" ? "selected" : ''}} >
                                @lang('alnkel.date')
                            </option>
                        </select>
                    </div>
                    <div class="col-md-8 search-columns" data-col="pnr">
                        <label class="d-block">@lang('alnkel.pnr')</label>
                        <input type="text" name="pnr" value="{{request()->get("pnr")}}" class="form-control"
                               placeholder="@lang('alnkel.Search by PNR')">
                    </div>
                    <div class="col-md-8 search-columns" data-col="ticket" hidden>
                        <label class="d-block">@lang('alnkel.ticketnum')</label>
                        <input type="text" name="ticket_num" value="{{request()->get("ticket_num")}}"
                               class="form-control" placeholder="Search by ticket number">
                    </div>
                    <div class="col-md-8 search-columns" data-col="firstname" hidden>
                        <label class="d-block">@lang('alnkel.first_name')</label>
                        <input type="text" name="first_name" value="{{request()->get("first_name")}}"
                               class="form-control"
                               placeholder="Search by passenger name">
                    </div>
                    <div class="col-md-8 search-columns" data-col="lastname" hidden>
                        <label class="d-block">@lang('alnkel.last_name')</label>
                        <input type="text" name="last_name" value="{{request()->get("last_name")}}" class="form-control"
                               placeholder="Search by passenger last name">
                    </div>
                    <div class="col-md-4 search-columns" data-col="date" hidden>
                        <label class="d-block">@lang('alnkel.fromdate')</label>
                        <input type="date" name="from_date" value="{{request()->get("from_date")}}" class="form-control"
                               placeholder="From Date">
                    </div>
                    <div class="col-md-4 search-columns" data-col="date" hidden>
                        <label class="d-block">@lang('alnkel.todate')</label>
                        <input type="date" name="to_date" value="{{request()->get("to_date")}}" class="form-control"
                               placeholder="To Date">
                    </div>
                    <div class="col-md-2 pt-3">
                        <input type="submit" value="@lang('alnkel.Search')" class="btn btn-primary mt-3">
                    </div>
                </div>
        </form>
    </div>
    </div>

    @isset($rows)
        @if (count($rows)>0)
            <section class="container mt-4">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" >
                        <table class="table table-striped" cellspacing="0">
                            <thead class="thead-dark">
                            <tr>
                                <th>@lang('alnkel.pnr')</th>
                                <th>@lang('alnkel.first_name')</th>
                                <th>@lang('alnkel.last_name')</th>
                              <th>@lang('alnkel.price')</th>
                                <th>@lang('alnkel.ticket_number')</th>
                                <th>@lang('alnkel.flight_class')</th>
                                <th>@lang('alnkel.created_at')</th>
                                <th>Controls</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr @if (Auth::check()) tooltip="سعر الشركة : ${{ $row->price_seats - $row->commission}}" @endif>
                                    <td class="">{{$row->pnr}}</td>
                                    <td class="">{{$row->first_name ? $row->first_name : "xxx"}}</td>
                                    <td class="">{{$row->last_name ? $row->last_name : "xxx"}}</td>
                                     <td class="">{{$row->price_seats ? $row->price_seats - $row->commission : "00"}}</td>
                                    <td class="">{{$row->ticket_number ? $row->ticket_number[0] : "xxx"}}</td>
                                    <td class="">{{$row->flight_class}}</td>
                                    <td class="">{{\Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}}</td>
                                    <td>
                                        <a href="{{url("/profile/charter")}}/{{ $row->order_id ? $row->order_id : $row->id }}"
                                           class="btn btn-sm btn-warning" target="_blank">Manage Order</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </section>
        @else
            <div class="text-danger text-center p-4">No results found</div>
        @endif
    @endisset

@endsection

@section("scripts")
    <script>
        $('[name=search-by]').on('change', function () {
            let value = $(this).val();
            $('.search-columns').attr("hidden", true);
            $('[data-col=' + value + ']').removeAttr("hidden");
        }).trigger("change");
    </script>
@endsection

@section('styles')
    <style>
        .table-st {
            background-color: #fff;
            margin-top: 140px !important;
            border-radius: 10px;
            padding: 30px 10px;
        }

        .search-charter {
            margin-top: 60px;
        }

        .flo {
            float: right;
        }
    </style>
@stop
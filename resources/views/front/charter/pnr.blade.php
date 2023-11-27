@extends('layouts.master-front')

@section('title')
    Ticket Search
@endsection

@section('page-header')
    <!-- Start page-heder -->
    <div class="page-header">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start d-flex -->
            <div class="d-flex align-items-center justify-content-center">
                <i class="icons8-plane"></i>
                <span>@lang("Ticket Search")</span>
            </div>
            <!-- End d-flex -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End page-header -->
@endsection

@section('style')
    <style>
        .search, .main-news-title, .general-news {
            display: none;
        }
    </style>
@endsection

@section('content')


    <div class="search-box p-3 bg-light">

        <form>
            <div class="container">
                <h4 class="text-primary">@lang("alnkel.Search with PNR")</h4>

                <div class="row">
                    <div class="col-md-4 search-columns" data-col="pnr">
                        <input type="text" name="pnr" value="{{request()->get("pnr")}}" class="form-control"
                               placeholder="@lang("alnkel.Search by PNR")">
                    </div>
                    <div class="col-md-8">
                        <input type="submit" value="@lang('alnkel.Search')" class="btn btn-primary">
                      
                      @if( request()->get("pnr") )
                      <a href=" {{  route("download-charter-ticket" , [ "pnr" => request()->get("pnr") ]) }}" class="btn btn-primary" style="background: #fe0068;border: 2px solid black;border-radius: 50px;">
                   <i class="fas fa-ticket-alt" style="font-size: 14px;"></i> &nbsp; Download</a>
                      
                      <button style="background: #fe0068;border: 2px solid black;border-radius: 50px;" onclick="printDiv('printableArea')" class="btn btn-primary"  >
                        <i class="fa fa-print" aria-hidden="true"></i>
                        Print
                      </button>
                      
                      
                      @if (Auth::check()) 
                       @if( isset($ticket))
                      <a href=" {{  route("charterDetails" , $order->id  ) }}" class="btn btn-primary" style="background: #fe0068;border: 2px solid black;border-radius: 50px;">
                   <i class="fas fa-eye" style="font-size: 14px;"></i> &nbsp; 
                       {{ App::getLocale() == 'ar' ? 'عرض فى لوحة اتحكم ' : 'show in dashboard' }}
                      </a>
                      
                      @endif 
                      
                      @endif 

                      @endif
                      
                    </div>
                  
                   
            </div>
        </form>
    </div>

    <div style="padding: 10px;">
        @if( isset($ticket))

{{--            @if($isAdmin)--}}
{{--            <a href="{{url("/")}}/admin/charter/{{$order->charter->id}}/orders?pnr={{Request()->get("pnr")}}" class="btn btn-sm btn-warning" style="margin: 20px auto 50px auto;display: table;">--}}
{{--                @lang("Ticket In Dashboard")--}}
{{--            </a>--}}
{{--            @endif--}}

            <div class="container" id="printableArea">
                {!!$ticket!!}
            </div>
        @else
            <div style="text-align: center;" class="p-3">@lang("No Tickets Found")</div>
        @endif
    </div>
      
      <script>
      function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
      </script>

@endsection
<html>
<head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style>
  

   
   @if(! isset($isSearch))
    html, body {
        font-family: 'XB Riyaz', sans-serif;
        max-width: 800px;
    }
    @endif
	body { font-family: DejaVu Sans, sans-serif; }

  
    table {
        width: 100%;
        text-align: left;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .table-title {
        text-align: center;
        background: #03B0F1;
        color: #fff;
        font-weight: bold;
    }

    .table-title-2 {
        text-align: center;
        background: #636363;
        color: #fff;
        font-weight: bold;
    }

    h3 {
        text-align: center;
        margin-bottom: 5px;
    }

    th {
        background: #e0e0e0;
    }

    .page-break {
        page-break-after: always;
    }

    .instructions {
        text-align: center;
        font-weight: bold;
        margin: 20px 0;
    }

    img.logo {
        width: 140px;
        display: table;
        margin: 10px auto;
    }

  
    .text-danger {
        color: #ff0000 !important;
    }

    .text-info {
        color: #36a3f7 !important;
    }

    .text-success {
        color: #2c682c !important;
    }

    .all-caps {
        text-transform: uppercase;
    }

    .qrcode {
        width: 140px
    }

    .all-bold {
        font-weight: bold;
    }
</style>
</head>
  <body>
    
    
            <div style="text-align:center;" >
                <img width="120" height="60" src="{{url('front-assets/images/basic/logo2.png')}}" alt="logo">
 
            </div>
    


<table>
    <tr>
        <td width="30%">
            <div style="text-align: center;float:left;">
                <img src="https://api.qrserver.com/v1/create-qr-code/?color=000000&bgcolor=FFFFFF&data={{$order->pnr}}&qzone=1&margin=0&size=140x140&ecc=L"
                     class="qrcode"/>
                <br/>
                <strong>PNR</strong>
                <br/>
                <strong class="all-caps text-danger">{{$order->pnr}}</strong>
            </div>
        </td>
     

 
      
         @if (Auth::check()) 
                    @if( Auth::user()->id  == $order->user->id ||  Auth::user()->type =="Super Admin")
 

   

        <td>
            <table>
                <tr>
                    <td width="120">Booking Status</td>
                    <td>: <strong
                                class="text-{{$statusColors[$order->status]}}">{{$status[$order->status]}}</strong>
                    </td>
                </tr>
                @if($order->status == "TimeLimit")
                    <tr>
                        <td width="120">Ticket Expire</td>
                        <td>: <strong
                                    class="text-danger">{{$order->expire_at->format("d-m-Y h:i a")}}</strong>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>Booking Date</td>
                    <td>: {{\Carbon\Carbon::parse($order->created_at)->format("D, d M, Y")}}</td>
                </tr>
                <tr>
                    <td>Contact Name</td>
                    <td class="all-caps">
                        : {{$order->passengers[0]->first_name . ' ' . $order->passengers[0]->last_name}}</td>
                </tr>
                <tr>
                    <td>Contact Number</td>
                    <td>: {{$order->phone}}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>: <a href="mailto:{{$order->user->email}}">{{$order->user->email}}</a></td>
                </tr>
                <tr>
                    <td>Agent</td>
                    <td>: {{$order->user->company}}</td>
                </tr>
            </table>
        </td>
          @endif
      @endif

        <td width="25%">
            <img src="{{ str_replace("/storage", "https://alnkhel.com/storage", Storage::url("app/public/".$order->charter->aircraft->logo)) }}"
                 class="logo"/>
        </td>
    </tr>
</table>
    

<table class="all-bold">
    <tr>
        <td colspan="7" class="table-title all-caps">Flight Information / معلومات الرحلة</td>
    </tr>

    @foreach($order->flights as $key => $flight)
        <tr>
            <th colspan="7">{{ $key == 0 ? "Departure Flight" : "Return Flight" }}</th>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td width="70"><strong>Departing</strong></td>
                        <td>: {{$flight->charter->from->code}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">{{$flight->charter->from->name['en']}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">{{\Carbon\Carbon::parse($flight->charter->flight_date)->format("D, d M, Y")}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">{{  date("H:i", strtotime($flight->charter->departure_time)) }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td width="70"><strong>Arriving</strong></td>
                        <td>: {{$flight->charter->to->code}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">{{$flight->charter->to->name['en']}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">{{\Carbon\Carbon::parse($flight->charter->arrival_day)->format("D, d M, Y")}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ date("H:i", strtotime($flight->charter->arrival_time)) }}</td>
                    </tr>
                  
                  <tr>
                       <td colspan="2"> Arrival Day : {{\Carbon\Carbon::parse($flight->charter->arrival_day)->format("D, d M, Y")}} </td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td width="70"><strong>Carrier</strong></td>
                        <td>: {{$flight->charter->aircraft->name}}</td>
                    </tr>
                    @if($order->status != "TimeLimit")
                        <tr>
                            <td width="70"><strong>Flight No</strong></td>
                            <td>: {{$flight->charter->flight_number}}</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    @endforeach
</table>

<table>
    <tr>
        <td colspan="4" class="table-title">Passenger Information / معلومات المسافر</td>
    </tr>
    <tr>
        <th>Passenger Name</th>
        @if($order->status != "TimeLimit")
            <th>{{$order->flight_type == "RoundTrip" ? "Departure Ticket No" : "Ticket No"}}</th>
        @endif
        @if($order->flight_type == "RoundTrip")
            <th>Return Ticket No</th>
        @endif
        <th>Class</th>
    </tr>
    @foreach($order->passengers as $passenger)
        <tr>
            <td>{{strtoupper($passenger->title . ': ' . $passenger->first_name . ' ' . $passenger->last_name)}}</td>
            @if($order->status != "TimeLimit")
                <td>{{$passenger->ticket_number[0]}}</td>
                @if($order->flight_type == "RoundTrip")
                    <td>{{$passenger->ticket_number[1]}}</td>
                @endif
            @endif
            <td>{{$order->flight_class}}</td>
        </tr>
    @endforeach
</table>

       @if (Auth::check()) 
              @if( Auth::user()->id  == $order->user->id ||  Auth::user()->type =="Super Admin")

@if(!$hide_prices)
    <table>
        <tr>
            <td colspan="2" class="table-title">Payment Details / تفاصيل الدفع</td>
        </tr>
        <tr>
            <td width="50%" style="border-bottom: 1px solid #333;">
                <table>
                    <tr>
                        <td>Total Price (USD)</td>
                        <td>
                            {{ ($flights->sum('price')) }}
                        </td>
                    </tr>
                </table>
            </td>
            <td>

            </td>
        </tr>
    </table>
@endif
        @endif

    @endif

<div class="instructions">{!! nl2br($order->charter->instructions) !!}</div>

</body>
</html>
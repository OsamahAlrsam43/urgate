<html>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style>
    html, body {
        font-family: 'XB Riyaz', sans-serif;;
    }

    table {
        width: 100%;
        text-align: left;
        font-size: 20px;
        margin-bottom: 20px;
    }

    .table-title {
        text-align: center;
        background: #0A283F;
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
        display: table;
        margin: 10px auto;
    }
</style>

<?php $index = 0; ?>
@foreach($order->passengers as $passenger)

    @if($index == 0)
        <img src="{{ str_replace("/storage", "https://alnkhel.com/storage", Storage::url("app/public/".$order->travel->aircraft_logo)) }}" class="logo" />
    @endif

    <h3>@lang("RESERVATION CONFIRMED")</h3>

    <table>
        <tr>
            <td colspan="4" class="table-title">Passenger Information / معلومات المسافر</td>
        </tr>
        <tr>
            <th>@lang("Passenger Type")</th>
            <th>Name(s)</th>
            <th>@lang("Passport No")</th>
            <th>@lang("Ticket No")</th>
        </tr>
        <tr>
            <td>{{($passenger->title == "MR" or $passenger->title == "MRS") ? "Adult" : ($passenger->title == "INF" ? "Baby" : "Child")}}</td>
            <td>{{strtoupper($passenger->title . ': ' . $passenger->first_name . ' ' . $passenger->last_name)}}</td>
            <td>{{$passenger->passport_number}}</td>
            <td>{{$passenger->ticket_number}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$passenger->ticket_back}}</td>
        </tr>
    </table>

	<?php
	$day = $order->day;
	$timestamp = strtotime( $order->travel->from_date );
	$date = date( "d/m/Y", $timestamp );
	$day_name = __( 'days.' . date( 'l', $timestamp ) );

	$timestamp = strtotime( $order->travel->to_date );
	$date_back = date( "d/m/Y", $timestamp );
	$day_name_back = __( 'days.' . date( 'l', $timestamp ) );
	?>

    <table>
        <tr>
            <td colspan="7" class="table-title">Flight Information / معلومات الرحلة</td>
        </tr>
        <tr>
            <th>@lang("Carrier")</th>
            <th>@lang("Flight No")</th>
            <th>@lang("From")</th>
            <th>@lang("To")</th>
            <th>@lang("Date")</th>
            <th>@lang("Class")</th>
        </tr>
        <tr>
            <td>{{$order->travel->aircraft_operator}}</td>
            <td>{{$order->travel->flight_number}}</td>
            <td>{{\App\Country::find( $order->travel->from_country )->name[ App::getLocale() ]}}</td>
            <td>{{\App\Country::find( $order->travel->to_country )->name[ App::getLocale() ]}}</td>
            <td>{{$day_name. ' ' .$date}} ({{$order->travel->from_time}})</td>
            <td>{{$order->travel->class}}</td>
        </tr>
        <tr>
            <td>{{$order->travel->aircraft_operator}}</td>
            <td>{{$order->travel->flight_number}}</td>
            <td>{{\App\Country::find( $order->travel->to_country )->name[ App::getLocale() ]}}</td>
            <td>{{\App\Country::find( $order->travel->from_country )->name[ App::getLocale() ]}}</td>
            <td>{{$day_name_back. ' ' .$date_back}}</td>
            <td>{{$order->travel->class}}</td>
        </tr>
    </table>

    <table style="text-align: center">
        <tr>
            <td colspan="6" class="table-title">Booking Details / تفاصيل الحجز</td>
        </tr>
        <tr>
            <th width="25%">@lang("PNR")</th>
            <td>
                {{$order->pnr}}
            </td>
            <th>Issued date / تاريخ الحجز</th>
            <td>
                {{\Carbon\Carbon::parse($order->created_at)->format("Y/m/d - h:i a")}}
            </td>
        </tr>
        <tr>
            <th>@lang("Agent")</th>
            <td>
                {{$order->user->company}}
            </td>
            <th>@lang("Email")</th>
            <td>
                {{$order->user->email}}
            </td>
        </tr>
        <tr>
            <th>@lang("Phone")</th>
            <td>
                {{$order->user->phone}}
            </td>
            <th>@lang("Total Cost")</th>
            <td>
                ${{$order->back_id != 0 ? ($passenger->price + $passenger->price_back) : $passenger->price}}
            </td>
        </tr>
    </table>

    @if($index == 0)
        <div class="instructions"><span style="color: red;">تعليمات المسافر</span><br /><br />{!! nl2br($order->travel->instructions) !!}</div>
    @endif

	<?php $index ++; ?>

    @if($index < count($order->passengers))
        <div class="page-break"></div>
    @endif

@endforeach

</body>
</html>
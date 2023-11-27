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
</style>

<table>
    <tr>
        <td colspan="10" class="table-title">Passengers Data / بيانات المسافرين</td>
    </tr>
    <tr>
        <th>Ticket No</th>
        <th>PNR</th>
        <th>Full Name</th>
        <th>Birth Date</th>
        <th>Nationality</th>
        <th>Passport Number</th>
        <th>Passport Expire Date</th>
        <th>Class</th>
        <th>Price</th>
        <th>Agent</th>
    </tr>
    @foreach($orders as $order)
        @foreach($order->passengers as $passenger)
            <tr>
                <td>{{$passenger->ticket_number}}</td>
                <td>{{$order->pnr}}</td>
                <td>{{strtoupper($passenger->title . ': ' . $passenger->first_name . ' ' . $passenger->last_name)}}</td>
                <td>{{$passenger->birth_date}}</td>
                <td>{{\App\Nationality::find($passenger->nationality)->name['en']}}</td>
                <td>{{$passenger->passport_number}}</td>
                <td>{{$passenger->passport_expire_date}}</td>
                <td>{{$passenger->class}}</td>
                <td>{{$passenger->price}}</td>
                <td>{{$order->user->company}}</td>
            </tr>
        @endforeach
    @endforeach
</table>
</body>
</html>
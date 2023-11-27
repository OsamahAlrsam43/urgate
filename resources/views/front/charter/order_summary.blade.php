<div class="summary sticky-top">
    <h5 class="bg-dark text-light p-2">Tickets <span class="float-right">PNR - {{$pnr}} -</span></h5>

    <table class="table table-bordered table-sm m-0">
        <thead>
        <tr class="table-active">
            <th>Passenger Name</th>
            <th>Ticket Number</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tickets as $ticket)
            <tr>
                <td>{{$ticket['name']}}</td>
                <td>{{$ticket['ticket']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
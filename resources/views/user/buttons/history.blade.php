<table class="table table-bordered table-striped mb-0">
    <tr>
        <th scope="col">@lang("Action")</th>
        <th scope="col">@lang("Date")</th>
        <th scope="col">@lang("IP")</th>
        <th scope="col">@lang("User Name")</th>
    </tr>
    @foreach($order->history as $item)
    <tr>
        <td>{{$item->action}}</td>
        <td>{{$item->created_at}}</td>
        <td>{{$item->ip}}</td>
        <td>{{$item->user->name}}</td>
    </tr>
    @endforeach
</table>
@if($cancel_fees > 0)
    <div class="alert alert-success mb-3">Confirm the cancellation fees and cancel the ticket?</div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="d-block">@lang("Total Price")</label>
            <input type="text" value="${{$order->price}}" class="form-control" disabled="disabled"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="d-block">@lang("Cancellation fees")</label>
            <input type="text" value="${{$cancel_fees}}" class="form-control" disabled="disabled"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="d-block">@lang("Refund Amount")</label>
            <input type="text" value="${{$order->status == 'TimeLimit' ? 0 : $order->price - $cancel_fees}}" class="form-control" disabled="disabled"/>
        </div>
    </div>
</div>
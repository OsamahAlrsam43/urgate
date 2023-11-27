<div class="form-group">
    <label class="d-block">@lang("Email")</label>
    <input type="text" name="send_mail" class="form-control email"
           placeholder="Your email to receive ticket" value="{{$order->email}}"/>
</div>

<label class="mt-checkbox mt-checkbox-outline m-0">
    <input type="checkbox" class="hide_prices" value="yes" /><span></span>
    Hide Payment Details
</label>


<link href="{{asset('public/assets/css/styles.css')}}" rel="stylesheet">
<form action="{form-action}" id="cancel-form" method="post">
    {{ csrf_field() }}
    <div class="whole-notice bg-info text-white p-2">The whole order will be canceled</div>
    <div class="partial-notice bg-danger text-white p-2" hidden>The only selected flight will be
        cancelled
    </div>

    <table class="table table-responsive table-bordered table-hover mt-2">
        <thead>
        <tr>
            <th>Flight</th>
            <th>Price</th>
        </tr>
        @foreach($order->flights as $i=>$flight)
            <tr>
                <th>
                    <label class="mt-checkbox mt-checkbox-outline m-0">
                        <input type="checkbox" class="cancelable-checkbox cancelable-flight" name="flights[]"
                               data-flight_checkbox="{{$flight->charter->id}}" value="{{$flight->charter->id}}" {{$order->flights()->count() == 1 ? "checked" : null}} {{$i == 0 ? "disabled" : null}}/>
                        <span></span> {{$flight->charter->name}}
                    </label>
                </th>
                <th>
                    <div class="cancelable-price" data-charter="{{$flight->charter->id}}">{{$pp}}</div>
                </th>
            </tr>
        @endforeach
        </thead>
        <tbody>
        </tbody>
    </table>

    <a class="btn btn-danger btn-sm cancel-all-ticket mb-2">Cancel All Ticket</a>

    <div class="form-group">
        <label>Refund amount</label>
        <input type="text" class="amount form-control text-danger" name="amount" required/>
    </div>

    <input type="hidden" name="cancel_all" value="1">
</form>

<script>
    $('.cancel-all-ticket').on('click', function () {
        let cancelAll = $('[name=cancel_all]').val() == 1;

        $('.cancelable-flight').attr("checked", !cancelAll);
        $('.cancelable-checkbox').trigger('change');
    });

    $('.cancelable-checkbox').on('change', function () {
        var allFlights = $('[name="flights[]"]'),
            selectedFlights = $('[name="flights[]"]:checked');

        var allCheckboxes = allFlights.length,
            selectedCheckboxes = selectedFlights.length;

        var wholeNotice = $('.whole-notice'),
            partialNotice = $('.partial-notice');

        var cancelAll = $('[name=cancel_all]');

        // All selected
        if (allCheckboxes === selectedCheckboxes) {
            wholeNotice.removeAttr('hidden');
            partialNotice.attr('hidden', true);

            cancelAll.val(1);
        }
        // Not all selected
        else {
            wholeNotice.attr('hidden', true);
            partialNotice.removeAttr('hidden');

            cancelAll.val(0);
        }

        // Calculate
        $('.cancelable-price').each(function () {
            var charter = $(this).data('charter');

            var isCharterChecked = $('[data-flight_checkbox=' + charter + ']').is(':checked');

            if (isCharterChecked) {
                $(this).addClass('in-calculation text-danger').removeClass('text-success');
            } else {
                $(this).removeClass('in-calculation text-danger').addClass('text-success');
            }
        });

        calculateRefundAmount();
    });

    $('.cancelable-checkbox').trigger('change');

    function calculateRefundAmount() {
        var amount = 0;
        $('.in-calculation').each(function () {
            amount += parseFloat($(this).text())
        });

        $('#cancel-form .amount').val(amount);
    }
</script>
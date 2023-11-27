<link href="{{asset('public/assets/css/styles.css')}}" rel="stylesheet">
<form action="{form-action}" id="rebook-form" method="post">
    {{ csrf_field() }}

    <table class="table table-responsive table-bordered table-hover mt-2">
        <thead>
        <tr>
            <th>Flight</th>
            <th>Price</th>
        </tr>
        @foreach($order->cancelledFlights as $i=>$flight)
            <tr>
                <th>
                    <label class="mt-checkbox mt-checkbox-outline m-0">
                        <input type="checkbox" class="rebookable-checkbox rebookable-flight" name="flights[]"
                               data-flight_checkbox="{{$flight->charter->id}}" value="{{$flight->charter->id}}" checked/>
                        <span style="opacity: 0;"></span> {{$flight->charter->name}}
                    </label>
                </th>
                <th>
                    <div class="rebookable-price" data-charter="{{$flight->charter->id}}">{{$flight->price}}</div>
                </th>
            </tr>
        @endforeach
        </thead>
        <tbody>
        </tbody>
    </table>

    <div class="form-group">
        <label>Charge amount</label>
        <input type="text" class="amount form-control text-danger" name="amount" required/>
    </div>
</form>

<script>
    $('.rebookable-checkbox').on('change', function () {
        var allFlights = $('[name="flights[]"]'),
            selectedFlights = $('[name="flights[]"]:checked');

        var allCheckboxes = allFlights.length,
            selectedCheckboxes = selectedFlights.length;

        var wholeNotice = $('.whole-notice'),
            partialNotice = $('.partial-notice');

        var rebookAll = $('[name=rebook_all]');

        // All selected
        if (allCheckboxes === selectedCheckboxes) {
            wholeNotice.removeAttr('hidden');
            partialNotice.attr('hidden', true);

            rebookAll.val(1);
        }
        // Not all selected
        else {
            wholeNotice.attr('hidden', true);
            partialNotice.removeAttr('hidden');

            rebookAll.val(0);
        }

        // Calculate
        $('.rebookable-price').each(function () {
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

    $('.rebookable-checkbox').trigger('change');

    function calculateRefundAmount() {
        var amount = 0;
        $('.in-calculation').each(function () {
            amount += parseFloat($(this).text())
        });

        $('#rebook-form .amount').val(amount);
    }
</script>
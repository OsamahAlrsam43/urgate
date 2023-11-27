<form action="{form-action}" id="charter-reserve-form" method="post">
    {{ csrf_field() }}
    <input type="hidden" value="0" name="total_price" />
    <input type="hidden" value="{{$charter->id}}" name="charter" />
    <div class="row">
        <div class="col">
            <label class="d-block">Flight Class</label>
            <select class="form-control select2" name="flight_class" id="flight_class">
                <option @if(request()->get("class") == "Economy") selected @endif>Economy</option>
                <option @if(request()->get("class") == "Business") selected @endif>Business</option>
            </select>
        </div>
        <div class="col">
            <label class="d-block" for="adult">
                Adults
                <span class="text-success float-right economy_price">${{$charter->price_adult}}</span>
                <span class="text-success float-right business_price" hidden>${{$charter->business_adult}}</span>
            </label>
            <select class="form-control select2 counter" name="reserve_adults">
                @for($i=0;$i<=10;$i++)
                    <option @if(request()->get("adults") == $i) selected @endif>{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col">
            <label class="d-block" for="adult">
                Children
                <span class="text-success float-right economy_price">${{$charter->price_child}}</span>
                <span class="text-success float-right business_price" hidden>${{$charter->business_child}}</span>
            </label>
            <select class="form-control select2 counter" name="reserve_children">
                @for($i=0;$i<=10;$i++)
                    <option @if(request()->get("children") == $i) selected @endif>{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col">
            <label class="d-block" for="adult">
                Babies
                <span class="text-success float-right economy_price">${{$charter->price_baby}}</span>
                <span class="text-success float-right business_price" hidden>${{$charter->business_baby}}</span>
            </label>
            <select class="form-control select2 counter" name="reserve_babies">
                @for($i=0;$i<=10;$i++)
                    <option @if(request()->get("babies") == $i) selected @endif>{{$i}}</option>
                @endfor
            </select>
        </div>
    </div>
</form>

<hr/>

<div class="row justify-content-end">
    <div class="col-6">
        <table class="table table-bordered table-sm">
            <tr>
                <td>Adults</td>
                <td class="text-center">
                    <span class="economy_price">${{$charter->price_adult}}</span>
                    <span class="business_price" hidden>${{$charter->business_adult}}</span>
                    x
                    <span class="adult_count">0</span>
                </td>
                <td class="text-right total-adult">0</td>
            </tr>
            <tr>
                <td>Children</td>
                <td class="text-center">
                    <span class="economy_price">${{$charter->price_child}}</span>
                    <span class="business_price" hidden>${{$charter->business_child}}</span>
                    x
                    <span class="child_count">0</span>
                </td>
                <td class="text-right total-children">0</td>
            </tr>
            <tr>
                <td>Babies</td>
                <td class="text-center">
                    <span class="economy_price">${{$charter->price_baby}}</span>
                    <span class="business_price" hidden>${{$charter->business_baby}}</span>
                    x
                    <span class="babies_count">0</span>
                </td>
                <td class="text-right total-babies">0</td>
            </tr>
            <tr class="bg-light">
                <td colspan="3">
                    <strong class="text-info">Total</strong>
                    <strong class="text-info float-right total-price">0</strong>
                </td>
            </tr>
        </table>
    </div>
</div>

<script>
    $('.select2').select2({
        theme: 'bootstrap4',
        minimumResultsForSearch: Infinity
    });

    $("#flight_class, .counter").on('change', function () {
        var value = $(this).val(),
            economy_price = $('.economy_price'),
            business_price = $('.business_price'),
            reserve_adults = $('[name=reserve_adults]').val(),
            reserve_children = $('[name=reserve_children]').val(),
            reserve_babies = $('[name=reserve_babies]').val(),
            adult_count = $('.adult_count'),
            child_count = $('.child_count'),
            babies_count = $('.babies_count'),
            total_adult = $('.total-adult'),
            total_children = $('.total-children'),
            total_babies = $('.total-babies'),
            total_price = $('.total-price');

        var prices = {
            economy: {
                adult: {{$charter->price_adult}},
                child: {{$charter->price_child}},
                baby: {{$charter->price_baby}},
            },
            business: {
                adult: {{$charter->business_adult}},
                child: {{$charter->business_child}},
                baby: {{$charter->business_baby}},
            },
        };

        var selectedPrice = $('#flight_class').val() === "Economy" ? prices.economy : prices.business;

        if($(this).attr('id') === 'flight_class') {
            if (value === "Economy") {
                economy_price.removeAttr('hidden');
                business_price.attr('hidden', true);
            } else {
                business_price.removeAttr('hidden');
                economy_price.attr('hidden', true);
            }
        }

        adult_count.text(reserve_adults);
        child_count.text(reserve_children);
        babies_count.text(reserve_babies);

        var adultsPrice = reserve_adults * selectedPrice.adult,
            childrenPrice = reserve_children * selectedPrice.child,
            babiesPrice = reserve_babies * selectedPrice.baby;

        total_adult.text(adultsPrice > 0 ? `$${adultsPrice}` : 0);
        total_children.text(childrenPrice > 0 ? `$${childrenPrice}` : 0);
        total_babies.text(babiesPrice > 0 ? `$${babiesPrice}` : 0);

        total_price.text(`$${adultsPrice + childrenPrice + babiesPrice}`);

        $('[name=total_price]').val(adultsPrice + childrenPrice + babiesPrice);
    });

    $(function () {
        $("#flight_class").trigger("change")
    });
</script>

@if(isset($result))
    <div class="text-center">
        <h3 class="text-center p-3 btn btn-primary">Flights going</h3>
        <hr>
    </div>

<?php
        $adults=$params['adults'];
        $baby=$params['infants'];
        $children=$params['children'];
        $class_type=$params['cabin_class'];
?>
 <input type="hidden" id="count_adults" value="{{$adults}}">
 <input type="hidden" id="count_baby" value="{{$baby}}">
 <input type="hidden" id="count_children" value="{{$children}}">
 <input type="hidden" id="class_type" value="{{$class_type}}">
<div class="table-responsive text-nowrap ">
        <!--Table-->
        <table class="table table-striped table-bordered">

          <!--Table head-->
          <?php  $type=$params['cabin_class'] ?>
            <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Flight Date</th>
              <th>Flight Number	</th>
              <th>Airline</th>

              <th>From</th>
              <th>TO</th>
              <th>Seats</th>

             <th>Departure Time</th>
             <th>Arriaval Time</th>
                @if ($params['adults']>0)
              <th>Price Adult </th>
                @endif
                @if ($params['children']>0)
              <th>Price child</th>
                @endif
                @if ($params['infants']>0)
              <th>price baby</th>
                @endif
             
            </tr>
          </thead>
          <!--Table head-->

          <!--Table body-->
          <tbody>
          @foreach($result as $item)

              <tr>
             <td><input type="radio" name="goRow" class="goRowradio" required value="{{$item->id}}"></td>
              <td class="nr">{{$item->flight_date}}</td>
              <td>{{$item->flight_number}}</td>
              <td>{{$item->aircraft}}</td>

              <td>{{$startCountry}}</td>
              <td>{{$endCountry}}</td>

              <td>{{$type=='economy'?$item->economy_seats:$item->business_seats}}</td>
              <td>{{$item->departure_time}}</td>
              <td>{{$item->arrival_time}}</td>
                @if ($params['adults']>0)
              <td>{{$type=='economy'?$item->price_adult_2way:$item->business_2way_adult}}</td>
                @endif
                @if ($params['children']>0)
                    <td>{{$type=='economy'?$item->price_child_2way:$item->business_2way_child}}</td>
                @endif
                @if ($params['infants']>0)
                    <td>{{$type=='economy'?$item->price_baby_2way:$item->business_2way_baby}}</td>
                @endif

           
            </tr>
          @endforeach
          </tbody>
          <!--Table body-->


        </table>
        <!--Table-->
      </div>
<form method="post" action="{{$prevWeekUrl}}" class="ml-5" style="float: left">
    {{ csrf_field() }}
    <input type="submit" class="btn btn-sm btn-warning" value="<< ">
</form>
<form method="post" action="{{$nextWeekUrl}}" class="mr-5" style="float: right">
    {{ csrf_field() }}
    <input type="submit" class="btn btn-sm btn-warning" value=">> ">
</form>

@endif


@if(isset($return_result) )
        <div class="text-center">
            <h3 class="text-center p-3 btn btn-success">Return flights</h3>
            <hr>
        </div>


<div class="table-responsive text-nowrap mt-4">
        <!--Table-->
    <table class="table table-striped table-bordered tab">

        <!--Table head-->
        <?php  $type=$params['cabin_class'] ?>
        <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Flight Date</th>
            <th>Flight Number	</th>
            <th>Airline</th>

            <th>From</th>
            <th>TO</th>
            <th>Seats</th>

            <th>Departure Time</th>
            <th>Arriaval Time</th>
            @if ($params['adults']>0)
                <th>Price Adult </th>
            @endif
            @if ($params['children']>0)
                <th>Price child</th>
            @endif
            @if ($params['infants']>0)
                <th>price baby</th>
            @endif

        </tr>
        </thead>
        <!--Table head-->

        <!--Table body-->
        <tbody>
        @foreach($return_result as $return_item)
            <tr>
                <td><input type="radio" name="returnRow" class="returnRow" required value="{{$return_item->id}}"></td>
                <td>{{$return_item->flight_date}}</td>
                <td>{{$return_item->flight_number}}</td>
                <td>{{$return_item->aircraft}}</td>

                <td>{{$endCountry}}</td>
                <td>{{$startCountry}}</td>

                <td>{{$type=='economy'?$return_item->economy_seats:$return_item->business_seats}}</td>
                <td>{{$return_item->departure_time}}</td>
                <td>{{$return_item->arrival_time}}</td>
                @if ($params['adults']>0)
                    <td>{{$type=='economy'?$return_item->price_adult_2way:$return_item->business_2way_adult}}</td>
                @endif
                @if ($params['children']>0)
                    <td>{{$type=='economy'?$return_item->price_child_2way:$return_item->business_2way_child}}</td>
                @endif
                @if ($params['infants']>0)
                    <td>{{$type=='economy'?$return_item->price_baby_2way:$return_item->business_2way_baby}}</td>
                @endif


            </tr>
        @endforeach
        </tbody>
        <!--Table body-->


    </table>


        </table>
        <!--Table-->

      </div>
<form method="post" action="{{$prevWeekUrl}}" class="ml-5" style="float: left">
    {{ csrf_field() }}
    <input type="submit" class="btn btn-sm btn-warning" value="<< ">
</form>
<form method="post" action="{{$nextWeekUrl}}" class="mr-5" style="float: right">
    {{ csrf_field() }}
    <input type="submit" class="btn btn-sm btn-warning" value=">> ">
</form>
<form style="" action="{{route('charterCheckoutToWay')}}" method="post" id="form">
    {{ csrf_field() }}
    <input type="hidden" id="goId" name="goId" value=""/>
    <input type="hidden" id="returnId" name="returnId" value=""/>
    <input type="hidden" id="adults" name="adults" value="adults"/>
    <input type="hidden" id="children" name="children" value=""/>
    <input type="hidden" id="baby" name="baby" value=""/>
    <input type="hidden" id="class" name="class" value=""/>
</form>

<!--Section: Live preview-->

@endif

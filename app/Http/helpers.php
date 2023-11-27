<?php

use Illuminate\Support\Str;

/**
 * Helper Functions
 */

function getCommission( $item ) {
	$commission = $item->commission;
	$is_percent = $item->is_percent == 1 ? true : false;

	if ( Auth::Check() ) {
		$currentUser = Auth::user()->id;

		$check_special = \App\SpecialCommission::where( 'user_id', $currentUser )->where( 'item_id', $item->id )->first();

		if ( $check_special ) {
			$commission = $check_special->commission;
			$is_percent = $check_special->is_percent;
		}
	}

	$commissionObject             = new StdClass();
	$commissionObject->commission = $commission;
	$commissionObject->is_percent = $is_percent;

	return $commissionObject;
}

function calculateCommission( $item, $price , $total = 0 ) {
	$commission = getCommission( $item );
	if ( $commission->is_percent ) {
		// return $price -  $price * ( ( 100 - $commission->commission ) / 100 ) ;
      
      	//  return  $price - round( $price * ( ( 100 - $commission->commission ) / 100 ), 2) ;
      
      //return  $price *   ( $commission->commission  ) ;
      $c =  round($commission->commission / ($price / 100),2);
      return    ( $commission->commission  % 100 )* $price   ;
	}

	return $commission->commission;
}

//function calculateCommission( $item, $price ) {
//	$commission = getCommission( $item );
//	if ( $commission->is_percent ) {
//		return $price - round( $price * ( ( 100 - $commission->commission ) / 100 ), 2 );
//	}
//
//	return $commission->commission;
//}

// Get charter price
function getPriceObject( $pricing_id ) {
	return \App\CharterPrice::find( $pricing_id );
}

function getPrice( $pricing_id, $age , $flight_type,$open_duration=0  ) {
	$pricing = getPriceObject( $pricing_id );

	$column = "price_{$age}_";

	if ( $flight_type == "OneWay") {
		$column .= "1";
	}

	if ( $flight_type == "RoundTrip" ) {
		$column .= "2";
	}

	if ( $flight_type == "OpenReturn" ) {
		$column .= "3_$open_duration";
	}

	return $pricing->{$column};
}

// Generate PNR
function generatePNR() {
	$pnr     = '';
	$randPos = rand( 1, 4 );
	for ( $i = 0; $i < 6; $i ++ ) {
		if ( $i == $randPos ) {
			$pnr .= strtoupper( Str::random( 1 ) );
		} else {
			$pnr .= rand( 1, 9 );
		}
	}

	return $pnr;
}

// Generate Ticket Number
function generateTicketNumber() {
	$ticket = rand( 1111111, 9999999 );

	return $ticket;
}

// Add charter history
function addCharterHistory( $order_id, $action ) {
	\App\CharterHistory::create( [
		"order_id" => $order_id,
		"action"   => $action,
		"ip"       => request()->ip(),
		"user_id"  => \Illuminate\Support\Facades\Auth::user()->id
	] );
}

function deleteModalHTML( $item ) {
	?>
    <!--begin::Modal-->
    <div class="modal fade" id="delete-<?php echo $item ?>" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Delete Flight
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure that you want to remove this <?php echo $item ?>?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-danger" id="delete-<?php echo $item ?>-button">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

    <script>
        $(document).on('click', '.delete-modal', function () {
            $('#delete-<?php echo $item ?>-button').val($(this).data('url'));
        });

        $("#delete-<?php echo $item ?>-button").click(function () {
            window.location = $(this).val();
        });
    </script>
	<?php
}
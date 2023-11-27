<?php

namespace App\Http\Controllers\Charter;

use App\Charter;
use App\CharterPrice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class CharterPricing extends Controller {
	public function index( Charter $charter, Request $request, Builder $builder ) {
		$pricing = $charter->prices;
		
		$economy_seats = 0;
		$business_seats = 0;
		foreach ($charter->prices as $class){
		    if ($class->flight_class == "Economy") $economy_seats += $class->seats;
		    if ($class->flight_class == "Business") $business_seats += $class->seats;
        }
//		dd($pricing,$economy_seats,$business_seats);
		$seatsData =(object)[
		    'economy_seats'=>$charter->economy_seats,
		    'economy_sold_seats'=>$economy_seats,

		    'business_seats'=>$charter->business_seats,
		    'business_sold_seats'=>$business_seats,
        ];

		return view( 'admin.charter.pricing', compact( 'charter', 'pricing','seatsData' ) );
	}

	public function addPricing( Charter $charter, Request $request ) {
		$seats        = $request->get( "seats" );
		$price_class  = $request->get( "price_class" );
		$flight_class = $request->get( "flight_class" );
		$id           = $request->get( "id" );

		$message = null;
		$error   = false;

		if ( $seats == 0 ) {
			$error   = true;
			$message = "Please add seats first";
		}
        
		// Update
		if ( $id > 0 ) {
		    $result=CharterPrice::find( $id );
		     $seats2=$seats;
			if($result->seats > $result->available_seats){
			    $seats2=$seats-($result->seats - $result->available_seats);
			}
			$result->update( $request->all() + [ 'available_seats' => $seats2 ] );
		} else {
			$check = $charter->prices()->where( "flight_class", $flight_class )->where( "price_class", $price_class )->count();
			if ( $check > 0 ) {
				$error   = true;
				$message = "You already have seats for this class";
			}

			if ( ! $error ) {
				$charter->prices()->create( $request->all() + [ 'available_seats' => $seats ] );
			}
		}

		return response()->json( [
			"error"   => $error,
			"message" => $message
		] );
	}

	public function deletePricing( Charter $charter, Request $request ) {
		$id = $request->id;
		CharterPrice::find( $id )->delete();

		return redirect()->back()->with( [ 'success' => 'Pricing class has been deleted successfully' ] );
	}

	public function updatePricing( Charter $charter, Request $request ) {

	}
}

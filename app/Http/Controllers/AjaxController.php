<?php

namespace App\Http\Controllers;

use App\Charter;
use App\CharterOrders;
use App\Messages;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller {

	public function autoComplete( Request $request ) {
		$item       = $request->post( 'item' );
		$select     = $request->post( 'select' );
		$idField    = $request->post( 'id' );
		$textFields = $request->post( 'text' );
		$joiner     = $request->post( "join" );

		$itemClass = new \stdClass();

		if ( $item === "charter" ) {
			$itemClass = Charter::class;
		}

		if ( $item === "user" ) {
			$itemClass = User::class;
		}

		$query = $itemClass::select( $select );

		foreach ( $select as $i => $v ) {
			$query->orWhere( $v, 'like', '%' . $request->post( 'search' ) . '%' );
		}

		$results = $query->get();

		$data = [];
		foreach ( $results as $result ) {
			$text = [];
			foreach ( $textFields as $field ) {
				$text[] = $result->{$field};
			}

			$data[] = [
				'id'   => $result->{$idField},
				'text' => join( " $joiner ", $text ),
			];
		}

		return response()->json( [
			'results' => $data
		] );
	}

	public function calculateCharterPrice( Request $request ) {
		$order_id = $request->post( "order" );
		$newClass = $request->post( "newClass" );
		$flights  = $request->post( "flights" );

		$order      = CharterOrders::find( $order_id );
		$passengers = $order->passengers;

		$prices = [];

		foreach ( $passengers as $passenger ) {
			$price = 0;
			foreach ( $flights as $flight_id ) {
				$flight = Charter::find($flight_id);
				$class = $newClass == "Business" ? "business" : "price";

				$flight_price = floatval($flight->{$class . "_" . $passenger->age});
				$price += $flight_price;
			}
			$prices[$passenger->id] = $price;
		}

		return response()->json($prices);
	}

	public function cancelCharterForm( Request $request ) {
		$order = CharterOrders::find($request->get('id'));
         $pp = $order->price ;
		return view('admin.orders.charter.cancel', compact('order' , 'pp'));
	}

	public function rebookCharterForm( Request $request ) {
		$order = CharterOrders::find($request->get('id'));

		return view('admin.orders.charter.rebook', compact('order'));
	}

	public function charterReserveForm( Request $request ) {
		$charter = Charter::find($request->get('id'));

		return view('front.charter.reserveForm', compact('charter'));
	}

	public function checkMessages() {
		$currentUser = Auth::user();
		$hasMessages = $currentUser != null ? $currentUser->unreadMessages > 0  : null  ;

		return response()->json([
			'hasMessages' => $hasMessages,
			'lastMessage' => $hasMessages ? $currentUser->lastMessage : false
		]);
	}

	public function readMessages() {
		$currentUser = Auth::user();
		$currentUser->messages()->update([
			'read_at' => Carbon::now()
		]);
	}

}

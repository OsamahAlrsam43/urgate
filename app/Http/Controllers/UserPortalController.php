<?php

namespace App\Http\Controllers;

use App\Charter;
use App\CharterOrderFlights;
use App\CharterOrders;
use App\FlightOrders;
use App\Mail\TicketEmail;
use App\Transaction;
use App\TravelOrders;
use App\User;
use App\Visa;
use App\VisaOrders;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTables;

class UserPortalController extends Controller {
	/**
	 * UserPortalController constructor.
	 */
	public function __construct() {
		$this->middleware( 'auth' );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		Session::flash( 'sidebar', 'user-portal-index' );

		$isAdmin = false;

		if ( Auth::check() and Auth::user()->type == 'Super Admin' ) {
			$isAdmin = true;
		}

		$user = Auth::user();

		$visaCommission = Transaction::where('to', $user->id)->where('comment', 'Visa commission')->sum('amount');
		$charterCommission = CharterOrders::where('user_id', $user->id)->sum('commission');
		$totalCommission = $visaCommission + $charterCommission;

		$points = CharterOrders::where('user_id', $user->id)->where('status', 'Confirmed')->count();
		$points += VisaOrders::where('user_id', $user->id)->where('status', 'received')->count();

		return view( 'admin.profile', compact( 'isAdmin', 'charterCommission', 'points', 'visaCommission', 'totalCommission' ) );
	}

	public function changeAvatar( Request $request ) {
		$image = Storage::disk( 'public' )->put( 'visa/logos', $request->file( 'avatar' ) );

		$user         = Auth::user();
		$user->avatar = $image;
		$user->save();

		return back()->with( 'success', 'You have successfully changed your logo.' );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function travels() {
		Session::flash( 'sidebar', 'user-portal-travels' );

		$travels = Auth::user()->travelPurchases;

		return view( 'user.travels', compact( 'travels' ) );
	}

	/**
	 * @param TravelOrders $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function cancelTravel( TravelOrders $order ) {
		if ( $order->status === 'received' ) {
			return redirect()->back()->with( [ 'fail' => 'you can\'t cancel for now because your ticket request now is on progress.' ] );
		}

		if ( $order->status === 'rejected' ) {
			return redirect()->back()->with( [ 'fail' => 'you can\'t cancel for now because your ticket request has been rejected.' ] );
		}

		if ( $order->status === '1' ) {
			return redirect()->back()->with( [ 'fail' => 'you can\'t cancel for now because your ticket has been Delivered.' ] );
		}

		$order->update( [ 'status' => 'canceled' ] );

		// Save to transactions
		$new_balance = Auth::user()->balance + $order->price;

		if ( $order->travel->commission > 0 ) {
			$commissionObject = getCommission( $order->travel );
			$commission       = $commissionObject['commission'];

			if ( $commissionObject['is_percent'] ) {
				$commission = ( $order->price * $commissionObject['commission'] ) / 100;
			}
		}

		$new_balance -= $commission;

		Auth::user()->userTransactions()->create( [
			'to'             => $order->user_id,
			'amount'         => $order->price,
			'comment'        => "Travel cancellation refund",
			'type'           => "DepositOfCredit",
			'creditBefore'   => Auth::user()->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $order->id,
			'connectedTable' => 'travel'
		] );

		Auth::user()->update( [ 'balance' => $new_balance ] );

		return redirect()->back()->with( [ 'success' => 'you successfully canceled this travel ticket' ] );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function flights() {
		Session::flash( 'sidebar', 'user-portal-flights' );

		$flights = Auth::user()->flightPurchases;

		return view( 'user.flights', compact( 'flights' ) );
	}

	/**
	 * @param FlightOrders $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function cancelFlight( FlightOrders $order ) {
		if ( $order->status === 'received' ) {
			return redirect()->back()->with( [ 'fail' => 'you can\'t cancel for now because your flight ticket request now is on progress.' ] );
		}

		if ( $order->status === 'rejected' ) {
			return redirect()->back()->with( [ 'fail' => 'you can\'t cancel for now because your flight ticket request has been rejected.' ] );
		}

		if ( $order->status === '1' ) {
			return redirect()->back()->with( [ 'fail' => 'you can\'t cancel for now because your flight ticket has been Delivered.' ] );
		}

		$order->update( [ 'status' => 'canceled' ] );

		// Save to transactions
		$new_balance = Auth::user()->balance + $order->price;

		if ( $order->flight->commission > 0 ) {
			$commissionObject = getCommission( $order->flight );
			$commission       = $commissionObject['commission'];
			if ( $commissionObject['is_percent'] ) {
				$commission = ( $order->price * $commissionObject['commission'] ) / 100;
			}
		}

		$new_balance -= $commission;

		Auth::user()->userTransactions()->create( [
			'to'             => $order->user_id,
			'amount'         => $order->price,
			'comment'        => "Flight cancellation refund",
			'type'           => "DepositOfCredit",
			'creditBefore'   => Auth::user()->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $order->id,
			'connectedTable' => 'flight'
		] );

		Auth::user()->update( [ 'balance' => $new_balance ] );

		return redirect()->back()->with( [ 'success' => 'you successfully canceled this travel ticket' ] );
	}


	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function charter() {
		Session::flash( 'sidebar', 'user-portal-charter' );

		// Cancel expired orders
		$ordersToExpire = Auth::user()->charterPurchases()->where( "expire_at", '<', Carbon::now() )->get();
		foreach ( $ordersToExpire as $order ) {
			$order->update( [
				'status'    => 'Cancelled',
				'expire_at' => null
			] );
		}

		$orders = Auth::user()->charterPurchases()->where( "status", "!=", "TimeLimit" )->orderBy( "id", "desc" )->get();

		$timelimitOrders = Auth::user()->charterPurchases()->whereNotNull( "expire_at" )->where( "status", "TimeLimit" )->orderBy( "id", "desc" )->get();


		return view( 'user.charter', compact( 'orders', 'timelimitOrders' ) );
	}

	public function charterDetails( CharterOrders $order ) {
     // dd(\Request::get('eye'));
      	$user_id = Auth::user()->id;
		
		$order2=CharterOrders::where('pnr',$order->pnr)->where('id','!=',$order->id)->get();
	    //dd($order->created_at->diffInHours());
		
		if ( $order->user_id != $user_id  &&  \Request::get('eye') == null ) {
			return redirect()->route( "user-profile" );
		}
        
		if ( $order->status == "TimeLimit" and $order->expire_at < Carbon::now() ) {
			return redirect()->route( "listUserCharter" );
		}

		if ( $order->status == "Cancelled" ) {
			return redirect()->route( "listUserCharter" );
		}

		Session::flash( 'sidebar', 'user-portal-charter' );

		$isCancelled = false;
		$limited     = false;
		if ( $order->status == "Cancelled" ) {
			$isCancelled = true;
		}

		if ( $order->status == "TimeLimit" ) {
			$limited = true;
		}

		$canSplit = $order->passengers()->where( "age", "adult" )->count() > 1;

		$canVoid   = false;
		$canCancel = false;
		
		$charter = $order->charter;
        
      if( isset($charter)){
        if ( $charter->void_max > 0 ) {
			$hours = $order->created_at->diffInHours();

			if ( $charter->void_max > $hours ) {
				$canVoid = true;
			}
		}

		if ( $charter->can_cancel and ! $canVoid ) {
			$canCancel = true;
		}

		if ( $isCancelled ) {
			$canVoid   = false;
			$canCancel = false;
		}
        
        
		//////////////////////////
		$canCancel = false;
		if($order->charter->can_cancel){

		  //  dd(  );
		    
    		$cancelArr=collect([$order->charter->cancel_days_1,$order->charter->cancel_days_2,$order->charter->cancel_days_3])->sort()->values();
    		
    		for($i=sizeof($cancelArr)-1;$i>=0;$i--){
        		if(\Carbon\Carbon::now()->diffInHours( \Carbon\Carbon::parse(\Carbon\Carbon::parse($order->charter->flight_date)->format('Y-m-d')." ".\Carbon\Carbon::parse($order->charter->departure_time)->format('H:i:s')),false) > $cancelArr[$i]) {
        			$canCancel = true;
        			if($order->charter->cancel_days_1 == $cancelArr[$i]){
        			    $order->charter->cancel_fees=$order->charter->cancel_fees_1;
        			    $order->charter->save();
        			    break;
        			}
        			if($order->charter->cancel_days_2 == $cancelArr[$i]){
        			    $order->charter->cancel_fees=$order->charter->cancel_fees_2;
        			    $order->charter->save();
        			    break;
        			}
        			if($order->charter->cancel_days_3 == $cancelArr[$i]){
        			    $order->charter->cancel_fees=$order->charter->cancel_fees_3;
        			    $order->charter->save();
        			    break;
        			}
        		}
    		}
		}
      }
		
		
		
		
		
		
		////////////////////////
		

		/*if($order->charter->flight_date->diffInHours() < 24) {
			$canCancel = false;
		}*/

		if ( ! request()->has( "secret" ) ) {
//			return null;
		}

		$isOpen = $order->flight_type == "OpenReturn";
		
		return view( 'user.charter_details', compact( 'order','order2', 'canSplit', 'canCancel', 'canVoid', 'isCancelled', 'limited', 'isOpen' ) );
	}

	public function payOrder( Charter $charter, CharterOrders $order,  Request $request ) {
		$total = $order->price;

		$order->update( [
			'status' => 'Confirmed'
		] );

		$new_balance = Auth::user()->balance - $total;
		
		Auth::user()->userTransactions()->create( [
			'to'             => Auth::user()->id,
			'amount'         => $total,
			'pnr'            => $order->pnr,
			'comment'        => "Charter order payment",
			'type'           => "withdrawal",
			'creditBefore'   => Auth::user()->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $charter->id,
			'connectedTable' => 'charter'
		] );

        $new_balance += calculateCommission( $order->charter, $order->price );
        Auth::user()->userTransactions()->create( [
			'to'             => Auth::user()->id,
			'amount'         => $total,
			'pnr'            => $order->pnr,
			'comment'        => "Commission order payment",
			'type'           => "DepositOfCredit",
			'creditBefore'   => Auth::user()->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $charter->id,
			'connectedTable' => 'charter'
		] );
        
        
		Auth::user()->update( [ 'balance' => $new_balance ] );

		return redirect()->route( 'listUserCharter' );
	}

	public function charterButtons( CharterOrders $order, Request $request ) {
		$action   = $request->get( "action" );
		
		$adults   = $order->passengers()->where( "age", "adult" )->count();
		$children = $order->passengers()->where( "age", "child" )->count();
		$babies   = $order->passengers()->where( "age", "baby" )->count();

		if ( $action == "download_option" ) {
			$type = $request->get( "type" );
			addCharterHistory( $order->id, "$type Ticket" );

			return view( "user.buttons.download_options" )->render();
		}

		if ( $action == "history" ) {
			return view( "user.buttons.history", compact( 'order' ) )->render();
		}

		if ( $action == "reschedule" or $action == "search_flights" ) {
			$isSearch     = $action == "search_flights";
			$flight_class = $request->get( "flight_class" );
			$flight_date  = $request->get( "flight_date" );
			$id           = $request->get( "id" );
			$isOpen       = $request->get( "isOpen" ) == "true";

			if($isOpen) {
				$flight_class = $order->flight_class;
			}

			$currentFlight = CharterOrderFlights::find( $id );

			$flights = [];
			if ( $isSearch ) {

				$fromWhere = $isOpen ? $order->charter->to_where : $order->charter->from_where;
				$flights_search = Charter::where( "flight_date", $flight_date )->where('from_where', $fromWhere)->get();

				foreach ( $flights_search as $flight ) {
					if ( $flight_class == "Economy" ) {
					    
					    $EP=$flight->prices()->where('flight_class',"Economy")->where('available_seats','>',$adults+$children)->get()[0];
						$price = ( $adults * $EP->price_adult_1 );
						$price += ( $children * $EP->price_child_1 );
						$price += ( $babies * $EP->price_inf_1 );
					} else {
					    $BP=$flight->prices()->where('flight_class',"Business")->where('available_seats','>',$adults+$children)->get()[0];
						$price = ( $adults * $EP->price_adult_1 );
						$price += ( $children * $EP->price_child_1 );
						$price += ( $babies * $EP->price_inf_1 );
					}

					$flight->price = $price;
					$flights[]     = $flight;
				}
			}

			$nextDay = Carbon::parse( $flight_date )->addDays( 1 )->format( "Y-m-d" );
			$prevDay = Carbon::parse( $flight_date )->subDays( 1 )->format( "Y-m-d" );

			$minDate = Carbon::now()->format("Y-m-d");
			$maxDate = Carbon::now()->addYear()->format("Y-m-d");

			if($isOpen) {
				$maxDate = $order->created_at->addMonths($order->open_duration)->format("Y-m-d");
			}
			
			$changeArr=collect([$order->charter->change_days_1,$order->charter->change_days_2,$order->charter->change_days_3])->sort()->values();
        
            for($i=sizeof($changeArr)-1;$i>=0;$i--){
                if(\Carbon\Carbon::now()->diffInHours( \Carbon\Carbon::parse(\Carbon\Carbon::parse($order->charter->flight_date)->format('Y-m-d')." ".\Carbon\Carbon::parse($order->charter->departure_time)->format('H:i:s')),false) > $changeArr[$i]){
                  $canchange = true;
                  if($order->charter->change_days_1 == $changeArr[$i]){
                      $order->charter->change_fees=$order->charter->change_fees_1;
                      $order->charter->save();
                      break;
                  }
                  if($order->charter->change_days_2 == $changeArr[$i]){
                      $order->charter->change_fees=$order->charter->change_fees_2;
                      $order->charter->save();
                      break;
                  }
                  if($order->charter->change_days_3 == $changeArr[$i]){
                      $order->charter->change_fees=$order->charter->change_fees_3;
                      $order->charter->save();
                      break;
                  }
                }
            }

			return view( "user.buttons.reschedule", compact( 'order', 'isSearch', 'flight_class', 'flight_date', 'flights', 'currentFlight', 'nextDay', 'prevDay', 'isOpen', 'minDate', 'maxDate' ) )->render();
		}

		if($action == "book_return") {
			$newFlightId  = $request->get( "selectedFlight" );
			$flight_class = $request->get( "flight_class" );

			$order->flights()->create( [
				"charter_id"   => $newFlightId,
				"flight_class" => $flight_class
			] );

			addCharterHistory( $order->id, "Booked Return Flight" );

			return response()->json( [
				"done"  => true,
				"error" => false,
			] );
		}

		if ( $action == "reschedule_process" ) {
			$id           = $request->get( "id" );
			$newFlightId  = $request->get( "selectedFlight" );
			$payment      = $request->get( "payment" );
			$flight_class = $request->get( "flight_class" );

			$newFlight = Charter::find( $newFlightId );

			if ( $flight_class == "Economy" ) {
			    $EP=$newFlight->prices()->where('flight_class',"Economy")->where('available_seats','>',$adults+$children)->get()[0];
				$price = ( $adults * $EP->price_adult_1 );
				$price += ( $children * $EP->price_child_1 );
				$price += ( $babies * $EP->price_inf_1 );
			} else {
			    $BP=$flight->prices()->where('flight_class',"Business")->where('available_seats','>',$adults+$children)->get()[0];
				$price = ( $adults * $BP->price_adult_1 );
				$price += ( $children * $BP->price_child_1 );
				$price += ( $babies * $BP->price_inf_1 );
			}
            
            $editSeats=$order->charter->prices()->where('flight_class',$flight_class)->where('price_adult_1',($order->passengerRelated)[0]->price)->get()[0];
            $editSeats->available_seats+=1;
            $editSeats->save();
            
            
			$order->update( [
				"charter_id"   => $newFlightId,
				"price"        => $price,
				"flight_class" => $flight_class
			] );
			$order= CharterOrders::find($order->id);
			$order->passengerRelated()->update( [
				"price"        => $price,
				"flight_id" => $newFlightId
			] );
			$order->flights()->find( $id )->update( [
				"charter_id"   => $newFlightId,
				"price"        => $price,
				"flight_class" => $flight_class
			] );
			
			$editSeats2=$order->charter->prices()->where('flight_class',$flight_class)->where('price_adult_1',($order->passengerRelated)[0]->price)->get()[0];
            $editSeats2->available_seats-=1;
            $editSeats2->save();
			
			
            
			$new_balance = Auth::user()->balance - $payment;

			Auth::user()->userTransactions()->create( [
				'to'             => $order->user_id,
				'amount'         => $payment,
				'comment'        => "Charter change fees",
				'type'           => "withdrawal",
				'creditBefore'   => Auth::user()->balance,
				'creditAfter'    => $new_balance,
				'connectedID'    => $order->id,
				'connectedTable' => 'charter'
			] );

            

			Auth::user()->update( [ 'balance' => $new_balance ] );

			addCharterHistory( $order->id, "Reschedule Flight" );

			return response()->json( [
				"done"  => true,
				"error" => false,
				"editSeats" => $editSeats,
				"editSeats2" => $editSeats2
			] );
		}

		if ( $action == "send_email_form" ) {
			
			return view( "user.buttons.send_email", compact( 'order' ) )->render();
		}

		if ( $action == "send_email" ) {
          //  dd($request->get( "email" ) );
			//Mail::to( $request->send_mail  )->send( new TicketEmail( $request, $order ) );
          Mail::to( $request->get( "email" ) )->send( new TicketEmail( $request, $order ) );
			addCharterHistory( $order->id, "Send Ticket" );

			return response()->json( [
				"sent"  => true,
				"error" => false,
			] );
		}

		if ( $action == "edit_details" ) {
			$form = $request->get( "form" );
			if ( $form ) {
				return view( "user.buttons.edit_details_form", compact( 'order', 'form' ) )->render();
			}

			if ( $request->has( "note" ) ) {
				$order->note = $request->get( "note" );
				addCharterHistory( $order->id, "Edit Note" );
			} else {
				$order->phone = $request->get( "phone" );
				$order->email = $request->get( "email" );
				addCharterHistory( $order->id, "Edit Contact Details" );
			}

			$order->save();
		}

		if ( $action == "cancel_void_form" ) {
			$isVoid      = $request->get( "isVoid" ) == "true";
			
			if(! $isVoid ){
			    $cancelArr=collect([$order->charter->cancel_days_1,$order->charter->cancel_days_2,$order->charter->cancel_days_3])->sort()->values();
    		
            		for($i=sizeof($cancelArr)-1;$i>=0;$i--){
                		if(\Carbon\Carbon::now()->diffInHours( \Carbon\Carbon::parse(\Carbon\Carbon::parse($order->charter->flight_date)->format('Y-m-d')." ".\Carbon\Carbon::parse($order->charter->departure_time)->format('H:i:s')),false) > $cancelArr[$i]){
                			$canCancel = true;
                			if($order->charter->cancel_days_1 == $cancelArr[$i]){
                			    $order->charter->cancel_fees=$order->charter->cancel_fees_1;
                			    $order->charter->save();
                			    break;
                			}
                			if($order->charter->cancel_days_2 == $cancelArr[$i]){
                			    $order->charter->cancel_fees=$order->charter->cancel_fees_2;
                			    $order->charter->save();
                			    break;
                			}
                			if($order->charter->cancel_days_3 == $cancelArr[$i]){
                			    $order->charter->cancel_fees=$order->charter->cancel_fees_3;
                			    $order->charter->save();
                			    break;
                			}
                		}
            		}
			}
			
			$cancel_fees = ($isVoid || $order->status == 'TimeLimit') ? 0 : $order->charter->cancel_fees;

			return view( "user.buttons.cancel_void_form", compact( 'order', 'cancel_fees' ) )->render();
		}

		if ( $action == "cancel_void" ) {
			$isVoid = $request->get( "isVoid" ) == "true";
			
			
            $new_balance= Auth::user()->balance;
            
            if($order->status != "TimeLimit"){
    			$new_balance = Auth::user()->balance + $order->price;
    			$new_balance -= calculateCommission( $order->charter, $order->price );
            }
            
			if ( ! $isVoid ) {
			    if($order->status != "TimeLimit"){
			        $cancelArr=collect([$order->charter->cancel_days_1,$order->charter->cancel_days_2,$order->charter->cancel_days_3])->sort()->values();
    		        
            		for($i=sizeof($cancelArr)-1;$i>=0;$i--){
                		if(\Carbon\Carbon::now()->diffInHours( \Carbon\Carbon::parse(\Carbon\Carbon::parse($order->charter->flight_date)->format('Y-m-d')." ".\Carbon\Carbon::parse($order->charter->departure_time)->format('H:i:s')),false) > $cancelArr[$i]){
                			$canCancel = true;
                			if($order->charter->cancel_days_1 == $cancelArr[$i]){
                			    $order->charter->cancel_fees=$order->charter->cancel_fees_1;
                			    $order->charter->save();
                			    break;
                			}
                			if($order->charter->cancel_days_2 == $cancelArr[$i]){
                			    $order->charter->cancel_fees=$order->charter->cancel_fees_2;
                			    $order->charter->save();
                			    break;
                			}
                			if($order->charter->cancel_days_3 == $cancelArr[$i]){
                			    $order->charter->cancel_fees=$order->charter->cancel_fees_3;
                			    $order->charter->save();
                			    break;
                			}
                		}
            		}
				    $new_balance -= $order->charter->cancel_fees;
			    }
			}
			$column = "price_adult_";

        	if ( $order->flight_type == "OneWay") {
        		$column .= "1";
        	}
        
        	if ( $order->flight_type == "RoundTrip" ) {
        		$column .= "2";
        	}
            $addSeats= $order->charter->prices()->where('flight_class',$order->flight_class)->where($column,$order->price)->get()[0];
            $addSeats->available_seats+=1;
            $addSeats->save();
			Auth::user()->userTransactions()->create( [
				'to'             => $order->user_id,
				'amount'         => $order->price,
				'comment'        => "Charter cancellation refund",
				'type'           => "DepositOfCredit",
				'creditBefore'   => Auth::user()->balance,
				'creditAfter'    => $new_balance,
				'connectedID'    => $order->id,
				'pnr'            => $order->pnr,
				'connectedTable' => 'charter'
			] );

			Auth::user()->update( [ 'balance' => $new_balance ] );

			addCharterHistory( $order->id, "Cancel Ticket" );
			$order->status = "cancelled";
			$order->save();
		}

		return null;
	}

	/**
	 * @param CharterOrders $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function cancelCharterTicket( CharterOrders $order ) {
		$order->update( [ 'status' => 'canceled' ] );

		// Save to transactions
		$minutes = ( time() - strtotime( $order->created_at ) ) / 60;

		if ( $minutes <= 120 ) {
			$new_balance = Auth::user()->balance + $order->price;

			if ( $order->charter->commission > 0 ) {
				$commissionObject = getCommission( $order->charter );
				$commission       = $commissionObject['commission'];
				if ( $commissionObject['is_percent'] ) {
					$commission = ( $order->price * $commissionObject['commission'] ) / 100;
				}
			}

			$new_balance -= $commission;

			Auth::user()->userTransactions()->create( [
				'to'             => $order->user_id,
				'amount'         => $order->price,
				'comment'        => "Charter cancellation refund",
				'type'           => "DepositOfCredit",
				'creditBefore'   => Auth::user()->balance,
				'creditAfter'    => $new_balance,
				'connectedID'    => $order->id,
				'connectedTable' => 'charter'
			] );

			Auth::user()->update( [ 'balance' => $new_balance ] );
		}

		return redirect()->back()->with( [ 'success' => 'you successfully canceled this charter ticket' ] );
	}

	public function ticketCharter( Request $request ) {
		Session::flash( 'sidebar', 'ticket-charter' );
		$orders = [];
		if ( $request->search ) {
			$orders = CharterOrders::where( "pnr", $request->search )->get();
		}

		return view( 'user.ticket', compact( 'orders' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function visa() {
		Session::flash( 'sidebar', 'user-portal-visa' );

		$visas = Auth::user()->visaPurchases;

		return view( 'user.visa', compact( 'visas' ) );
	}

	/**
	 * @param FlightOrders $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function cancelVisa( VisaOrders $order ) {
		if ( $order->status === 'received' ) {
			return redirect()->back()->with( [ 'fail' => 'you can\'t cancel for now because your visa request now is on progress.' ] );
		}

		if ( $order->status === 'rejected' ) {
			return redirect()->back()->with( [ 'fail' => 'you can\'t cancel for now because your visa request has been rejected.' ] );
		}

		if ( $order->status === '1' ) {
			return redirect()->back()->with( [ 'fail' => 'you can\'t cancel for now because your visa has been Delivered.' ] );
		}

		$order->update( [ 'status' => 'canceled' ] );

		// Save to transactions
		$new_balance = Auth::user()->balance + $order->price;

		if ( $order->visa->commission > 0 ) {
			$commissionObject = getCommission( $order->visa );
			$commission       = $commissionObject['commission'];
			if ( $commissionObject['is_percent'] ) {
				$commission = ( $order->price * $commissionObject['commission'] ) / 100;
			}
		}

		$new_balance -= $commission;

		Auth::user()->userTransactions()->create( [
			'to'             => $order->user_id,
			'amount'         => $order->price,
			'comment'        => "Visa cancellation refund",
			'type'           => "DepositOfCredit",
			'creditBefore'   => Auth::user()->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $order->id,
			'connectedTable' => 'visa'
		] );

		Auth::user()->update( [ 'balance' => $new_balance ] );

		return redirect()->back()->with( [ 'success' => 'you successfully canceled this travel ticket' ] );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function history() {
		Session::flash( 'sidebar', 'user-portal-history' );

		$travels      = Auth::user()->travelPurchases()->orderBy( 'id', 'DESC' )->limit( 5 )->get();
		$flights      = Auth::user()->flightPurchases()->orderBy( 'id', 'DESC' )->limit( 5 )->get();
		$visas        = Auth::user()->visaPurchases()->orderBy( 'id', 'DESC' )->limit( 5 )->get();
		$transactions = Auth::user()->userTransactions()->orderBy( 'id', 'DESC' )->limit( 5 )->get();

		$users = [];

		if ( Auth::user()->type === 'Super Admin' ) {
			$travels = TravelOrders::orderBy( 'id', 'DESC' )->limit( 5 )->get();
			$flights = FlightOrders::orderBy( 'id', 'DESC' )->limit( 5 )->get();
			$visas   = VisaOrders::orderBy( 'id', 'DESC' )->limit( 5 )->get();
			//$transactions = Transaction::orderBy( 'id', 'DESC' )->limit( 5 )->get();

			$users = User::select( "id", "name" )->get();
		}

//dd($transactions);
		return view( 'user.search.index', compact( 'travels', 'flights', 'visas', 'transactions', 'users' ) );
	}

	public function historyData( Datatables $datatables, Request $request ) {

		$isAdmin    = Auth::user()->type === 'Super Admin';
		$order_type = $request->get( 'order_type' );

		if ( $order_type == "travel" ) {
			$builder = $isAdmin ? TravelOrders::orderBy( 'id', 'DESC' ) : Auth::user()->travelPurchases()->orderBy( 'id', 'DESC' );

			return $datatables
				->of( $builder )
				->rawColumns( [ 'special_commission', 'locked', 'actions', 'economy_seats', 'business_seats' ] )
				->make();
		}

		if ( $order_type == "flight" ) {
			$builder = $isAdmin ? FlightOrders::orderBy( 'id', 'DESC' ) : Auth::user()->flightPurchases()->orderBy( 'id', 'DESC' );

			return $datatables
				->of( $builder )
				->rawColumns( [ 'special_commission', 'locked', 'actions', 'economy_seats', 'business_seats' ] )
				->make();
		}

		if ( $order_type == "visa" ) {
			$builder = $isAdmin ? VisaOrders::orderBy( 'id', 'DESC' ) : Auth::user()->visaPurchases()->orderBy( 'id', 'DESC' );

			return $datatables
				->of( $builder )
				->editColumn( 'delivered_by', function ( VisaOrders $order ) {
					return $order->deliveredBy ? $order->deliveredBy->name : '---';
				} )
				->editColumn( 'name', function ( VisaOrders $order ) {
					return $order->first_name . ' ' . $order->last_name;
				} )
				->editColumn( 'user', function ( VisaOrders $order ) {
					return $order->user->name;
				} )
				->editColumn( 'status', function ( VisaOrders $order ) {
					return $order->status == '1' ? 'Delivered <a href="' . route( 'visaDownloadPdf', [ 'visa' => $order->id ] ) . '" class="btn btn-sm btn-brand"><i class="fa fa-download"></i></a>' : ( $order->status == '0' ? 'Pending' : $order->status );
				} )
				->rawColumns( [ 'status' ] )
				->make();
		}

		if ( $order_type == "charter" ) {
			$builder = $isAdmin ? CharterOrders::orderBy( 'id', 'DESC' ) : Auth::user()->charterPurchases()->orderBy( 'id', 'DESC' );

			return $datatables
				->of( $builder )
				->editColumn( 'flights', function ( CharterOrders $order ) {
					return '<button class="btn btn-sm btn-accent show-flights" data-id="' . $order->id . '"><strong>(' . $order->flights()->count() . ')</strong> <i class="fa fa-plane" style="top: 2px;position: relative;left: 2px;"></i></button>';
				} )
				->editColumn( 'user_id', function ( CharterOrders $order ) {
					return $order->user->name;
				} )
				->rawColumns( [ 'actions', 'passengers', 'flights' ] )
             
				->make();
		}

		if ( $order_type == "transactions" ) {
			$builder = $isAdmin ? Transaction::orderBy( 'id', 'DESC' ) : Auth::user()->userTransactions()->orderBy( 'id', 'DESC' );

			return $datatables
				->of( $builder )
				->editColumn( 'from', function ( Transaction $order ) {
					return $order->fromUser->name;
				} )
				->editColumn( 'to', function ( Transaction $order ) {
					return $order->toUser->name;
				} )
				->editColumn( 'type', function ( Transaction $order ) {
					return $order->type == "withdrawal" ? '<span class="text-danger">Withdrawal</span>' : '<span class="text-success">Deposit</span>';
				} )
				->editColumn( 'connectedID', function ( Transaction $order ) {
					if ( $order->connectedID ) {
						switch ( $order->connectedTable ) {
							case( "visa" ):
								return 'Visa #' . $order->connectedID;
								break;
							case( "flight" ):
								return 'Flight #' . $order->connectedID;
								break;
							case( "travel" ):
								return 'Travel #' . $order->connectedID;
								break;
							case( "charter" ):
								return 'Charter #' . $order->connectedID;
								break;
						}
					} else {
						return 'Direct Transaction';
					}
				} )
				->rawColumns( [ 'type' ] )
              
              ->make();
		}


		return false;
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function search( Request $request ) {
		$travels      = Auth::user()->travelPurchases()
		                    ->where( 'created_at', '>=', Carbon::parse( $request->from )->format( 'Y-m-d' ) )
		                    ->where( 'created_at', '<=', Carbon::parse( $request->to )->format( 'Y-m-d' ) )
		                    ->orderBy( 'id', 'DESC' )
		                    ->get();
		$flights      = Auth::user()->flightPurchases()
		                    ->where( 'created_at', '>=', Carbon::parse( $request->from )->format( 'Y-m-d' ) )
		                    ->where( 'created_at', '<=', Carbon::parse( $request->to )->format( 'Y-m-d' ) )
		                    ->orderBy( 'id', 'DESC' )
		                    ->get();
		$visas        = Auth::user()->visaPurchases()->whereDate( 'created_at', '=', $request->from )
		                    ->where( 'created_at', '>=', Carbon::parse( $request->from )->format( 'Y-m-d' ) )
		                    ->where( 'created_at', '<=', Carbon::parse( $request->to )->format( 'Y-m-d' ) )
		                    ->orderBy( 'id', 'DESC' )
		                    ->get();
		$transactions = Auth::user()->userTransactions()
		                    ->where( 'created_at', '>=', Carbon::parse( $request->from )->format( 'Y-m-d' ) )
		                    ->where( 'created_at', '<=', Carbon::parse( $request->to )->format( 'Y-m-d' ) )
		                    ->orderBy( 'id', 'DESC' )
		                    ->get();

		if ( Auth::user()->type === 'Super Admin' ) {
			$travels      = TravelOrders::where( 'created_at', '>=', Carbon::parse( $request->from )->format( 'Y-m-d' ) )
			                            ->where( 'created_at', '<=', Carbon::parse( $request->to )->format( 'Y-m-d' ) )
			                            ->orderBy( 'id', 'DESC' )->get();
			$flights      = FlightOrders::where( 'created_at', '>=', Carbon::parse( $request->from )->format( 'Y-m-d' ) )
			                            ->where( 'created_at', '<=', Carbon::parse( $request->to )->format( 'Y-m-d' ) )
			                            ->orderBy( 'id', 'DESC' )->get();
			$visas        = VisaOrders::where( 'created_at', '>=', Carbon::parse( $request->from )->format( 'Y-m-d' ) )
			                          ->where( 'created_at', '<=', Carbon::parse( $request->to )->format( 'Y-m-d' ) )
			                          ->orderBy( 'id', 'DESC' )->get();
			$transactions = Transaction::where( 'created_at', '>=', Carbon::parse( $request->from )->format( 'Y-m-d' ) )
			                           ->where( 'created_at', '<=', Carbon::parse( $request->to )->format( 'Y-m-d' ) )
			                           ->orderBy( 'id', 'DESC' )->get();
		}

		return view( 'user.search.search', compact( 'travels', 'flights', 'visas', 'transactions' ) );
	}
}

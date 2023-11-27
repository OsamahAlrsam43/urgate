<?php

namespace App\Http\Controllers;

use App\Http\Requests\editVisaOrderRequest;
use App\Http\Requests\StoreVisaRequest;
use App\Http\Requests\UpdateVisaRequest;
use App\Notifications\Notifier;
use App\User;
use App\Visa;
use App\VisaOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class VisaController extends Controller {
	/**
	 * VisaController constructor.
	 */
	public function __construct() {
		$this->middleware( [ 'auth', 'dashboardAccess' ] );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		Session::flash( 'sidebar', 'visa' );

		$visas = Visa::all();

		return view( 'admin.visa.index', compact( 'visas' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() {
		Session::flash( 'sidebar', 'visa' );

		return view( 'admin.visa.create' );
	}

	/**
	 * @param StoreVisaRequest $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function store( StoreVisaRequest $request ) {
		$image = Storage::disk( 'public' )->put( 'visa/thumb', $request->file( 'thumb' ) );

		Visa::create( [
			'name'        => $request->name,
			'description' => $request->description,
			'papers'      => $request->papers,
			'visa_type'   => $request->visa_type,
			'price'       => $request->price,
			'thumb'       => $image,
			'best_offer'  => $request->best_offer,
			'commission'  => $request->commission,
			'is_percent'  => $request->is_percent,
		] );

		return redirect()->back()->with( [ 'success' => 'Visa Created Successfully.' ] );
	}


	/**
	 * @param Visa $visa
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit( Visa $visa ) {
		Session::flash( 'sidebar', 'visa' );

		return view( 'admin.visa.update', compact( 'visa' ) );
	}

	/**
	 * @param Visa $visa
	 * @param UpdateVisaRequest $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function update( Visa $visa, UpdateVisaRequest $request ) {
		$image = $visa->thumb;
		if ( $request->hasFile( 'thumb' ) ) {
			Storage::disk( 'public' )->delete( $visa->thumb );
			$image = Storage::disk( 'public' )->put( 'visa/thumb', $request->file( 'thumb' ) );
		}

		$visa->update( [
			'name'               => $request->name,
			'description'        => $request->description,
			'papers'             => $request->papers,
			'visa_type'          => $request->visa_type,
			'price'              => $request->price,
			'thumb'              => $image,
			'best_offer'         => $request->best_offer,
			'commission'         => $request->commission,
			'is_percent'         => $request->is_percent,
			'special_commission' => $request->special_commission,
		] );

		return redirect()->back()->with( [ 'success' => 'Visa Updated Successfully.' ] );
	}

	/**
	 * @param Visa $visa
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function destroy( Visa $visa ) {
		Storage::disk( 'public' )->delete( $visa->thumb );

		$visa->delete();

		return redirect()->back()->with( [ 'success' => 'Visa Deleted Successfully.' ] );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function visaOrders( Visa $visa ) {
		$visas = $visa->orders()->orderBy( 'id', 'DESC' )->get();

		return view( 'admin.orders.visa.visa', compact( 'visas' ) );
	}

	/**
	 * @param Visa $visa
	 * @param VisaOrders $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function changeVisaStatus( Visa $visa, VisaOrders $order, Request $request ) {
		if ( $order->status !== 'rejected' ) {

			$this->validate( $request, [
				'pdf' => 'required|mimes:pdf'
			], [
				'pdf.mimes' => 'Visa must be a file of type: pdf.'
			] );

			$pdf = Storage::disk( 'public' )->put( 'visa/pdf', $request->file( 'pdf' ) );

			$order->update( [ 'status' => '1', 'delivered_by' => Auth::user()->id, 'visa_pdf' => $pdf ] );

			Notification::send( User::find( $order->user_id ), new Notifier( [
				'message' => 'your visa has been delivered',
				'url'     => route( 'listUserVisas' )
			], 'Visa Ticket Request' ) );

		} else {
			return redirect()->back()->with( [ 'fail' => 'visa already rejected!' ] );
		}

		return redirect()->back()->with( [ 'success' => 'visa approved successfully!' ] );
	}


	/**
	 * @param Visa $visa
	 * @param VisaOrders $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function changeVisaStatusToReject( Visa $visa, VisaOrders $order ) {
		if ( $order->status === '0' || $order->status === 'received' ) {
			$order->update( [ 'status' => 'rejected' ] );

			Notification::send( User::find( $order->user_id ), new Notifier( [
				'message' => 'your visa request has been rejected',
				'url'     => route( 'listUserVisas' )
			], 'Visa Ticket Request' ) );

		} elseif ( $order->status === '1' ) {

			$order->update( [ 'status' => 'rejected' ] );

			Notification::send( User::find( $order->user_id ), new Notifier( [
				'message' => 'your visa request has been rejected',
				'url'     => route( 'listUserVisas' )
			], 'Visa Ticket Request' ) );


		} else {
			return redirect()->back()->with( [ 'fail' => 'visa already submitted!' ] );
		}

		return redirect()->back()->with( [ 'success' => 'visa rejected successfully!' ] );
	}

	/**
	 * @param Visa $visa
	 * @param VisaOrders $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function changeVisaStatusToCancel( Visa $visa, VisaOrders $order ) {
		if ( $order->status === '1' || $order->status == 'rejected' || $order->status === '0' || $order->status === 'received' ) {
			$GetUser = User::where( 'id', $order->user_id )->first();
			// return $GetUser;
			$new_balance = $GetUser->balance + $order->price;

			if ( $order->visa->commission > 0 ) {
				$commissionObject = getCommission( $order->visa );
				$commission       = $commissionObject['commission'];

				if ( $commissionObject['is_percent'] ) {
					$commission = ( $order->price * $commissionObject['commission'] ) / 100;
				}
			}

			$new_balance -= $commission;

			// Save to transactions
			Auth::user()->userTransactions()->create( [
				'to'             => $GetUser->id,
				'amount'         => $order->price,
				'comment'        => "Visa cancellation refund",
				'type'           => "DepositOfCredit",
				'creditBefore'   => $GetUser->balance,
				'creditAfter'    => $new_balance,
				'connectedID'    => $order->id,
				'connectedTable' => 'visa'
			] );

			// return $order;
			User::where( 'id', $order->user_id )->update( [ 'balance' => $new_balance ] );

			$order->update( [ 'status' => 'canceled' ] );

			Notification::send( User::find( $order->user_id ), new Notifier( [
				'message' => 'your visa request has been canceled',
				'url'     => route( 'listUserVisas' )
			], 'Visa Ticket Request' ) );


		} else {
			return redirect()->back()->with( [ 'fail' => 'visa already cancelled!' ] );
		}

		return redirect()->back()->with( [ 'success' => 'visa rejected successfully!' ] );
	}

	/**
	 * @param Visa $visa
	 * @param VisaOrders $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function changeVisaStatusToReceive( Visa $visa, VisaOrders $order ) {
		if ( $order->status === '0' ) {
			$order->update( [ 'status' => 'received' ] );

			Notification::send( User::find( $order->user_id ), new Notifier( [
				'message' => 'your visa request has been received',
				'url'     => route( 'listUserVisas' )
			], 'Visa Ticket Request' ) );
		} else {
			return redirect()->back()->with( [ 'fail' => 'visa already submitted!' ] );
		}

		return redirect()->back()->with( [ 'success' => 'visa canceled successfully!' ] );
	}

	/**
	 * @param Visa $visa
	 * @param VisaOrders $order
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function editVisaOrder( Visa $visa, VisaOrders $order ) {
		return view( 'admin.orders.visa.edit', compact( 'visa', 'order' ) );
	}

	/**
	 * @param Visa $visa
	 * @param VisaOrders $order
	 * @param editVisaOrderRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function editOrder( Visa $visa, VisaOrders $order, editVisaOrderRequest $request ) {
		$pdf = $order->visa_pdf;
		if ( $request->hasFile( 'pdf' ) ) {
			Storage::disk( 'public' )->delete( $visa->visa_pdf );
			$pdf = Storage::disk( 'public' )->put( 'visa/pdf', $request->file( 'pdf' ) );
		}

		$order->update( [
			'first_name'             => $request->first_name,
			'last_name'              => $request->last_name,
			'birth_place'            => $request->birth_place,
			'birth_date'             => $request->birth_date,
			'nationality'            => $request->nationality,
			'passport_number'        => $request->passport_number,
			'passport_issuance_date' => $request->passport_issuance_date,
			'passport_expire_date'   => $request->passport_expire_date,
			'father_name'            => $request->father_name,
			'mother_name'            => $request->mother_name,
			'visa_pdf'               => $pdf,
		] );

		return redirect()->back()->with( [ 'success' => 'order updated successfully!' ] );
    }
    
    public function lockVisa( Visa $visa ) {
		$message = $visa->locked == 1 ? 'visa UnLocked Successfully.' : 'visa Locked Successfully.';

		$visa->locked = $visa->locked == 1 ? 0 : 1;
		$visa->save();

		return redirect()->route( 'listVisas' )->with( [ 'success' => $message ] );
	}
}

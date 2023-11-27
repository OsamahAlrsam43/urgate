<?php

namespace App\Http\Controllers;

use App\Charter;
use App\CharterOrders;
use App\Country;
use App\Http\Requests\editTravelOrderRequest;
use App\Http\Requests\StoreTravelRequest;
use App\Http\Requests\UpdateTravelRequest;
use App\Nationality;
use App\Notifications\Notifier;
use App\Travel;
use App\TravelDownloadExport;
use App\TravelImage;
use App\TravelOrders;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class TravelController extends Controller
{
    /**
     * TravelController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'dashboardAccess']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Session::flash('sidebar', 'travels');

        $travels = Travel::all();

        return view('admin.travel.index', compact('travels'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        Session::flash('sidebar', 'travels');
        $countries = Country::all();

        return view('admin.travel.create', compact('countries'));
    }

    /**
     * @param StoreTravelRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StoreTravelRequest $request)
    {
        $image = Storage::disk('public')->put('travels/thumb', $request->file('thumb'));

        $travel = Travel::create([
            'name' => $request->name,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'from_country' => $request->from_country,
            'to_country' => $request->to_country,
            'price' => $request->price,
            'thumb' => $image,
            'period' => $request->period,
            'description' => $request->description,
            'best_offer' => $request->best_offer,
            'commission' => $request->commission,
            'is_percent' => $request->is_percent,
        ]);

        foreach ($request->file('images') as $image) {
            $image = Storage::disk('public')->put('travels/images', $image);
            $travel->images()->create([
                'image' => $image
            ]);
        }

        return redirect()->back()->with(['success' => 'Travel Created Successfully.']);
    }

    /**
     * @param Travel $travel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Travel $travel)
    {
        Session::flash('sidebar', 'travels');
        $countries = Nationality::all();

        return view('admin.travel.update', compact('travel', 'countries'));
    }

    /**
     * @param Travel $travel
     * @param UpdateTravelRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Travel $travel, UpdateTravelRequest $request)
    {
        $image = $travel->thumb;
        if ($request->hasFile('thumb')) {
            Storage::disk('public')->delete($travel->thumb);
            $image = Storage::disk('public')->put('travels/thumb', $request->file('thumb'));
        }

	    $aircraft_logo = $travel->aircraft_logo;
        if ($request->hasFile('aircraft_logo')) {
            Storage::disk('public')->delete($travel->aircraft_logo);
            $aircraft_logo = Storage::disk('public')->put('travels/thumb', $request->file('aircraft_logo'));
        }

        $travel->update([
            'name' => $request->name,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'from_country' => $request->from_country,
            'to_country' => $request->to_country,
            'price' => $request->price,
            'thumb' => $image,
            'period' => $request->period,
            'description' => $request->description,
            'best_offer' => $request->best_offer,
            'commission' => $request->commission,
            'is_percent' => $request->is_percent,
            'aircraft_logo' => $aircraft_logo,
            'aircraft_operator' => $request->aircraft_operator,
            'class' => $request->class,
            'flight_number' => $request->flight_number,
            'from_time' => $request->from_time,
            'instructions' => $request->instructions,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $image = Storage::disk('public')->put('travels/images', $image);
                $travel->images()->create([
                    'image' => $image
                ]);
            }
        }

        return redirect()->back()->with(['success' => 'Travel Updated Successfully.']);
    }

    /**
     * @param Travel $travel
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Travel $travel)
    {
        Storage::disk('public')->delete($travel->thumb);

        foreach ($travel->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $travel->delete();

        return redirect()->back()->with(['success' => 'Travel Deleted Successfully.']);
    }

    /**
     * @param TravelImage $image
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function removeImage(TravelImage $image)
    {
        Storage::disk('public')->delete($image->image);

        $image->delete();

        return response()->json(['success' => 'Travel Deleted Successfully.', 'image' => $image]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function travelOrders(Travel $travel, Request $request)
    {
	    $travels = $travel->orders()->orderBy( 'id', 'DESC' )->get();

	    $day = $request->get( "day" );
	    if ( isset( $day ) and $day != "all" ) {
		    $travels = $travel->orders()->where( "type", ( $day - 1 ) )->orderBy( 'id', 'DESC' )->get();
	    }

        return view('admin.orders.travel.travels', compact('travels', 'travel'));
    }

	public function travelOrdersDownload( Travel $travel, Request $request ) {
		$day = $request->get( "day" );
		return ( new TravelDownloadExport( $travel, $day ) )->download( 'PassengersData.xlsx' );
	}

    /**
     * @param Travel $travel
     * @param TravelOrders $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeTravelStatus(Travel $travel, TravelOrders $order, Request $request)
    {
        if ($order->status !== 'rejected') {
            $this->validate($request, [
                'pdf' => 'required|mimes:pdf'
            ], [
                'pdf.mimes' => 'Travel document must be a file of type: pdf.'
            ]);

            $pdf = Storage::disk('public')->put('travel/pdf', $request->file('pdf'));

            $order->update(['status' => '1', 'delivered_by' => Auth::user()->id, 'travel_pdf' => $pdf]);

            Notification::send(User::find($order->user_id), new Notifier([
                'message' => 'your travel ticket has been delivered',
                'url' => route('listUserTravels')
            ], 'Travel Ticket Request'));
        } else {
            return redirect()->back()->with(['fail' => 'travel already rejected!']);
        }

        return redirect()->back()->with(['success' => 'travel approved successfully!']);
    }

	public function cancelTravelTicket( Travel $travel, TravelOrders $order, Request $request ) {

		$order->update( [ 'status' => 'canceled', 'delivered_by' => Auth::user()->id ] );


		$travelPrice = $travel->price;
		$travelPrice[ $order->type ]['reserved_seats'] = $travel->price[ $order->type ]['reserved_seats'] - count( $order->passengers );

		$travel->update( [
			"price" => $travelPrice
		] );

		$price = $request->fees;

		if ( $price > 0 ) {
			// Save to transactions
			$user        = User::find( $order->user_id );
			$new_balance = $user->balance + $price;
			$user->userTransactions()->create( [
				'to'             => $user->id,
				'amount'         => $price,
				'comment'        => "Refund travel",
				'type'           => "DepositOfCredit",
				'creditBefore'   => $user->balance,
				'creditAfter'    => $new_balance,
				'connectedID'    => $order->id,
				'connectedTable' => 'travels'
			] );

			$user->update( [ 'balance' => $new_balance ] );
		}

		return redirect()->back()->with( [ 'success' => 'charter order has been cancelled!' ] );
	}


	/**
     * @param Travel $travel
     * @param TravelOrders $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeTravelStatusToReject(Travel $travel, TravelOrders $order)
    {
        if ($order->status === '0' || $order->status === 'received') {
            $order->update(['status' => 'rejected']);

            Notification::send(User::find($order->user_id), new Notifier([
                'message' => 'your travel ticket request has been rejected',
                'url' => route('listUserTravels')
            ], 'Travel Ticket Request'));
        } else {
            return redirect()->back()->with(['fail' => 'travel already submitted!']);
        }

        return redirect()->back()->with(['success' => 'travel rejected successfully!']);
    }

    /**
     * @param Travel $travel
     * @param TravelOrders $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeTravelStatusToReceive(Travel $travel, TravelOrders $order)
    {
        if ($order->status === '0') {
            $order->update(['status' => 'received']);

            Notification::send(User::find($order->user_id), new Notifier([
                'message' => 'your travel ticket request has been received',
                'url' => route('listUserTravels')
            ], 'Travel Ticket Request'));
        } else {
            return redirect()->back()->with(['fail' => 'travel already submitted!']);
        }

        return redirect()->back()->with(['success' => 'travel canceled successfully!']);
    }

    /**
     * @param Travel $travel
     * @param TravelOrders $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editTravelOrder(Travel $travel, TravelOrders $order)
    {
	    $nationalities = Nationality::all();
        return view('admin.orders.travel.edit', compact('travel', 'order', 'nationalities'));
    }

    /**
     * @param Travel $travel
     * @param TravelOrders $order
     * @param editTravelOrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editOrder(Travel $travel, TravelOrders $order, editTravelOrderRequest $request)
    {
	    for ( $i = 0; $i < count( $request->id ); $i ++ ) {
		    $order->passengers()->find( $request->id[ $i ] )->update( [
			    'title'                => $request->title[ $i ],
			    'first_name'           => $request->first_name[ $i ],
			    'last_name'            => $request->last_name[ $i ],
			    'birth_date'           => $request->birth_date[ $i ],
			    'nationality'          => $request->nationality[ $i ],
			    'passport_number'      => $request->passport_number[ $i ],
			    'passport_expire_date' => $request->passport_expire_date[ $i ],
		    ] );
	    }

        return redirect()->back()->with(['success' => 'order updated successfully!']);
    }
}

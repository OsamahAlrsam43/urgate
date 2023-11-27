<?php

namespace App\Http\Controllers;

use App\Country;
use App\Flight;
use App\FlightOrders;
use App\Http\Requests\editFlightOrderRequest;
use App\Http\Requests\StoreFlightRequest;
use App\Http\Requests\UpdateFlightRequest;
use App\Notifications\Notifier;
use App\User;
use App\Visa;
use App\VisaOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class FlightsController extends Controller
{
    /**
     * FlightsController constructor.
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
        Session::flash('sidebar', 'flights');

        $flights = Flight::all();

        return view('admin.flight.index', compact('flights'));
    }

    /**
     * @param Flight $flight
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Flight $flight)
    {
        Session::flash('sidebar', 'flights');

        return response()->json(['status' => 'success', 'flight' => $flight]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        Session::flash('sidebar', 'flights');
        $countries = Country::all();

        return view('admin.flight.create', compact('countries'));
    }

    /**
     * @param StoreFlightRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StoreFlightRequest $request)
    {
        $logo = Storage::disk('public')->put('flights/logos', $request->file('aircraft_logo'));
        $image = Storage::disk('public')->put('flights/thumb', $request->file('thumb'));

        Flight::create([
            'name' => $request->name,
            'ticket' => $request->ticket,
            'trip_information' => $request->trip_information,
            'class' => $request->class,
            'price' => $request->price,
            'aircraft_operator' => $request->aircraft_operator,
            'aircraft_logo' => $logo,
            'airplane_type' => $request->airplane_type,
            'seat_type' => $request->seat_type,
            'electric_port' => $request->electric_port,
            'display' => $request->display,
            'thumb' => $image,
            'best_offer' => $request->best_offer,
            'stop' => $request->stop,
            'cancellation_before_departure' => $request->cancellation_before_departure,
            'cancellation_before_departure_price' => $request->cancellation_before_departure_price,
            'cancellation_after_departure' => $request->cancellation_after_departure,
            'cancellation_after_departure_price' => $request->cancellation_after_departure_price,
            'absence' => $request->absence,
            'absence_price' => $request->absence_price,
            'change_before_departure' => $request->change_before_departure,
            'change_before_departure_price' => $request->change_before_departure_price,
            'change_after_departure' => $request->change_after_departure,
            'change_after_departure_price' => $request->change_after_departure_price,
            'commission' => $request->commission,
            'is_percent' => $request->is_percent,
        ]);

        return redirect()->back()->with(['success' => 'Flight Created Successfully.']);
    }

    /**
     * @param Flight $flight
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Flight $flight)
    {
        Session::flash('sidebar', 'flights');
        $countries = Country::all();

        return view('admin.flight.update', compact('flight', 'countries'));
    }

    /**
     * @param Flight $flight
     * @param UpdateFlightRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Flight $flight, UpdateFlightRequest $request)
    {
        // return $request;
        $logo = $flight->aircraft_logo;
        if ($request->hasFile('aircraft_logo')) {
            Storage::disk('public')->delete($flight->aircraft_logo);
            $logo = Storage::disk('public')->put('flights/logos', $request->file('aircraft_logo'));
        }
        $image = $flight->thumb;
        if ($request->hasFile('thumb')) {
            Storage::disk('public')->delete($flight->thumb);
            $image = Storage::disk('public')->put('flights/thumb', $request->file('thumb'));
        }
        
        $flight->update([
            'name' => $request->name,
            'ticket' => $request->ticket,
            'trip_information' => $request->trip_information,
            'class' => $request->class,
            'price' => $request->price,
            'aircraft_operator' => $request->aircraft_operator,
            'aircraft_logo' => $logo,
            'airplane_type' => $request->airplane_type,
            'seat_type' => $request->seat_type,
            'electric_port' => $request->electric_port,
            'display' => $request->display,
            'thumb' => $image,
            'best_offer' => $request->best_offer,
            'stop' => $request->stop,
            'cancellation_before_departure' => $request->cancellation_before_departure  ,
            'cancellation_before_departure_price' => $request->cancellation_before_departure_price,
            'cancellation_after_departure' => $request->cancellation_after_departure,
            'cancellation_after_departure_price' => $request->cancellation_after_departure_price,
            'absence' => $request->absence,
            'absence_price' => $request->absence_price,
            'change_before_departure' => $request->change_before_departure,
            'change_before_departure_price' => $request->change_before_departure_price,
            'change_after_departure' => $request->change_after_departure,
            'change_after_departure_price' => $request->change_after_departure_price,
            'commission' => $request->commission,
            'is_percent' => $request->is_percent,
        ]);

        return redirect()->back()->with(['success' => 'Flight Updated Successfully.']);
    }

    /**
     * @param Flight $flight
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Flight $flight)
    {
        Storage::disk('public')->delete($flight->aircraft_logo);
        Storage::disk('public')->delete($flight->thumb);

        $flight->delete();

        return redirect()->back()->with(['success' => 'Flight Deleted Successfully.']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function flightOrders(Flight $flight)
    {
        $flights = $flight->orders()->orderBy('id', 'DESC')->get();

        return view('admin.orders.flight.flights', compact('flights'));
    }

    /**
     * @param Flight $flight
     * @param FlightOrders $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeFlightStatus(Flight $flight, FlightOrders $order, Request $request)
    {
        if ($order->status !== 'rejected') {
            $this->validate($request, [
                'pdf' => 'required|mimes:pdf'
            ], [
                'pdf.mimes' => 'Flight document must be a file of type: pdf.'
            ]);

            $pdf = Storage::disk('public')->put('flight/pdf', $request->file('pdf'));

            $order->update(['status' => '1', 'delivered_by' => Auth::user()->id, 'flight_pdf' => $pdf]);

            Notification::send(User::find($order->user_id), new Notifier([
                'message' => 'your flight ticket has been delivered',
                'url' => route('listUserFlights')
            ], 'Flight Ticket Request'));
        } else {
            return redirect()->back()->with(['fail' => 'flight already rejected!']);
        }

        return redirect()->back()->with(['success' => 'flight approved successfully!']);
    }

    /**
     * @param Flight $flight
     * @param FlightOrders $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeFlightStatusToReject(Flight $flight, FlightOrders $order)
    {
        if ($order->status === '0' || $order->status === 'received') {
            $order->update(['status' => 'rejected']);

            Notification::send(User::find($order->user_id), new Notifier([
                'message' => 'your flight ticket request has been rejected',
                'url' => route('listUserFlights')
            ], 'Flight Ticket Request'));
        } else {
            return redirect()->back()->with(['fail' => 'flight already submitted!']);
        }

        return redirect()->back()->with(['success' => 'flight rejected successfully!']);
    }

    /**
     * @param Flight $flight
     * @param FlightOrders $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeFlightStatusToReceive(Flight $flight, FlightOrders $order)
    {
        if ($order->status === '0') {
            $order->update(['status' => 'received']);

            Notification::send(User::find($order->user_id), new Notifier([
                'message' => 'your flight ticket request has been received',
                'url' => route('listUserFlights')
            ], 'Flight Ticket Request'));
        } else {
            return redirect()->back()->with(['fail' => 'flight already submitted!']);
        }

        return redirect()->back()->with(['success' => 'flight canceled successfully!']);
    }

    /**
     * @param Flight $flight
     * @param FlightOrders $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editFlightOrder(Flight $flight, FlightOrders $order)
    {
        return view('admin.orders.flight.edit', compact('flight', 'order'));
    }

    /**
     * @param Flight $flight
     * @param FlightOrders $order
     * @param editFlightOrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editOrder(Flight $flight, FlightOrders $order, editFlightOrderRequest $request)
    {
        $pdf = $order->flight_pdf;
        if ($request->hasFile('pdf')) {
            Storage::disk('public')->delete($flight->flight_pdf);
            $pdf = Storage::disk('public')->put('flight/pdf', $request->file('pdf'));
        }

        $order->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'nationality' => $request->nationality,
            'passport_number' => $request->passport_number,
            'passport_issuance_date' => $request->passport_issuance_date,
            'passport_expire_date' => $request->passport_expire_date,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'flight_pdf' => $pdf,
        ]);

        return redirect()->back()->with(['success' => 'order updated successfully!']);
    }
}

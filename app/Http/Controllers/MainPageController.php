<?php

namespace App\Http\Controllers;
use Notifiable;
use App\Charter;
use App\CharterPrice;
use App\CharterOrders;
use App\CharterPassengers;
use App\Country;
use App\Flight;
use App\FlightOrders;
use App\Http\Requests\CharterPreCheckoutRequest;
use App\Http\Requests\FlightPreCheckoutRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VisaPreCheckoutRequest;
use App\Locked;
use App\Nationality;
use App\Notifications\Notifier;
use App\Page;
use App\Setting;
use App\Travel;
use App\TravelOrders;
use App\TravelPassengers;
use App\User;
use App\Visa;
use App\VisaOrders;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;
use View;
class MainPageController extends Controller {
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
        // return Carbon::now()->format('Y-m-d H:i:s');
        $best_travels = Travel::where( 'best_offer', '1' )->where( 'from_date', '>', Carbon::now() )->take( 5 )->get();
		$best_flights = Flight::where( 'best_offer', '1' )->take( 6 )->get();
		$best_visas   = Visa::where( 'best_offer', '1' )->take( 6 )->get();

		$travels  = Travel::orderBy( 'id', 'DESC' )->take( 6 )->where( 'from_date', '>', Carbon::now() )->get();
		$flights  = Flight::orderBy( 'id', 'DESC' )->take( 6 )->get();
		$visas    = Visa::orderBy( 'id', 'DESC' )->take( 6 )->get();
        $charters11 = Charter::where( "show_in_home", 1 )
        ->where( "locked", 0 )
        //->where( DB::raw("STR_TO_DATE(concat(`flight_date`,' ' ,`departure_time`),'%Y-%m-%d %h:%i %p')"), '>=', Carbon::now()->format('Y-m-d H:i:s') )
        ->where( DB::raw("STR_TO_DATE(concat(`flight_date`,' ' ,`departure_time`),'%Y-%m-%d %H:%i %s')"), '>=', Carbon::now()->format('Y-m-d H:i:s') )
        ->orderBy( 'flight_date', 'ASC' )->get();
      
      //$charters = Charter::where( DB::raw("STR_TO_DATE(concat(`flight_date`,' ' ,`departure_time`),'%Y-%m-%d %h:%i %p')"), '>=', Carbon::now()->format('Y-m-d H:i:s') )
        //->orderBy( 'flight_date', 'ASC' )->where( "locked", 0 )->get();
      
      $charters = Charter::orderBy( 'flight_date', 'ASC' )
                          ->where('show_in_home' , 1)
                          ->where( "locked", 0 )
        //->where( DB::raw("STR_TO_DATE(concat(`flight_date`,' ' ,`departure_time`),'%Y-%m-%d %H:%i %s')"), '>=', Carbon::now()->timezone('Europe/Brussels')->format('H:i:s') )
        ->where( DB::raw("STR_TO_DATE(concat(`flight_date`,' ' ,`departure_time`),'%Y-%m-%d %H:%i %s')"), '>=', Carbon::now()->format('Y-m-d H:i:s') )
                            ->get();

		$url         = '';
		$queryString = Request()->getQueryString();
		if ( $queryString ) {
			$url .= '?' . $queryString;
		}

		$lang = App::getLocale();

		return view( 'web.index', compact( 'best_travels', 'best_flights', 'best_visas', 'travels', 'flights', 'visas', 'url', 'charters', 'lang' ) );
	}

	// Flight Section

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function flights() {
		$flights = Flight::paginate( 9 );

		return view( 'front.flight.flights', compact( 'flights' ) );
	}

	// Charter Section

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function charter() {


		$oneWayFlights = Charter::where( 'flight_type', 'OneWay' )
        //->where( DB::raw("STR_TO_DATE(concat(`flight_date`,' ' ,`departure_time`),'%Y-%m-%d %h:%i %p')"), '>=', Carbon::now()->format('Y-m-d H:i:s') )
         // ->where( DB::raw("STR_TO_DATE(concat(`flight_date`,' ' ,`departure_time`),'%Y-%m-%d %H:%i %s')"), '>=', Carbon::now()->timezone('Europe/Brussels')->format('H:i:s') )
          ->where( DB::raw("STR_TO_DATE(concat(`flight_date`,' ' ,`departure_time`),'%Y-%m-%d %H:%i %s')"), '>=', Carbon::now()->format('Y-m-d H:i:s') )
            ->where('locked', 0)
            ->orderBy( 'flight_date', 'ASC' )
            ->get();
        $oneWayFlights = $oneWayFlights->filter(function ($item) {
            $totalSeats = $item->economy_seats + $item->business_seats;

            $soldSeats = 0;
            $economy_orders              = $item->orders()->where( 'status', '!=', 'cancelled' )
                ->where( 'flight_class', 'Economy' )
                ->orWhere( 'flight_class', 'Business' )
                ->get();
            foreach ( $economy_orders as $economy_order ) {
                $soldSeats += $economy_order->passengers()->count();
            }
//            dd($totalSeats , $soldSeats);
            return $totalSeats >= $soldSeats;
        })->values();


		$twoWayFlights = Charter::where( 'flight_type', 'RoundTrip' )
        ->where( DB::raw("STR_TO_DATE(concat(`flight_date`,' ' ,`departure_time`),'%Y-%m-%d %h:%i %p')"), '>=', Carbon::now()->format('Y-m-d H:i:s') )
            ->where('locked', 0)
            ->orderBy( 'flight_date', 'ASC' )
            ->get();


//		print_r($oneWayFlights);
//		die();

		return view( 'front.charter.flights', compact( 'oneWayFlights', 'twoWayFlights' ) );
	}

	public function charterCreate(Request $request) {
		$countries = Country::all();
		$setting   = Setting::first();

		$data = new \stdClass();
		$data = json_decode( session( 'recentSearch' ) );
		
		if($request->has('flight_type')){
		    $data = new \stdClass();
		    $data->flight_type=$request->get('flight_type');
		    $data->from=$request->get('from');
    		$data->to=$request->get('to');
    		$data->going=$request->get('going');
    		$data->flight_class=$request->get('flight_class');
    		$data->adults=$request->get('adults');
    		$data->children=$request->get('children');
    		$data->babies=$request->get('babies');
		}
        //return $data->from;
		return view( 'front.charter.createCharter', compact( 'countries', 'setting', 'data' ) );
	}//end charterCreate

	public function charterCreateSearch( Request $request ) {
		$countries = Country::all();
		$setting   = Setting::first();

		$fromCountry = Country::find( $request->get( "from" ) );
		$toCountry   = Country::find( $request->get( "to" ) );

		$fromDate = $this->parseDate( $request->get( "going" ) )->format( "D d, M" );
		$toDate   = $this->parseDate( $request->get( "coming" ) )->format( "D d, M" );

		$nextFromDate = $this->parseDate( $request->get( "going" ) )->addDays( 1 )->format( "d/m/Y" );
		$prevFromDate = $this->parseDate( $request->get( "going" ) )->subDays( 1 )->format( "d/m/Y" );

		session( [ 'recentSearch' => json_encode( $request->all() ) ] );

		return view( 'front.charter.flights_search', compact( 'countries', 'setting', 'fromCountry', 'toCountry', 'fromDate', 'toDate', 'nextFromDate', 'prevFromDate' ) );
	}//end charterCreateSearch
  

	public function charterAjaxSearch( Request $request ) {
     // dd($request->search_type);
		$flightType   = $request->get( "flight_type" );
//		$flightClass  = $request->get( "flight_class" );
		$flightClass  = ["Economy","Business"];
		$openDuration = $request->get( "coming_duration" );

		$isRound = $flightType == "RoundTrip";
		$isOpen  = $flightType == "OpenReturn";

		$direction = $request->get( "direction" );

		$flights      = [];
		$roundFlights = [];

		$from = $request->get( "from" );
		$to   = $request->get( "to" );

		$going  = $this->parseDate( $request->get( "going" ) );
		$coming = $this->parseDate( $request->get( "coming" ) );

		// Departure
		$departureQuery = Charter::with( [
			"roundtrip",
			"aircraft",
			"prices" => function ( $q ) use ( $flightClass ) {
				$q->whereIn( "flight_class", $flightClass );
//				$q->groupBy( "flight_class" );
			}
		] );
		$departureQuery->where( "from_where", $from )->where( "to_where", $to );
        $departureQuery->whereDate( "flight_date", $going->toDateString() );
        $departureQuery->where( "locked", 0 );
		$departureQuery->orderBy( "flight_type", "ASC" );

		foreach ( $departureQuery->get() as $flight ) {
			$flights[] = $flight;
		}

		// Arrival
		if ( $isRound ) {
			$arrivalQuery = Charter::with( [
				"roundtrip",
				"prices" => function ( $q ) use ( $flightClass ) {
                    $q->whereIn( "flight_class", $flightClass );
                    // $q->groupBy( "flight_class" );
				},
				"aircraft"
			] );
			$arrivalQuery->where( "from_where", $to )->where( "to_where", $from );
            $arrivalQuery->whereDate( "flight_date", $coming->toDateString() );
            $arrivalQuery->where( "locked", 0 );
			$arrivalQuery->orderBy( "flight_type", "ASC" );

			foreach ( $arrivalQuery->get() as $flight ) {
				$roundFlights[] = $flight;
			}
		}

		return response()->json( [
			"departureFlights" => $flights,
			"returnFlights"    => $roundFlights,
		] );
	}

	private function parseDate( $date ) {
		return Carbon::parse( str_replace( "/", "-", $date ) );
	}

	public function charterSearch() {
		return view( 'front.charter.searchCharter' );
	}//end charterCreate

	public function getSearchresult( Request $request ) {
		$user_id = Auth::user()->id;

		$rows = CharterOrders::where( "user_id", $user_id );

		if ( $request->ticket_num ) {
			$rows->where( 'ticket_number', 'LIKE', "%$request->ticket_num%" );
		}
		if ( $request->pnr ) {
			$rows->where( 'pnr', 'LIKE', "%$request->pnr%" );
		}

		if ( $request->first_name or $request->last_name ) {
			$rows = CharterPassengers::whereHas( 'order', function ( $q ) use ( $user_id ) {
				$q->where( 'user_id', $user_id );
			} );
		}

		if ( $request->first_name ) {
			$rows->where( 'first_name', 'LIKE', "%$request->first_name%" );
		}
		if ( $request->last_name ) {
			$rows->where( 'last_name', 'LIKE', "%$request->last_name%" );
		}
		if ( $request->from_date ) {
			$rows->whereDate( 'created_at', '>=', $request->from_date );
		}
		if ( $request->to_date ) {
			$rows->whereDate( 'created_at', '<=', $request->to_date );
		}

		$rows = $rows->get();

//dd($rows);
		return view( 'front.charter.searchCharter', compact( 'rows' ) );
	}//end getSearchresult

	public function reservedSeats() {
		$flights = Auth::user()->lockedCharter;

		return view( 'front.charter.reserved', compact( 'flights' ) );
	}
	
	public function checkRound(Request $request) {
	    $charters=$request->flights;
	    
	    $chartersInfo1=Locked::find($charters[0])->charter;
	    $chartersInfo2=Locked::find($charters[1])->charter;
	    $isRoundTrip=false;
	    if( ($chartersInfo1->from->code == $chartersInfo2->to->code) && ($chartersInfo2->to->code == $chartersInfo1->from->code) ){
            $isRoundTrip=true;
        }
		return response()->json($isRoundTrip);

		
	}

	public function charterLockedForm( Request $request ) {
		$flights = $request->get( 'flights' );
        $lockIds=$flights;
        $lockIds[1]=0;
		$locked  = Locked::find( $flights[0] );
		$charter = $locked->charter->id;
        // return response()->json(Charter::find($charter)->prices[0]->id);
        $priceId1=Charter::find($charter)->prices[0]->id;
        $priceId2=0;
		$seats = $locked->seats;

		$round = null;
		if ( count( $flights ) == 2 ) {
		    $lockIds[1]=$flights[1];
			$lockedRound = Locked::find( $flights[1] );
			$round       = $lockedRound->charter->id;
            $priceId2=Charter::find($round)->prices[0]->id;
			if ( $lockedRound->seats < $seats ) {
				$seats = $lockedRound->seats;
			}
		}

		return view( 'front.charter.locked_form', compact( 'round', 'charter', 'seats','priceId1','priceId2','lockIds' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function singleFlight( Flight $flight ) {
		$latest_flights = Flight::where( 'id', '!=', $flight->id )->orderBy( 'id', 'DESC' )->take( 4 )->get();

		return view( 'front.flight.singleFlight', compact( 'flight', 'latest_flights' ) );
	}

	// Travel Section

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function travels() {
		$travels = Travel::where( 'from_date', '>', Carbon::now() )->paginate( 9 );

		return view( 'front.travel.travels', compact( 'travels' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function singleTravel( Travel $travel ) {
		$latest_travels = Travel::where( 'id', '!=', $travel->id )->orderBy( 'id', 'DESC' )->take( 4 )->get();

		return view( 'front.travel.singleTravel', compact( 'travel', 'latest_travels' ) );
	}

	// Visa Section

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function visas() {
		$visas = Visa::where('locked',0)->paginate( 9 );

		return view( 'front.visa.visa', compact( 'visas' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function singleVisa( Visa $visa ) {
		if ( session( 'visa-checkout-form-passport-images' ) ) {
			foreach ( json_decode( session( 'visa-checkout-form-passport-images' ) ) as $key => $image ) {
				Storage::disk( 'public' )->delete( $image );
			}
		}
		if ( session( 'visa-checkout-form-personal-images' ) ) {
			foreach ( json_decode( session( 'visa-checkout-form-personal-images' ) ) as $key => $image ) {
				Storage::disk( 'public' )->delete( $image );
			}
		}
		$latest_visas = Visa::where( 'id', '!=', $visa->id )->orderBy( 'id', 'DESC' )->take( 4 )->get();

		return view( 'front.visa.singleVisa', compact( 'visa', 'latest_visas' ) );
	}

	// Authentication Section

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function loginPage() {

		$latest_flights = Flight::orderBy( 'id', 'DESC' )->take( 4 )->get();

		return view( 'front.login', compact( 'latest_flights' ) );
	}

	function checklogin( Request $request ) {
		$this->validate( $request, [
			'email'    => 'required|email',
			'password' => 'required'
		] );

		$user_data = array(
			'email'    => $request->get( 'email' ),
			'password' => $request->get( 'password' )
		);
		$activationMessage = App::getLocale() === 'ar' ? 'يجب تفعيل الحساب من قبل المشرف العام للموقع وسيتم اشعارك عند التفعيل.' : 'Account will be approved by website admin and we will notify you when account activated';
		$userEmail=User::where( 'email', $request->email );
		if ($userEmail->exists()) {
			if ( $userEmail->first()->activation !== '1' ) {
				return redirect()->back()->with( [ 'fail' => $activationMessage ] );
			}	
		}
		
		if ( Auth::attempt( $user_data ) ) {
			return redirect()->route('front-home');
		} else {
			return back()->with( 'fail', 'Wrong Login Details' );
		}

	}// end check login

	public function forgetPassword() {
		return view( 'front.forget' );
	}

	public function resetPassword( Request $request ) {
		if ( $request->has( [ "email", "password", "verification" ] ) ) {
			// TODO: reset password

			session()->flush();
			$request->session()->flash( 'success', __( "alnkel.reset_password_done" ) );

			return redirect( route( "front-login" ) );
		}

		if ( $request->has( "email" ) ) {
			session()->put( "email", $request->email );
			$request->session()->flash( 'success', __( "alnkel.reset_password_email" ) );

			return redirect()->back();
		}

		return redirect()->back();
	}

	/**
	 * @param LoginRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function login( LoginRequest $request ) {
		$message = App::getLocale() === 'ar' ? 'كلمة المرور والبريد الالكنروني غير صحيح' : 'Invalid email or password';
		if ( User::where( 'email', $request->email )->first()->hasRole( 'Super Admin' ) ) {
			return redirect()->back()->with( [ 'fail' => $message ] );
		}

		$activationMessage = App::getLocale() === 'ar' ? 'يجب تفعيل الحساب من قبل المشرف العام للموقع وسيتم اشعارك عند التفعيل.' : 'Account will be approved by website admin and we will notify you when account activated';
		if ( User::where( 'email', $request->email )->first()->activation !== '1' ) {
			return redirect()->back()->with( [ 'fail' => $activationMessage ] );
		}

		if ( Auth::attempt( $request->only( [ 'email', 'password' ] ) ) ) {
			return redirect()->route( 'front-home' );
		}

		return redirect()->back()->with( [ 'fail' => $message ] );
	}

	/**
	 * @param RegisterRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function register( RegisterRequest $request ) {
        
       
       $request->validate([
      'register_email' => ['required|email|unique:users'],
      'password' => ['required'],
        ]);

        
		User::create( [
			'name'     => $request->name,
			'email'    => $request->register_email,
			'company'  => $request->company,
			'address'  => $request->address,
			'phone'    => $request->phone,
			'password' => bcrypt( $request->register_password ),
			'type'     => 'User'
		] );
     

		$users = User::where( 'type', 'Super Admin' )->get();
		Notification::send( $users, new Notifier( [
			'message' => 'new user has been registered please active his account',
			'url'     => route( 'listUsers' )
		], 'New User Registered' ) );

		$activationMessage = App::getLocale() === 'ar' ? 'يجب تفعيل الحساب من قبل المشرف العام للموقع وسيتم اشعارك عند التفعيل.' : 'Account will be approved by website admin and we will notify you when account activated';

		return redirect()->back()->with( [ 'register-success' => $activationMessage ] );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logout() {

		Auth::logout();

		return redirect()->to('/');
	}





	// Travel Purchase Section

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function travelPreCheckoutPage( Travel $travel, Request $request ) {
		if ( session( 'travel-checkout-form-passport-images' ) ) {
			foreach ( json_decode( session( 'travel-checkout-form-passport-images' ) ) as $key => $image ) {
				Storage::disk( 'public' )->delete( $image );
			}
		}
		if ( session( 'travel-checkout-form-personal-images' ) ) {
			foreach ( json_decode( session( 'travel-checkout-form-personal-images' ) ) as $key => $image ) {
				Storage::disk( 'public' )->delete( $image );
			}
		}

		$latest_travels = Travel::where( 'id', '!=', $travel->id )->orderBy( 'id', 'DESC' )->take( 4 )->get();

		$travelers = [];
		if ( $request->get( "adult" ) > 0 ) {
			for ( $i = 0; $i < $request->get( "adult" ); $i ++ ) {
				$travelers[] = [ $i, "adult" ];
			}
		}

		if ( $request->get( "children" ) > 0 ) {
			for ( $i = 0; $i < $request->get( "children" ); $i ++ ) {
				$travelers[] = [ $i, "children" ];
			}
		}

		if ( $request->get( "baby" ) > 0 ) {
			for ( $i = 0; $i < $request->get( "baby" ); $i ++ ) {
				$travelers[] = [ $i, "baby" ];
			}
		}

		$nationalities = Nationality::all();

		return view( 'front.travel.travelPreCheckout', compact( 'travel', 'travelers', 'nationalities', 'latest_travels' ) );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function travelPreCheckout( Travel $travel, Request $request ) {
		session( [ 'travel-checkout-form' => json_encode( $request->all() ) ] );
		$passport_images = [];
		$personal_images = [];
		foreach ( $request->first_name as $key => $traveler ) {
			if ( $request->passport_image[ $key ] and $request->personal_image[ $key ] ) {
				$passport_images[ $key ] = Storage::disk( 'public' )->put( 'travels/reserve/passport', $request->passport_image[ $key ] );
				$personal_images[ $key ] = Storage::disk( 'public' )->put( 'travels/reserve/personal', $request->personal_image[ $key ] );
			}
		}

		session( [ 'travel-checkout-form-passport-images' => json_encode( $passport_images ) ] );
		session( [ 'travel-checkout-form-personal-images' => json_encode( $personal_images ) ] );

		return redirect()->route( 'travel-checkout', [ 'travel' => $travel->id ] );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function travelCheckoutPage( Travel $travel ) {
		if ( ! Auth::check() ) {
			return redirect()->route( 'travel-pre-checkout', [ 'travel' => $travel->id ] );
		}

		if ( session()->get( 'travel-checkout-form' ) === null ) {
			return redirect()->route( 'travel-pre-checkout', [ 'travel' => $travel->id ] );
		}

		$travelers = json_decode( session( 'travel-checkout-form' ) );

		$day = $travelers->day;

		$priceDay = $travel->price[ $day ];


		$adultPrice    = $priceDay['adult'];
		$childrenPrice = $priceDay['children'];
		$babyPrice     = $priceDay['baby'];

		$price = ( $adultPrice * $travelers->adult ) + ( $childrenPrice * $travelers->children ) + ( $babyPrice * $travelers->baby );

		$travelersCount = count( $travelers->first_name );

		$commission = 0;
		if ( $travel->commission > 0 ) {
			$commission = $travel->commission;
			if ( $travelersCount > 0 ) {
				$commission *= $travelersCount;
			}

			if ( $travel->is_percent ) {
				$commission = ( $price * $travel->commission ) / 100;
			}
		}

		$price -= $commission;

		return view( 'front.travel.travelCheckout', compact( 'flight', 'price', 'travelersCount', 'travel' ) );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function travelCheckout( Travel $travel ) {
		if ( ! session()->has( 'travel-checkout-form' ) && ! Auth::check() ) {
			return redirect()->route( 'travel-pre-checkout', [ 'travel' => $travel->id ] );
		}

		$request         = json_decode( session( 'travel-checkout-form' ) );
		$passport_images = json_decode( session( 'travel-checkout-form-passport-images' ) );
		$personal_images = json_decode( session( 'travel-checkout-form-personal-images' ) );

		$travelers = json_decode( session( 'travel-checkout-form' ) );

		$day = $travelers->day;

		$priceDay = $travel->price[ $day ];


		$adultPrice    = $priceDay['adult'];
		$childrenPrice = $priceDay['children'];
		$babyPrice     = $priceDay['baby'];

		$price = ( $adultPrice * $travelers->adult ) + ( $childrenPrice * $travelers->children ) + ( $babyPrice * $travelers->baby );

		$travelersCount = count( $travelers->first_name );

		$commission = 0;
		if ( $travel->commission > 0 ) {
			$commission = $travel->commission;
			if ( $travelersCount > 0 ) {
				$commission *= $travelersCount;
			}

			if ( $travel->is_percent ) {
				$commission = ( $price * $travel->commission ) / 100;
			}
		}

		$price -= $commission;

		if ( $price > Auth::user()->balance ) {
			return redirect()->back()->with( [ 'fail' => 'رصيدك الحالي لا يكفي اتمام هذه العملية.' ] );
		}

		$travelers = [];
		if ( $request->adult > 0 ) {
			for ( $i = 0; $i < $request->adult; $i ++ ) {
				$travelers[] = [ $i, "adult" ];
			}
		}

		if ( $request->children > 0 ) {
			for ( $i = 0; $i < $request->children; $i ++ ) {
				$travelers[] = [ $i, "children" ];
			}
		}

		if ( $request->baby > 0 ) {
			for ( $i = 0; $i < $request->baby; $i ++ ) {
				$travelers[] = [ $i, "baby" ];
			}
		}

		// Generate PNR
		$pnr     = '';
		$randPos = rand( 1, 4 );
		for ( $i = 0; $i < 6; $i ++ ) {
			if ( $i == $randPos ) {
				$pnr .= strtoupper( Str::random( 1 ) );
			} else {
				$pnr .= rand( 1, 9 );
			}
		}
		//===============

		$orderObject = $travel->orders()->create( [
			'user_id' => Auth::user()->id,
			'price'   => $price,
			'type'    => $day,
			'pnr'     => $pnr,
		] );

		$order = $orderObject->id;

		$key        = 0;
		$seats      = 0;
		$ticket     = rand( 111111, 999999 );
		$ticketBack = rand( 111111, 999999 );
		foreach ( $travelers as $traveler ) {

			$passengerPrice = $travel->price[ $day ][ $traveler[1] ];
			$passengerData  = [
				'order_id'             => $order,
				'first_name'           => $request->first_name[ $key ],
				'title'                => isset( $request->title[ $key ] ) ? $request->title[ $key ] : "INF",
				'last_name'            => $request->last_name[ $key ],
				'birth_date'           => Carbon::parse( str_replace( '/', '-', $request->birth_date[ $key ] ) )->format( 'Y-m-d' ),
				'nationality'          => $request->nationality[ $key ],
				'passport_number'      => $request->passport_number[ $key ],
				'passport_expire_date' => Carbon::parse( str_replace( '/', '-', $request->passport_expire_date[ $key ] ) )->format( 'Y-m-d' ),
				'price'                => $passengerPrice,
				'ticket_number'        => $ticket + $key,
				'ticket_back'          => $ticketBack + $key,
				'passport_image'       => isset( $passport_images[ $key ] ) ? $passport_images[ $key ] : '',
				'personal_image'       => isset( $personal_images[ $key ] ) ? $personal_images[ $key ] : '',
			];

			TravelPassengers::create( $passengerData );

			$key ++;

			if ( $traveler[1] != "baby" ) {
				$seats ++;
			}
		}

		$reserved_seats = $travel->price[ $day ]['reserved_seats'];

		$priceData = [];
		$index     = 0;
		foreach ( $travel->price as $pr ) {
			$modifiedPrice = $pr;
			if ( $day == $index ) {
				$modifiedPrice["reserved_seats"] = $reserved_seats + $seats;
			}

			$priceData[] = $modifiedPrice;
			$index ++;
		}

		$travel->update( [
			"price" => $priceData
		] );

		// Save to transactions
		$new_balance = Auth::user()->balance - $price;
		Auth::user()->userTransactions()->create( [
			'to'             => Auth::user()->id,
			'amount'         => $price,
			'comment'        => "Travel order",
			'type'           => "withdrawal",
			'creditBefore'   => Auth::user()->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $travel->id,
			'connectedTable' => 'travel'
		] );

		//================== START Commission
		$item = $travel;
		if ( $item->commission > 0 ) {
			$commissionObject = getCommission( $item );
			$commission       = $commissionObject->commission;

			if ( count( $request->first_name ) > 0 ) {
				$commission *= count( $request->first_name );
			}

			if ( $commissionObject->is_percent ) {
				$commission = ( $price * $commissionObject->commission ) / 100;
			}

			Auth::user()->userTransactions()->create( [
				'to'             => Auth::user()->id,
				'amount'         => $commission,
				'type'           => "DepositOfCredit",
				'comment'        => "Travel commission",
				'creditBefore'   => $new_balance,
				'creditAfter'    => $new_balance + $commission,
				'connectedID'    => $travel->id,
				'connectedTable' => 'travel'
			] );

			$new_balance = $new_balance + $commission;
		}
		//================== END Commission

		Auth::user()->update( [ 'balance' => $new_balance ] );

		session()->forget( 'travel-checkout-form' );
		session()->forget( 'travel-checkout-form-passport-images' );
		session()->forget( 'travel-checkout-form-personal-images' );

		$users = User::where( 'type', 'Super Admin' )->get();
		Notification::send( $users, new Notifier( [
			'message' => 'new travel order by (' . Auth::user()->name . ')',
			'url'     => route( 'travelOrders', [ 'travel' => $travel->id ] )
		], 'New Travel Order' ) );

		$message = App::getLocale() === 'ar' ? 'لقد تمت العملية بنجاح.' : 'ticket request was sent successfully!';

		return redirect()->route( 'travel-pre-checkout', [ 'travel' => $travel->id ] )->with( [
			'success' => $message,
			'order'   => $order,
			"pnr"     => $pnr
		] );
	}

	public function travelTicket( Request $request ) {
		$order = TravelOrders::where( "pnr", $request->pnr )->first();

		return view( 'front.travel.ticket', compact( 'order' ) );
	}

	public function downloadTravelTicker( Request $request ) {
		$order = TravelOrders::where( "pnr", $request->pnr )->first();

		$pdf = PDF::loadView( 'front.travel.ticket', compact( 'order' ) );

		return $pdf->download( 'Ticket.pdf' );
	}

	// Flight Purchase Section

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function flightPreCheckoutPage( Flight $flight ) {
		if ( session( 'flight-checkout-form-passport-images' ) ) {
			foreach ( json_decode( session( 'flight-checkout-form-passport-images' ) ) as $key => $image ) {
				Storage::disk( 'public' )->delete( $image );
			}
		}
		if ( session( 'flight-checkout-form-personal-images' ) ) {
			foreach ( json_decode( session( 'flight-checkout-form-personal-images' ) ) as $key => $image ) {
				Storage::disk( 'public' )->delete( $image );
			}
		}
		$latest_flights = Flight::where( 'id', '!=', $flight->id )->orderBy( 'id', 'DESC' )->take( 4 )->get();

		return view( 'front.flight.flightPreCheckout', compact( 'flight', 'latest_flights' ) );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function flightPreCheckout( Flight $flight, FlightPreCheckoutRequest $request ) {
		session()->put( 'flight-checkout-form', json_encode( $request->all() ) );
		$passport_images = [];
		$personal_images = [];
		foreach ( $request->first_name as $key => $traveler ) {
			$passport_images[ $key ] = Storage::disk( 'public' )->put( 'flights/reserve/passport', $request->passport_image[ $key ] );
			$personal_images[ $key ] = Storage::disk( 'public' )->put( 'flights/reserve/personal', $request->personal_image[ $key ] );
		}

		session( [ 'flight-checkout-form-passport-images' => json_encode( $passport_images ) ] );
		session( [ 'flight-checkout-form-personal-images' => json_encode( $personal_images ) ] );

		return redirect()->route( 'flight-checkout', [ 'flight' => $flight->id ] );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function flightCheckoutPage( Flight $flight ) {
		if ( ! Auth::check() ) {
			return redirect()->route( 'flight-pre-checkout', [ 'flight' => $flight->id ] );
		}

		if ( session()->get( 'flight-checkout-form' ) === null ) {
			return redirect()->route( 'flight-pre-checkout', [ 'flight' => $flight->id ] );
		}

		$travelers = json_decode( session( 'flight-checkout-form' ) );
		$ages      = array_count_values( $travelers->age );

		$adult    = array_has( $ages, 'adult' ) ? ( (int) $ages['adult'] * (int) $flight->price['adult'] ) : 0;
		$children = array_has( $ages, 'children' ) ? (int) $ages['children'] * (int) $flight->price['children'] : 0;
		$baby     = array_has( $ages, 'baby' ) ? (int) $ages['baby'] * (int) $flight->price['baby'] : 0;
		$price    = $adult + $children + $baby;

		$travelers      = count( $travelers->first_name );
		$latest_flights = Flight::where( 'id', '!=', $flight->id )->orderBy( 'id', 'DESC' )->take( 4 )->get();

		return view( 'front.flight.flightCheckout', compact( 'flight', 'latest_flights', 'price', 'travelers' ) );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function flightCheckout( Flight $flight ) {
		if ( ! session()->has( 'flight-checkout-form' ) && ! Auth::check() ) {
			return redirect()->route( 'flight-pre-checkout', [ 'flight' => $flight->id ] );
		}

		$request         = json_decode( session( 'flight-checkout-form' ) );
		$passport_images = json_decode( session( 'flight-checkout-form-passport-images' ) );
		$personal_images = json_decode( session( 'flight-checkout-form-personal-images' ) );

		$ages = array_count_values( $request->age );

		$adult    = array_has( $ages, 'adult' ) ? ( (int) $ages['adult'] * (int) $flight->price['adult'] ) : 0;
		$children = array_has( $ages, 'children' ) ? (int) $ages['children'] * (int) $flight->price['children'] : 0;
		$baby     = array_has( $ages, 'baby' ) ? (int) $ages['baby'] * (int) $flight->price['baby'] : 0;
		$price    = $adult + $children + $baby;

		if ( $price > Auth::user()->balance ) {
			return redirect()->back()->with( [ 'fail' => 'رصيدك الحالي لا يكفي اتمام هذه العملية.' ] );
		}

		foreach ( $request->first_name as $key => $traveler ) {
			$flight->orders()->create( [
				'user_id'                => Auth::user()->id,
				'first_name'             => $request->first_name[ $key ],
				'last_name'              => $request->last_name[ $key ],
				'birth_place'            => $request->birth_place[ $key ],
				'birth_date'             => Carbon::parse( str_replace( '/', '-', $request->birth_date[ $key ] ) )->format( 'Y-m-d' ),
				'nationality'            => $request->nationality[ $key ],
				'passport_number'        => $request->passport_number[ $key ],
				'passport_issuance_date' => Carbon::parse( str_replace( '/', '-', $request->passport_issuance_date[ $key ] ) )->format( 'Y-m-d' ),
				'passport_expire_date'   => Carbon::parse( str_replace( '/', '-', $request->passport_expire_date[ $key ] ) )->format( 'Y-m-d' ),
				'father_name'            => $request->father_name[ $key ],
				'mother_name'            => $request->mother_name[ $key ],
				'price'                  => $flight->price[ $request->age[ $key ] ],
				'passport_image'         => $passport_images[ $key ],
				'personal_image'         => $personal_images[ $key ],
			] );
		}

		// Save to transactions
		$new_balance = Auth::user()->balance - $price;
		Auth::user()->userTransactions()->create( [
			'to'             => Auth::user()->id,
			'amount'         => $price,
			'comment'        => "Flight order",
			'type'           => "withdrawal",
			'creditBefore'   => Auth::user()->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $flight->id,
			'connectedTable' => 'flight'
		] );

		//================== START Commission
		$item = $flight;
		if ( $item->commission > 0 ) {
			$commissionObject = getCommission( $item );
			$commission       = $commissionObject->commission;
			if ( count( $request->first_name ) > 0 ) {
				$commission *= count( $request->first_name );
			}

			if ( $commissionObject->is_percent ) {
				$commission = ( $price * $commissionObject->commission ) / 100;
			}

			Auth::user()->userTransactions()->create( [
				'to'             => Auth::user()->id,
				'amount'         => $commission,
				'type'           => "DepositOfCredit",
				'comment'        => "Flight commission",
				'creditBefore'   => $new_balance,
				'creditAfter'    => $new_balance + $commission,
				'connectedID'    => $flight->id,
				'connectedTable' => 'flight'
			] );

			$new_balance = $new_balance + $commission;
		}
		//================== END Commission

		Auth::user()->update( [ 'balance' => $new_balance ] );

		session()->forget( 'flight-checkout-form' );
		session()->forget( 'flight-checkout-form-passport-images' );
		session()->forget( 'flight-checkout-form-personal-images' );

		$users = User::where( 'type', 'Super Admin' )->get();
		Notification::send( $users, new Notifier( [
			'message' => 'new flight order by (' . Auth::user()->name . ')',
			'url'     => route( 'flightOrders', [ 'flight' => $flight->id ] )
		], 'New Flight Order' ) );

		$message = App::getLocale() === 'ar' ? 'لقد تمت العملية بنجاح.' : 'ticket request was sent successfully!';

		return redirect()->route( 'flight-pre-checkout', [ 'flight' => $flight->id ] )->with( [ 'success' => $message ] );
	}


	// Charter Purchase Section


	public function charterCheckout( Request $request ) {
		$settings      = Setting::first();
		$nationalities = Nationality::all();

		$flight_type = $request->flight_type;

		$charter = Charter::find( $request->departure_charter );

		$flights[] = $charter;

		$locking = false;
		if ( $request->get( "search_type" ) == "locked" ) {
			$locking = true;
		}

		$travelers             = [];
		$travelers['Adults']   = $request->get( "reserve_adults" );
		$travelers['Children'] = $request->get( "reserve_children" );
		$travelers['Babies']   = $request->get( "reserve_babies" );

		$isEconomy = $request->flight_class == "Economy";
		$isOpen    = $request->flight_type == "OpenReturn";

		$departure_pricing = $request->get( "departure_pricing" );

		if ( $isOpen ) {
			$flight_type = "OneWay";
		}

        
		$passengerPrices = [
			"adults"   => getPrice( $departure_pricing, "adult", $flight_type ),
			"children" => getPrice( $departure_pricing, "child", $flight_type ),
			"babies"   => getPrice( $departure_pricing, "inf", $flight_type ),
		];

      $locking11 = false;
        if($locking){
         //$passengerPrices['adults']=Locked::find($request->departure_lockId)['seat_price'];
             if( isset($request->departure_lockId)){
           $passengerPrices['adults']=Locked::find($request->departure_lockId)->seat_price;
             }
          $locking11 = true ;
         
        }

		$prices = [
			"adults"   => $travelers['Adults'] * $passengerPrices['adults'],
			"children" => $travelers['Children'] * $passengerPrices['children'],
			"babies"   => $travelers['Babies'] * $passengerPrices['babies'],
		];

		$duration            = '';
		$coming_duration     = '';
		$departurePrices     = [];
		$openPassengerPrices = [];
		$openPrices          = [];

		if ( $isOpen ) {
			$flight_type     = "OpenReturn";
			$coming_duration = $request->get( "coming_duration" );

			$openPassengerPrices = [
				"adults"   => getPrice( $departure_pricing, "adult", $flight_type, $coming_duration ),
				"children" => getPrice( $departure_pricing, "child", $flight_type, $coming_duration ),
				"babies"   => getPrice( $departure_pricing, "inf", $flight_type, $coming_duration ),
			];

			$openPrices = [
				"adults"   => $travelers['Adults'] * $openPassengerPrices['adults'],
				"children" => $travelers['Children'] * $openPassengerPrices['children'],
				"babies"   => $travelers['Babies'] * $openPassengerPrices['babies'],
			];

			$departurePrices = $prices;

			$prices['adults']   += $openPrices['adults'];
			$prices['children'] += $openPrices['children'];
			$prices['babies']   += $openPrices['babies'];

			$duration = 'Open Return ';
			$duration .= $coming_duration == 1 ? "One Month" : '';
			$duration .= $coming_duration == 3 ? "Three Months" : '';
			$duration .= $coming_duration == 6 ? "Six Months" : '';
			$duration .= $coming_duration == 12 ? "One Year" : '';
		}

        //		dd($openPassengerPrices);

		$total   = $prices['adults'] + $prices['children'] + $prices['babies'];
		$balance = Auth()->user()->balance;

		
        
        // $commission = calculateCommission( $charter, $total )-( ($travelers['Adults']+$travelers['Children'] )*100) ;
      //$commission =  ( ($travelers['Adults']+$travelers['Children']) /100 )  * calculateCommission( $charter, $total );
     //  $commission =   calculateCommission( $charter, $total ) * ( ($travelers['Adults']+$travelers['Children']) /100 );
      if($charter->is_percent == 0 ){
       // $commission =   $total * $charter->commission ;
         // $commission =  $total - $charter->commission ;
         $commission =   ($travelers['Adults']+$travelers['Children']) *  $charter->commission;
      }else{
        $commission =   $total * ($charter->commission /100 );
      }
       
      
		$canPlaceOrder = $balance > $total;

		$return_charter_id          = $request->get( "return_charter" );
		$hasRoundTrip         = intval($return_charter_id) > 0;
		$roundTrip            = Charter::find( $return_charter_id );
		$roundPrices          = [];
		$roundPassengerPrices = [];
		$roundTotal           = 0;
		$roundCommission      = 0;

		if ( $hasRoundTrip ) {
			$flights[] = $roundTrip;

			$return_pricing = $request->get("return_pricing");
        
			

			$roundPassengerPrices = [
				"adults"   => getPrice($return_pricing, "adult", $flight_type),
				"children" => getPrice($return_pricing, "child", $flight_type),
				"babies"   => getPrice($return_pricing, "inf", $flight_type),
			];

            $roundPrices = [
				"adults"   => $travelers['Adults'] * $roundPassengerPrices['adults'],
				"children" => $travelers['Children'] * $roundPassengerPrices['children'],
				"babies"   => $travelers['Babies'] * $roundPassengerPrices['babies'],
			];
			$departurePrices = $prices;

			$prices['adults']   += $roundPrices['adults'];
			$prices['children'] += $roundPrices['children'];
			$prices['babies']   += $roundPrices['babies'];

			$roundTotal      = $roundPrices['adults'] + $roundPrices['children'] + $roundPrices['babies'];
			// $roundCommission = calculateCommission( $roundTrip, $total );
          
            if($charter->is_percent == 0 ){
              $roundCommission =   $total * ($charter->commission );
            }else{
              $roundCommission =   $total * ($charter->commission /100 );
            }
          

			$total      = $prices['adults'] + $prices['children'] + $prices['babies'];
			$commission += $roundCommission;

			$canPlaceOrder = $balance > $total;
		}

		$isLocked = $request->has( 'locked' );

		session( [
			'checkoutValues' => json_encode( [
				'total'                => $total,
				'roundTotal'           => $roundTotal,
				'commission'           => $commission,
				'passengerPrices'      => $passengerPrices,
				'openPassengerPrices'  => $openPassengerPrices,
				'prices'               => $prices,
				'openPrices'           => $openPrices,
				'roundPassengerPrices' => $roundPassengerPrices,
				'flights'              => $flights,
				'flight_type'          => $hasRoundTrip ? 'RoundTrip' : $request->flight_type,
				'open_duration'        => $coming_duration,
				'isLocked'             => $isLocked,
			] )
		] );
      

		return view( 'front.charter.checkout', compact( 'settings', 'nationalities', 'charter', 'travelers', 'request', 'isEconomy', 'prices', 'total', 'balance', 'canPlaceOrder', 'hasRoundTrip', 'roundTrip', 'roundPrices', 'roundTotal', 'roundCommission', 'commission', 'departurePrices', 'isOpen', 'duration', 'passengerPrices', 'openPrices', 'openPassengerPrices', 'isLocked', 'locking' , 'locking11' ) );
	}

	
  	
 public function completeCharterOrder( Request $request ) {
        // return response()->json($request->fields);
		$user    = Auth::user();
		$user_id = $user->id;
		$charter = Charter::find( $request->charter );
        
        // Locking
		$isLocking = $request->get( "search_type" ) == "locked";
		
		$isEconomy = $request->flight_class == "Economy";

		$travelers  = $request->travelers;
		$passengers = $request->fields;

		$agent = $request->agent;

		$payNow      = $request->payMethod == "PayNow";
		$paylaterMax = $request->paylaterMax;

		// Checkout values
		$total = $commission = $passengerPrices = $prices =$pnr = null;

		$checkoutValuesObjects = json_decode( session( 'checkoutValues' ) );
		$checkoutValues        = json_decode( session( 'checkoutValues' ), true );
		extract( $checkoutValues );

		$status = ($payNow or $isLocked) ? "Confirmed" : "TimeLimit";

		$prices_single = $passengerPrices;

		
		

		// Create Order
		if ( ! $isLocking ) {

//			dd($status);
            $seatsEdit=CharterPrice::where('charter_id',$charter->id)->where('flight_class',$request->flight_class)->where('price_class',$request->price_class)->get();
            //return response()->json( ['x'=>$seatsEdit[0],"price_class"=>$charter->id]);
            $seatsEdit=CharterPrice::find($seatsEdit[0]->id);
            $seatsEdit->available_seats=($seatsEdit['available_seats']-($travelers['adults']+$travelers['children']));
            $seatsEdit->save();
            
			
			
			$pnr   = generatePNR();
			$order = CharterOrders::create( [
				'user_id'       => $user_id,
				'charter_id'    => $charter->id,
				'flight_type'   => $flight_type,
				'status'        => $status,
				'delivered_by'  => 0,
				'flight_class'  => $request->flight_class,
				'price'         => $total-$roundTotal,
				'open_end'      => $open_duration ? Carbon::now()->addMonths( $open_duration ) : null,
				'notiAt'      => $open_duration ? Carbon::now()->addMonths( $open_duration )->subDays(5) : null,
				'open_duration' => 0,
				'commission'    => calculateCommission( $charter, $total ),
				'pnr'           => $pnr,
				'note'          => $agent['note'],
				'phone'         => $agent['phone'],
				'email'         => $agent['email'],
				'expire_at'     => $payNow ? null : Carbon::now()->addHours( $paylaterMax )
			] );

			addCharterHistory( $order->id, "Booked Ticket" );
			
			
			if($flight_type=='RoundTrip'){
		    
    		    $charterRoundTrip = Charter::find( $request->charterRoundTrip );
    		    
    		    $seatsEdit=CharterPrice::where('charter_id',$charterRoundTrip->id)->where('flight_class',$request->flight_class)->where('price_class',$request->price_class)->get();
                //return response()->json( ['x'=>$seatsEdit[0],"price_class"=>$charter->id]);
                $seatsEdit=CharterPrice::find($seatsEdit[0]->id);
                $seatsEdit->available_seats=($seatsEdit['available_seats']-($travelers['adults']+$travelers['children']));
                $seatsEdit->save();
                
    			
    			
    			//$pnr   = generatePNR();
    			$charter2 = Charter::find( $charterRoundTrip->id );
    			$order2 = CharterOrders::create( [
    				'user_id'       => $user_id,
    				'charter_id'    => $charterRoundTrip->id,
    				'flight_type'   => $flight_type,
    				'status'        => $status,
    				'delivered_by'  => 0,
    				'flight_class'  => $request->flight_class,
    				'price'         => $roundTotal,
    				'open_end'      => $open_duration ? Carbon::now()->addMonths( $open_duration ) : null,
    				'notiAt'      => $open_duration ? Carbon::now()->addMonths( $open_duration )->subDays(5) : null,
    				'open_duration' => 0,
    				'commission'    => calculateCommission( $charter2, $total ),
    				'pnr'           => $pnr,
    				'note'          => $agent['note'],
    				'phone'         => $agent['phone'],
    				'email'         => $agent['email'],
    				'expire_at'     => $payNow ? null : Carbon::now()->addHours( $paylaterMax )
    			] );

		
		    }
		}
		
		




		// Deduct seats
		if ( $isLocked ) {
			$locked = Locked::find($request->departure_lockId);
            // return response()->json($locked ." ".$request->departure_lockId);
			
			$locked->seats-= $travelers['adults'];
			$locked->save();
			
			if($locked->seats == 0 ){$locked->delete();}
			
			$pnr   = generatePNR();
			$order = CharterOrders::create( [
    				'user_id'       => $user_id,
    				'charter_id'    => $charter->id,
    				'flight_type'   => $flight_type,
    				'status'        => $status,
    				'delivered_by'  => 0,
    				'flight_class'  => $request->flight_class,
    				'price'         => $total-$roundTotal,
    				'open_end'      => $open_duration ? Carbon::now()->addMonths( $open_duration ) : null,
    				'notiAt'      => $open_duration ? Carbon::now()->addMonths( $open_duration )->subDays(5) : null,
    				'open_duration' =>0,
    				'commission'    => calculateCommission( $charter, $total ),
    				'pnr'           => $pnr,
    				'note'          => $agent['note'],
    				'phone'         => $agent['phone'],
    				'email'         => $agent['email'],
    				'expire_at'     => $payNow ? null : Carbon::now()->addHours( $paylaterMax )
    			] );
			
			addCharterHistory( $order->id, "Booked Ticket" );
			
			

			if ( $flight_type=='RoundTrip') {
			    $charterRoundTrip = Charter::find( $request->charterRoundTrip );
				$locked = Locked::find($request->return_lockId);
				
				$locked->seats-= $travelers['adults'];
			    $locked->save();
			    
				if($locked->seats == 0 ){$locked->delete();}
				
				$order2 = CharterOrders::create( [
    				'user_id'       => $user_id,
    				'charter_id'    => $request->charterRoundTrip,
    				'flight_type'   => $flight_type,
    				'status'        => $status,
    				'delivered_by'  => 0,
    				'flight_class'  => $request->flight_class,
    				'price'         => 0,
    				'open_end'      => null,
    				'notiAt'      => null,
    				'commission'    => 0,
    				'pnr'           => $pnr,
    				'note'          => $agent['note'],
    				'phone'         => $agent['phone'],
    				'email'         => $agent['email'],
    				'expire_at'     => $payNow ? null : Carbon::now()->addHours( $paylaterMax )
    			] );
    
    			addCharterHistory( $order2->id, "Booked Ticket" );
			
			}
		}
		
		
		
			// Add order flights
// 		if ( ! $isLocking ) {
			$flights = $checkoutValuesObjects->flights;
			foreach ( $flights as $i => $flight ) {
				$price = $total;

				if ( $roundTotal && $i == 0 ) {
					$price = $total - $roundTotal;
				}

				if ( $roundTotal && $i == 1 ) {
					$price = $roundTotal;
				}

				$order->flights()->create( [
					'charter_id' => $flight->id,
					'price'      => $price,
					'commission' => calculateCommission( $flight, $price )
				] );
				$commission=calculateCommission( $flight, $price );
				
			}
			if($flight_type=='RoundTrip'){
			    $order2->flights()->create( [
					'charter_id' => $charterRoundTrip->id,
					'price'      => $total-$roundTotal,
					'commission' => calculateCommission( $charterRoundTrip, $total )
				]);
			}
// 		}
		
		

		// Add order passengers
		$ages = [
			"Adults"   => "adult",
			"Children" => "child",
			"Babies"   => "baby"
		];

		// Add flights to passenger related
		$ticket_number = generateTicketNumber();
		$tickets       = [];

// 		if ( ! $isLocking ) {
			foreach ( $passengers['title'] as $index => $v ) {
				$passenger = $order->passengers()->create( [
					"age"                  => $ages[ $passengers['age'][ $index ] ],
					"price"                => 0,// check
					"title"                => $passengers['title'][ $index ],
					"first_name"           => $passengers['first_name'][ $index ],
					"last_name"            => $passengers['last_name'][ $index ],
					"nationality"          => $passengers['nationality'][ $index ],
					"passport_number"      => $passengers['passport_number'][ $index ],
					"passport_expire_date" => Carbon::parse( str_replace( "/", "-", $passengers['passport_expire_date'][ $index ] ) )->toDateString(),
					"birth_date"           => Carbon::parse( str_replace( "/", "-", $passengers['birth_date'][ $index ] ) )->toDateString(),
				] );

				foreach ( $flights as $i => $flight ) {
					if ( $i == 1 ) {
						$prices_single = $roundPassengerPrices;
					}

					$passenger->related()->create( [
						"order_id"      => $order->id,
						"flight_id"     => $charter->id,
						"ticket_number" => $ticket_number . $index . $i,
						"price"         => $prices_single[ strtolower( $passengers['age'][ $index ] ) ]
					] );

					$tickets[] = [
						"name"   => $passengers['first_name'][ $index ] . ' ' . $passengers['last_name'][ $index ],
						"ticket" => $ticket_number . $index . $i
					];
				}
			}
// 		}
		// Save to transactions
		$new_balance = Auth::user()->balance - $total;
		if ( $isLocking ) {
			/*$user->lockedCharter()->create( [
				"charter_id" => $charter->id,
				"price"      => $total,
				"seats"      => $travelers['adults'],
				"seat_price"      => $total / $travelers['adults'],
			] );*/
        

			Auth::user()->userTransactions()->create( [
				'to'             => Auth::user()->id,
				'amount'         => $total,
				'pnr'           => $pnr,
				'comment'        => "Charter reserve seats",
				'type'           => "withdrawal",
				'creditBefore'   => Auth::user()->balance,
				'creditAfter'    => Auth::user()->balance,
				'connectedID'    => $charter->id,
				'connectedTable' => 'charter'
			] );

// 			Auth::user()->update( [ 'balance' => $new_balance ] );
		} else {
			if ( $payNow and ! $isLocked ) {
				$new_balance = Auth::user()->balance - $total;
				Auth::user()->userTransactions()->create( [
					'to'             => Auth::user()->id,
					'amount'         => $total,
					'pnr'            => $pnr,
					'comment'        => "Charter order",
					'type'           => "withdrawal",
					'creditBefore'   => Auth::user()->balance,
					'creditAfter'    => $new_balance,
					'connectedID'    => $charter->id,
					'connectedTable' => 'charter'
				] );

				Auth::user()->update( [ 'balance' => $new_balance ] );
				
				
				///// commission
				$new_balance = Auth::user()->balance + $commission;
				Auth::user()->userTransactions()->create( [
					'to'             => Auth::user()->id,
					'amount'         => $commission,
					'pnr'            => $pnr,
					'comment'        => "Charter commission",
					'type'           => "DepositOfCredit",
					'creditBefore'   => Auth::user()->balance,
					'creditAfter'    => $new_balance,
					'connectedID'    => $charter->id,
					'connectedTable' => 'charter'
				] );

				Auth::user()->update( [ 'balance' => $new_balance ] );
			}
		}

        $html = view( "front.charter.order_summary", compact( 'tickets', 'pnr' ) )->render();
      
      $users = User::where( 'type', 'Super Admin' )->get();
		Notification::send( $users, new Notifier( [
			'message' => 'new charter order by (' . Auth::user()->name . ')',
			'url'     => route( 'charterOrders', [ 'flight' => $flight->id ] )
		], 'New Charter Order' ) );
		
		if ( $isLocking ) {
			return response()->json( [
				"error"   => false,
    			"data"    => $request->all(),
    			"pnr"     => $pnr,
    			"tickets" => $tickets,
    			"order"   => $order->id,
				"html"    => $html
			] );
		}

		

		return response()->json( [
			"error"   => false,
			"data"    => $request->all(),
			"pnr"     => $pnr,
			"tickets" => $tickets,
			"html"    => $html,
			"order"   => $order->id,
		] );
	}

  

	public function charterPreCheckout( Charter $flight, CharterPreCheckoutRequest $request ) {
		session()->put( 'charter-checkout-form', json_encode( $request->all() ) );

		return redirect()->route( 'charter-checkout', [ 'flight' => $flight->id ] );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function charterCheckoutPage( Charter $flight ) {
		if ( ! Auth::check() ) {
			return redirect()->route( 'charter-pre-checkout', [ 'flight' => $flight->id ] );
		}

		if ( session()->get( 'charter-checkout-form' ) === null ) {
			return redirect()->route( 'charter-pre-checkout', [ 'flight' => $flight->id ] );
		}

		$travelers = json_decode( session( 'charter-checkout-form' ) );

        //		print_r($travelers); die();
		$locked  = false;
		$locking = false;
		if ( isset( $travelers->locked ) ) {
			$locked = Locked::find( $travelers->locked );
		}

		$day = $travelers->day;

		$priceDay = $flight->price[ $day ];

		if ( intval( $travelers->back ) > 0 and intval( $travelers->backDay ) > 0 ) {
			$priceDay['adult']    = isset( $priceDay['adult_2way'] ) ? $priceDay['adult_2way'] : $priceDay['adult'];
			$priceDay['children'] = isset( $priceDay['children_2way'] ) ? $priceDay['children_2way'] : $priceDay['children'];
			$priceDay['baby']     = isset( $priceDay['baby_2way'] ) ? $priceDay['baby_2way'] : $priceDay['baby'];
			$priceDay['business'] = isset( $priceDay['business_2way'] ) ? $priceDay['business_2way'] : $priceDay['business'];
		}

		$adultPrice    = $priceDay['adult'];
		$childrenPrice = $priceDay['children'];
		$babyPrice     = $priceDay['baby'];
		$businessPrice = $priceDay['business'];

		$price = ( $businessPrice * $travelers->business ) + ( $adultPrice * $travelers->adult ) + ( $childrenPrice * $travelers->children ) + ( $babyPrice * $travelers->baby );

		if ( $locked ) {
			$price = ( $babyPrice * $travelers->baby );
		}

		$travelersCount = count( $travelers->first_name );

		$commission = 0;
		if ( $flight->commission > 0 ) {
			$commission = $flight->commission;
			if ( $travelersCount > 0 ) {
				$commission *= $travelersCount;
			}

			if ( $flight->is_percent ) {
				$commission = ( $price * $flight->commission ) / 100;
			}
		}

		$price -= $commission;

		// If has back day
		$priceBack = 0;
		$backDay   = $travelers->backDay;
		$back      = $travelers->back;

		if ( intval( $travelers->back ) > 0 and intval( $travelers->backDay ) > 0 ) {
			$hasBack = true;
			$back    = Charter::find( $back );

			$backPriceDay = $back->price[ $backDay ];

			$backPriceDay['adult']    = isset( $backPriceDay['adult_2way'] ) ? $backPriceDay['adult_2way'] : $backPriceDay['adult'];
			$backPriceDay['children'] = isset( $backPriceDay['children_2way'] ) ? $backPriceDay['children_2way'] : $backPriceDay['children'];
			$backPriceDay['baby']     = isset( $backPriceDay['baby_2way'] ) ? $backPriceDay['baby_2way'] : $backPriceDay['baby'];
			$backPriceDay['business'] = isset( $backPriceDay['business_2way'] ) ? $backPriceDay['business_2way'] : $backPriceDay['business'];

			$adultPriceBack    = $backPriceDay['adult'];
			$childrenPriceBack = $backPriceDay['children'];
			$babyPriceBack     = $backPriceDay['baby'];
			$businessPriceBack = $backPriceDay['business'];

			$priceBack = ( $businessPriceBack * $travelers->business ) + ( $adultPriceBack * $travelers->adult ) + ( $childrenPriceBack * $travelers->children ) + ( $babyPriceBack * $travelers->baby );

			if ( $locked ) {
				$price = ( $babyPriceBack * $travelers->baby );
			}

			$commission = 0;
			if ( $back->commission > 0 ) {
				$commission = $back->commission;
				if ( $travelersCount > 0 ) {
					$commission *= $travelersCount;
				}

				if ( $back->is_percent ) {
					$commission = ( $priceBack * $back->commission ) / 100;
				}
			}

			$priceBack -= $commission;
		}

		$price = $price + $priceBack;

		return view( 'front.charter.flightCheckout', compact( 'flight', 'price', 'travelersCount', 'hasBack', 'backDay', 'back', 'locked' ) );
	}

	function validateDate( $date, $format = 'Y-m-d' ) {
		$d = DateTime::createFromFormat( $format, $date );

		// The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
		return $d && $d->format( $format ) === $date;
	}

/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function _charterCheckout( Charter $flight ) {
		if ( ! session()->has( 'charter-checkout-form' ) && ! Auth::check() ) {
			return redirect()->route( 'charter-pre-checkout', [ 'flight' => $flight->id ] );
		}

		$request = json_decode( session( 'charter-checkout-form' ) );

		$locked = false;
		if ( isset( $request->locked ) ) {
			$locked = Locked::find( $request->locked );
			$count  = $request->adult + $request->children + $request->business;

			Locked::where( 'id', $request->locked )->update( [
				'reserved' => $locked->reserved + $count
			] );
		}

		$day = $request->day;

		$priceDay = $flight->price[ $day ];

		if ( intval( $request->back ) > 0 and intval( $request->backDay ) ) {
			$priceDay['adult']    = isset( $priceDay['adult_2way'] ) ? $priceDay['adult_2way'] : $priceDay['adult'];
			$priceDay['children'] = isset( $priceDay['children_2way'] ) ? $priceDay['children_2way'] : $priceDay['children'];
			$priceDay['baby']     = isset( $priceDay['baby_2way'] ) ? $priceDay['baby_2way'] : $priceDay['baby'];
			$priceDay['business'] = isset( $priceDay['business_2way'] ) ? $priceDay['business_2way'] : $priceDay['business'];
		}

		$adultPrice    = $priceDay['adult'];
		$childrenPrice = $priceDay['children'];
		$babyPrice     = $priceDay['baby'];
		$businessPrice = $priceDay['business'];

		$price = ( $adultPrice * $request->adult ) + ( $childrenPrice * $request->children ) + ( $babyPrice * $request->baby ) + ( $businessPrice * $request->business );

		if ( $locked ) {
			$price = ( $babyPrice * $request->baby );
		}

		$backPrice = 0;
		if ( intval( $request->back ) > 0 and intval( $request->backDay ) ) {
			$backDay = $request->backDay;
			$back    = Charter::find( $request->back );

			$backPriceDay = $back->price[ $backDay ];

			$backPriceDay['adult']    = isset( $backPriceDay['adult_2way'] ) ? $backPriceDay['adult_2way'] : $backPriceDay['adult'];
			$backPriceDay['children'] = isset( $backPriceDay['children_2way'] ) ? $backPriceDay['children_2way'] : $backPriceDay['children'];
			$backPriceDay['baby']     = isset( $backPriceDay['baby_2way'] ) ? $backPriceDay['baby_2way'] : $backPriceDay['baby'];
			$backPriceDay['business'] = isset( $backPriceDay['business_2way'] ) ? $backPriceDay['business_2way'] : $backPriceDay['business'];

			$adultPrice    = $backPriceDay['adult'];
			$childrenPrice = $backPriceDay['children'];
			$babyPrice     = $backPriceDay['baby'];
			$businessPrice = $backPriceDay['business'];

			$backPrice = ( $adultPrice * $request->adult ) + ( $childrenPrice * $request->children ) + ( $babyPrice * $request->baby ) + ( $businessPrice * $request->business );

			if ( $locked ) {
				$backPrice = ( $babyPrice * $request->baby );
			}
		}

		$price += $backPrice;

		if ( $price > Auth::user()->balance ) {
			return redirect()->back()->with( [ 'fail' => 'رصيدك الحالي لا يكفي اتمام هذه العملية.' ] );
		}

		$travelers = [];
		if ( $request->adult > 0 ) {
			for ( $i = 0; $i < $request->adult; $i ++ ) {
				$travelers[] = [ $i, "adult" ];
			}
		}

		if ( $request->children > 0 ) {
			for ( $i = 0; $i < $request->children; $i ++ ) {
				$travelers[] = [ $i, "children" ];
			}
		}

		if ( $request->baby > 0 ) {
			for ( $i = 0; $i < $request->baby; $i ++ ) {
				$travelers[] = [ $i, "baby" ];
			}
		}

		if ( $request->business > 0 ) {
			for ( $i = 0; $i < $request->business; $i ++ ) {
				$travelers[] = [ $i, "business" ];
			}
		}

		// Generate PNR
		$pnr     = '';
		$randPos = rand( 1, 4 );
		for ( $i = 0; $i < 6; $i ++ ) {
			if ( $i == $randPos ) {
				$pnr .= strtoupper( Str::random( 1 ) );
			} else {
				$pnr .= rand( 1, 9 );
			}
		}
		//===============

		$orderObject = $flight->orders()->create( [
			'user_id'  => Auth::user()->id,
			'note'     => $request->note,
			'phone'    => $request->phone,
			'price'    => $price,
			'day'      => $day,
			'pnr'      => $pnr,
			'back_id'  => $request->back,
			'back_day' => $request->backDay,
		] );

		$order = $orderObject->id;

		$key        = 0;
		$seats      = 0;
		$ticket     = rand( 111111, 999999 );
		$ticketBack = rand( 111111, 999999 );
		foreach ( $travelers as $traveler ) {

			$passengerPrice = $flight->price[ $day ][ $traveler[1] ];
			if ( $backPrice > 0 ) {
				$passengerPrice = isset( $flight->price[ $day ][ $traveler[1] . '_2way' ] ) ? $flight->price[ $day ][ $traveler[1] . '_2way' ] : $flight->price[ $day ][ $traveler[1] ];
			}

			$passengerData = [
				'order_id'             => $order,
				'first_name'           => $request->first_name[ $key ],
				'title'                => isset( $request->title[ $key ] ) ? $request->title[ $key ] : "INF",
				'last_name'            => $request->last_name[ $key ],
				'birth_date'           => Carbon::parse( str_replace( '/', '-', $request->birth_date[ $key ] ) )->format( 'Y-m-d' ),
				'nationality'          => $request->nationality[ $key ],
				'passport_number'      => $request->passport_number[ $key ],
				'passport_expire_date' => Carbon::parse( str_replace( '/', '-', $request->passport_expire_date[ $key ] ) )->format( 'Y-m-d' ),
				'price'                => $passengerPrice,
				'ticket_number'        => $ticket + $key,
				'ticket_back'          => $ticketBack + $key,
				'class'                => $traveler[1] == "business" ? "Business" : "Economy"
			];

			if ( intval( $request->back ) > 0 and intval( $request->backDay ) ) {
				$back = Charter::find( $request->back );

				$passengerBackPrice = isset( $back->price[ $request->backDay ][ $traveler[1] . '_2way' ] ) ? $back->price[ $request->backDay ][ $traveler[1] . '_2way' ] : $back->price[ $request->backDay ][ $traveler[1] ];

				$passengerData['price_back'] = $passengerBackPrice;
			}

			CharterPassengers::create( $passengerData );

			$key ++;

			if ( $traveler[1] != "baby" ) {
				$seats ++;
			}
		}

		$reserved_seats = $flight->price[ $day ]['reserved_seats'];

		$priceData = [];
		$index     = 0;
		foreach ( $flight->price as $pr ) {
			$modifiedPrice = $pr;
			if ( $day == $index ) {
				$modifiedPrice["reserved_seats"] = $reserved_seats + $seats;
			}

			$priceData[] = $modifiedPrice;
			$index ++;
		}

		$flight->update( [
			"price" => $priceData
		] );

		// For Back Day
		$backFlight = $orderObject->back;
		if ( $backFlight ) {
			$reserved_seats = $backFlight->price[ $day ]['reserved_seats'];

			$priceData = [];
			$index     = 0;
			foreach ( $backFlight->price as $pr ) {
				$modifiedPrice = $pr;
				if ( $day == $index ) {
					$modifiedPrice["reserved_seats"] = $reserved_seats + $seats;
				}

				$priceData[] = $modifiedPrice;
				$index ++;
			}

			$backFlight->update( [
				"price" => $priceData
			] );
		}

		// Save to transactions
		$new_balance = Auth::user()->balance - $price;
		Auth::user()->userTransactions()->create( [
			'to'             => Auth::user()->id,
			'amount'         => $price,
			'comment'        => "Charter order",
			'type'           => "withdrawal",
			'creditBefore'   => Auth::user()->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $flight->id,
			'connectedTable' => 'charter'
		] );
		//================== START Commission
		$item = $flight;
		if ( $item->commission > 0 ) {
			$commissionObject = getCommission( $item );
			$commission       = $commissionObject->commission;
			if ( count( $travelers ) > 0 ) {
				$commission *= count( $travelers );
			}

			if ( $commissionObject->is_percent ) {
				$commission = ( $price * $commissionObject->commission ) / 100;
			}

			Auth::user()->userTransactions()->create( [
				'to'             => Auth::user()->id,
				'amount'         => $commission,
				'type'           => "DepositOfCredit",
				'comment'        => "Charter commission",
				'creditBefore'   => $new_balance,
				'creditAfter'    => $new_balance + $commission,
				'connectedID'    => $flight->id,
				'connectedTable' => 'charter'
			] );

			$new_balance = $new_balance + $commission;
		}
		//================== END Commission

		Auth::user()->update( [ 'balance' => $new_balance ] );

		session()->forget( 'flight-checkout-form' );
		session()->forget( 'flight-checkout-form-passport-images' );
		session()->forget( 'flight-checkout-form-personal-images' );

		$users = User::where( 'type', 'Super Admin' )->get();
		Notification::send( $users, new Notifier( [
			'message' => 'new charter order by (' . Auth::user()->name . ')',
			'url'     => route( 'charterOrders', [ 'flight' => $flight->id ] )
		], 'New Charter Order' ) );

		$message = App::getLocale() === 'ar' ? 'لقد تمت العملية بنجاح.' : 'ticket request was sent successfully!';

		return redirect()->route( 'charter-pre-checkout', [ 'flight' => $flight->id ] )->with( [
			'success' => $message,
			'order'   => $order,
			"pnr"     => $pnr
		] );
	}

	public function charterTicket( Request $request ) {
		$order       = CharterOrders::where( "pnr", $request->pnr )->first();
		$hide_prices = $request->has( "hide_prices" );

		$index = 0;
		$flights = $order->flights;

		$status = [
			"TimeLimit"  => "TEMPORARY",
			"Confirmed" => "CONFIRMED",
			"Cancelled" => "CANCELLED"
		];

		$statusColors = [
			"TimeLimit"  => "info",
			"Confirmed" => "success",
			"Cancelled" => "danger"
		];

		if(!$request->has("dev")) {
//			dd("Error");
		}

		$isSearch = false;

		return view( 'front.charter.ticket', compact( 'order', 'hide_prices', 'index', 'status', 'statusColors', 'flights', 'isSearch' ) );
	}

	public function  downloadCharterTicker( Request $request ) {
		$order       = CharterOrders::where( "pnr", $request->pnr )->first();
		$hide_prices = $request->has( "hide_prices" );

		$index = 0;
		$flights = $order->flights;

		$status = [
			"TimeLimit"  => "TEMPORARY",
			"Confirmed" => "CONFIRMED",
			"Cancelled" => "CANCELLED"
		];

		$statusColors = [
			"TimeLimit"  => "info",
			"Confirmed" => "success",
			"Cancelled" => "danger"
		];
		$isSearch = false;
//dd( $order    , $hide_prices, $index, $flights, $status , $statusColors, $isSearch );
	 $pdf = PDF::loadView( 'front.charter.ticket', compact( 'order', 'hide_prices', 'index', 'status', 'statusColors', 'flights', 'isSearch' ) );
     	$pdf->SetProtection(['copy', 'print'], '', 'pass');

   return $pdf->download( 'Ticket.pdf' );
    
   //   PDF::setOptions(['dpi' => 150, 'defaultFont' => 'DejaVu Sans']);
   //   $pdf = \App::make('dompdf.wrapper');
     // $pdf = App::make('dompdf');
   // $pdf->loadView('front.charter.ticket', compact( 'order', 'hide_prices', 'index', 'status', 'statusColors', 'flights', 'isSearch' ) ); 
     // return $pdf->stream('Ticket');
     //return $pdf->download('Ticket.pdf');
      
      
     // $pdf  =  \App::make('dompdf.wrapper');
   // $view =  View::make('front.charter.ticket', compact('order', 'hide_prices', 'index', 'status', 'statusColors', 'flights', 'isSearch'))->render();
    //$pdf->loadHTML($view);
    //return  $pdf->stream('Ticket');
    //return $pdf->stream('invoice');
   //return $pdf->download('Ticket.pdf');
     
      
      
	}

	public function pnrSearch( Request $request ) {
		$pnr   = $request->get( "pnr" );
		$order = CharterOrders::where( "pnr", $pnr )->first();

		$ticket = null;
		if ( $order ) {
			$hide_prices = false;
			$flights = $order->flights;

			$status = [
				"TimeLimit"  => "TEMPORARY",
				"Confirmed" => "CONFIRMED",
				"Cancelled" => "CANCELLED"
			];

			$statusColors = [
				"TimeLimit"  => "info",
				"Confirmed" => "success",
				"Cancelled" => "danger"
			];

			$isSearch = true;

			$ticket = view( 'front.charter.ticket', compact( 'order', 'status', 'statusColors', 'flights', 'hide_prices', 'isSearch' ) );
		}

		$isAdmin = false;

		if ( Auth::check() and Auth::user()->type == 'Super Admin' ) {
			$isAdmin = true;
		}

		return view( 'front.charter.pnr', compact( 'order', 'ticket', 'isAdmin' ) );
	}

	// Visa Purchase Section

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function visaPreCheckout( Visa $visa, VisaPreCheckoutRequest $request ) {
		session()->put( 'visa-checkout-form', json_encode( $request->all() ) );
		$passport_images = [];
		$personal_images = [];
		foreach ( $request->first_name as $key => $traveler ) {
			$passport_images[ $key ] = Storage::disk( 'public' )->put( 'visa/reserve/passport', $request->passport_image[ $key ] );
			$personal_images[ $key ] = Storage::disk( 'public' )->put( 'visa/reserve/personal', $request->personal_image[ $key ] );
		}

		session( [ 'visa-checkout-form-passport-images' => json_encode( $passport_images ) ] );
		session( [ 'visa-checkout-form-personal-images' => json_encode( $personal_images ) ] );

		return redirect()->route( 'visa-checkout', [ 'visa' => $visa->id ] );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function visaCheckoutPage( Visa $visa ) {
		if ( ! Auth::check() ) {
			return redirect()->route( 'visa-pre-checkout', [ 'visa' => $visa->id ] );
		}

		if ( session()->get( 'visa-checkout-form' ) === null ) {
			return redirect()->route( 'visa-pre-checkout', [ 'visa' => $visa->id ] );
		}

		$request = json_decode( session( 'visa-checkout-form' ) );

		$travelers = count( $request->first_name );

		$price = $travelers * (int) $visa->price;

		$latest_visas = Visa::where( 'id', '!=', $visa->id )->orderBy( 'id', 'DESC' )->take( 4 )->get();

		return view( 'front.visa.visaCheckout', compact( 'visa', 'latest_visas', 'price', 'travelers' ) );
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function visaCheckout( Visa $visa ) {
		if ( ! session()->has( 'visa-checkout-form' ) && ! Auth::check() ) {
			return redirect()->route( 'visa-pre-checkout', [ 'visa' => $visa->id ] );
		}

		$request         = json_decode( session( 'visa-checkout-form' ) );
		$passport_images = json_decode( session( 'visa-checkout-form-passport-images' ) );
		$personal_images = json_decode( session( 'visa-checkout-form-personal-images' ) );

		$travelers = count( $request->first_name );

		$price = $travelers * (int) $visa->price;

		if ( $price > Auth::user()->balance ) {
			return redirect()->back()->with( [ 'fail' => 'رصيدك الحالي لا يكفي اتمام هذه العملية.' ] );
		}

		foreach ( $request->first_name as $key => $traveler ) {
			$visa->orders()->create( [
				'user_id'                => Auth::user()->id,
				'first_name'             => $request->first_name[ $key ],
				'last_name'              => $request->last_name[ $key ],
				'birth_place'            => $request->birth_place[ $key ],
				'birth_date'             => Carbon::parse( str_replace( '/', '-', $request->birth_date[ $key ] ) )->format( 'Y-m-d' ),
				'nationality'            => $request->nationality[ $key ],
				'passport_number'        => $request->passport_number[ $key ],
				'passport_issuance_date' => Carbon::parse( str_replace( '/', '-', $request->passport_issuance_date[ $key ] ) )->format( 'Y-m-d' ),
				'passport_expire_date'   => Carbon::parse( str_replace( '/', '-', $request->passport_expire_date[ $key ] ) )->format( 'Y-m-d' ),
				'father_name'            => $request->father_name[ $key ],
				'mother_name'            => $request->mother_name[ $key ],
				'price'                  => $visa->price,
				'passport_image'         => $passport_images[ $key ],
				'personal_image'         => $personal_images[ $key ],
			] );
		}

		// Save to transactions
		$new_balance = Auth::user()->balance - $price;
		Auth::user()->userTransactions()->create( [
			'to'             => Auth::user()->id,
			'amount'         => $price,
			'comment'        => "Visa order",
			'type'           => "withdrawal",
			'creditBefore'   => Auth::user()->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $visa->id,
			'connectedTable' => 'visa'
		] );


		//================== START Commission
		$item = $visa;
		if ( $item->commission > 0 ) {
			$commissionObject = getCommission( $item );
			$commission       = $commissionObject->commission;

			if ( count( $request->first_name ) > 0 ) {
				$commission *= count( $request->first_name );
			}

			if ( $commissionObject->is_percent ) {
				$commission = ( $price * $commissionObject->commission ) / 100;
			}

			Auth::user()->userTransactions()->create( [
				'to'             => Auth::user()->id,
				'amount'         => $commission,
				'type'           => "DepositOfCredit",
				'comment'        => "Visa commission",
				'creditBefore'   => $new_balance,
				'creditAfter'    => $new_balance + $commission,
				'connectedID'    => $visa->id,
				'connectedTable' => 'visa'
			] );

			$new_balance = $new_balance + $commission;
		}
		//================== END Commission

		Auth::user()->update( [ 'balance' => $new_balance ] );

		session()->forget( 'visa-checkout-form' );
		session()->forget( 'visa-checkout-form-passport-images' );
		session()->forget( 'visa-checkout-form-personal-images' );

		$users = User::where( 'type', 'Super Admin' )->get();
		Notification::send( $users, new Notifier( [
			'message' => 'new visa order by (' . Auth::user()->name . ')',
			'url'     => route( 'visaOrders', [ 'visa' => $visa->id ] )
		], 'New Visa Order' ) );

		$message = App::getLocale() === 'ar' ? 'لقد تمت العملية بنجاح.' : 'Your visa request was sent successfully!';

		return redirect()->route( 'singleVisa', [ 'visa' => $visa->id ] )->with( [ 'success' => $message ] );
	}



	// ٍSearch Section

	/**
	 * @param $view
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function search( $view, Request $request ) {
		$request->going  = str_replace( "/", "-", $request->going );
		$request->coming = str_replace( "/", "-", $request->coming );

		$items = [];
		if ( $view === 'travels' ) {
			$forVariable = 'travel';

			$query = Travel::query();
			if ( $request->from ) {
				$query->where( 'from_country', $request->from );
			}
			if ( $request->to ) {
				$query->where( 'to_country', $request->to );
			}
			if ( $request->going ) {
				$query->where( 'from_date', '>=', Carbon::parse( $request->going )->format( 'Y-m-d' ) );
			}
			if ( $request->coming ) {
				$query->where( 'to_date', '<=', Carbon::parse( $request->coming )->format( 'Y-m-d' ) );
			}
			$items = $query->paginate( 9 );
		}
		if ( $view === 'flights' ) {
			$forVariable = 'flight';
			$query       = Flight::query();
			if ( $request->from ) {
				$query->where( 'trip_information->common->going->from_country', $request->from );
			}
			if ( $request->to ) {
				$query->where( 'trip_information->common->going->to_country', $request->to );
			}
			if ( $request->going ) {
				$query->where( 'trip_information->common->going->start_date', '>=', Carbon::parse( $request->going )->format( 'Y-m-d' ) );
			}
			if ( $request->coming ) {
				$query->where( 'trip_information->common->going->end_date', '<=', Carbon::parse( $request->coming )->format( 'Y-m-d' ) );
			}
			if ( $request->ticket ) {
				$query->where( 'ticket', $request->ticket );
			}
			if ( $request->stop ) {
				$query->where( 'stop', $request->stop );
			}
			$items = $query->paginate( 9 );
		}
		if ( $view === 'charter' ) {
			$forVariable = 'charter';

			$results           = [];
			$allowedDaysGoing  = [];
			$allowedDaysComing = [];

			$params = $request->all();

			$goingDate     = Carbon::parse( $request->going );
			$fromDate      = Carbon::parse( $request->going );
			$fromDatePlus  = $goingDate->addDays( 7 );
			$fromDateMinus = Carbon::parse( $request->going )->subDays( 7 );

			if ( $request->ticket == "OneWay" ) {
				$query = Charter::query();

				if ( $request->from ) {
					$query->where( 'trip_information->common->going->from_country', $request->from );
				}
				if ( $request->to ) {
					$query->where( 'trip_information->common->going->to_country', $request->to );
				}
				if ( $request->going ) {
					$query->where( 'trip_information->common->going->start_date', '>=', Carbon::parse( $request->going )->format( 'Y-m-d' ) );
				}
				if ( $request->coming ) {
					$query->where( 'trip_information->common->going->end_date', '<=', Carbon::parse( $request->coming )->format( 'Y-m-d' ) );
				}
				if ( $request->ticket ) {
					$query->where( 'ticket', $request->ticket );
				}
				if ( $request->stop ) {
					$query->where( 'stop', $request->stop );
				}


				$items = [];
				$trips = $query->get();

				foreach ( $trips as $trip ) {
					$days = $trip->price;

					foreach ( $days as $day ) {
						$date = Carbon::parse( $day['date'] );
						if ( $date->gte( $fromDate ) and $date->lte( $fromDatePlus ) ) {
							$items[ $trip->id ]                            = $trip;
							$allowedDaysGoing[ $trip->id ][ $day['date'] ] = 1;
						}
					}
				}

				$fromToCountries = '';
				if ( $request->from and $request->to ) {
					$fromCountry = \App\Country::find( $request->from )->name[ App::getLocale() ];
					$toCountry   = \App\Country::find( $request->to )->name[ App::getLocale() ];

					$fromToCountries = '<span>' . __( 'charter.from' ) . '</span> ' . $fromCountry . ' <span>' . __( 'charter.to' ) . '</span> ' . $toCountry;
				}

				$params['going'] = $fromDatePlus->format( "d/m/Y" );
				$nextWeekUrl     = $this->buildUrlFromQuery( $params );

				$params['going'] = $fromDateMinus->format( "d/m/Y" );
				$prevWeekUrl     = $this->buildUrlFromQuery( $params );

				$results[] = [
					'items'           => $items,
					'fromToCountries' => $fromToCountries,
					'fromToDates'     => [
						$fromDate->format( "d-m-Y" ),
						$fromDatePlus->format( "d-m-Y" ),
						$nextWeekUrl,
						$prevWeekUrl,
					],
				];
			}

			if ( $request->ticket == "RoundTrip" ) {
				/*
				 * Round trip query
				 */
				$comingDate  = Carbon::parse( $request->coming );
				$toDate      = Carbon::parse( $request->coming );
				$toDatePlus  = $comingDate->addDays( 7 );
				$toDateMinus = Carbon::parse( $request->coming )->subDays( 7 );

				// Going
				$query = Charter::query();

				if ( $request->from ) {
					$query->where( 'trip_information->common->going->from_country', $request->from );
				}
				if ( $request->to ) {
					$query->where( 'trip_information->common->going->to_country', $request->to );
				}

				if ( $request->stop ) {
					$query->where( 'stop', $request->stop );
				}

				$items = [];
				$trips = $query->get();

				foreach ( $trips as $trip ) {
					$days = $trip->price;

					foreach ( $days as $day ) {
						$date = Carbon::parse( $day['date'] );
						if ( $date->gte( $fromDate ) and $date->lte( $fromDatePlus ) ) {
							$items[ $trip->id ]                            = $trip;
							$allowedDaysGoing[ $trip->id ][ $day['date'] ] = 1;
						}
					}
				}

				$fromToCountries = $fromToDates = '';
				if ( $request->from and $request->to ) {
					$fromCountry = \App\Country::find( $request->from )->name[ App::getLocale() ];
					$toCountry   = \App\Country::find( $request->to )->name[ App::getLocale() ];

					$fromToCountries = '<span>' . __( 'charter.from' ) . '</span> ' . $fromCountry . ' <span>' . __( 'charter.to' ) . '</span> ' . $toCountry;
				}

				$params['going'] = $fromDatePlus->format( "d/m/Y" );
				$nextWeekUrl     = $this->buildUrlFromQuery( $params );

				$params['going'] = $fromDateMinus->format( "d/m/Y" );
				$prevWeekUrl     = $this->buildUrlFromQuery( $params );

				$results[] = [
					'items'           => $items,
					'fromToCountries' => $fromToCountries,
					'fromToDates'     => [
						$fromDate->format( "d-m-Y" ),
						$fromDatePlus->format( "d-m-Y" ),
						$nextWeekUrl,
						$prevWeekUrl,
					],
				];

				// Coming
				$query = Charter::query();

				if ( $request->to ) {
					$query->where( 'trip_information->common->going->from_country', $request->to );
				}
				if ( $request->from ) {
					$query->where( 'trip_information->common->going->to_country', $request->from );
				}

				if ( $request->stop ) {
					$query->where( 'stop', $request->stop );
				}

				$query->where( 'ticket', "OneWay" );

				$items = [];
				$trips = $query->get();

				foreach ( $trips as $trip ) {
					$days = $trip->price;

					foreach ( $days as $day ) {
						$date = Carbon::parse( $day['date'] );
						if ( $date->gte( $toDate ) and $date->lte( $toDatePlus ) ) {
							$items[ $trip->id ]                             = $trip;
							$allowedDaysComing[ $trip->id ][ $day['date'] ] = 1;
						}
					}
				}

				$fromToCountries = '';
				if ( $request->from and $request->to ) {
					$fromCountry = \App\Country::find( $request->to )->name[ App::getLocale() ];
					$toCountry   = \App\Country::find( $request->from )->name[ App::getLocale() ];

					$fromToCountries = '<span>' . __( 'charter.from' ) . '</span> ' . $fromCountry . ' <span>' . __( 'charter.to' ) . '</span> ' . $toCountry;
				}

				$params['coming'] = $toDatePlus->format( "d/m/Y" );
				$nextWeekUrl      = $this->buildUrlFromQuery( $params );

				$params['coming'] = $toDateMinus->format( "d/m/Y" );
				$prevWeekUrl      = $this->buildUrlFromQuery( $params );

				$results[] = [
					'items'           => $items,
					'fromToCountries' => $fromToCountries,
					'fromToDates'     => [
						$toDate->format( "d-m-Y" ),
						$toDatePlus->format( "d-m-Y" ),
						$nextWeekUrl,
						$prevWeekUrl,
					],
				];

			}

			return view( 'front.charter_search', compact( 'items', 'view', 'forVariable', 'results', 'allowedDaysComing', 'allowedDaysGoing' ) );
		}
		if ( $view === 'visa' ) {
			$forVariable = 'visa';
			$items       = Visa::where( 'name->en', 'like', '%' . $request->keyword . '%' )
			                   ->orWhere( 'name->ar', 'like', '%' . $request->keyword . '%' )->paginate( 9 );;
		}

		return view( 'front.search', compact( 'items', 'view', 'forVariable' ) );
	}

	function buildUrlFromQuery( $params ) {
		$url          = \Request::url();
		$paramsString = [];
		foreach ( $params as $k => $v ) {
			$paramsString[] = $k . "=" . $v;
		}

		return $url . "?" . implode( "&", $paramsString );
	}

	/**
	 * @param VisaOrders $visa
	 *
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function visaDownloadPdf( VisaOrders $visa ) {
		return response()->download( storage_path() . '/app/public/' . $visa->visa_pdf );
	}

	/**
	 * @param TravelOrders $travel
	 *
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function travelDownloadPdf( TravelOrders $travel ) {
		return response()->download( storage_path() . '/app/public/' . $travel->travel_pdf );
	}

	/**
	 * @param FlightOrders $flight
	 *
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function flightDownloadPdf( FlightOrders $flight ) {
		return response()->download( storage_path() . '/app/public/' . $flight->flight_pdf );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function aboutUs() {
		$setting = Setting::first();

		return view( 'front.about', compact( 'setting' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function contactUs() {
		$setting = Setting::first();

		return view( 'front.contact', compact( 'setting' ) );
	}

	/**
	 * @param Page $page
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function page( Page $page ) {
      $a = Page::find(2);
      if( $a ){
         return redirect()->route('front-home');
      }
		return view( 'front.page', compact( 'page' ) );
	}

	/*public function contact()
	{
	}*/
}

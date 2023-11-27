<?php

namespace App\Http\Controllers;

use App\Aircraft;
use App\Charter;
use App\CharterPrice;
use App\CharterOrder;
use App\CharterOrderFlights;
use App\CharterOrders;
use App\CharterPassengers;
use App\CharterPassengersRelated;
use App\Country;
use App\DownloadExport;
use App\ExportSingleOrder;
use App\Locked;
use App\Nationality;
use App\Notifications\Notifier;
use App\SpecialCommission;
use App\User;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use DB;
class CharterController extends Controller {

	public function __construct() {
		$this->middleware( [ 'auth', 'dashboardAccess' ] );
	}

	public function index( Request $request ) {
		Session::flash( 'sidebar', 'charter' );
		$charters = Charter::all();

		$isArchive = $request->get( "show" ) == "archive";

		return view( 'admin.charter.index', compact( 'charters', 'isArchive' ) );
	}

	public function charterData( Datatables $datatables, Request $request ) {
		$query = Charter::orderBy( 'flight_date', 'asc' );

		if ( $request->get( "show" ) == "archive" ) {
			$query->where( 'flight_date', '<', Carbon::today() );
		} else {
			$query->where( 'flight_date', '>=', Carbon::today() );
		}

		$builder = $query->get();

		return $datatables
			->of( $builder )
			->addColumn( 'special_commission', function ( Charter $charter ) {
				return '<a href="' . route( 'charterCommission', [ 'charter' => $charter->id ] ) . '" class="btn btn-brand btn-sm">Special Commission</a>';
			} )
			->addColumn( 'seats', function ( Charter $charter ) {
				return 'E:' . $charter->economy_seats . ' | B:' . $charter->business_seats;
			} )
			->addColumn( 'locked_seats', function ( Charter $charter ) {
                return '<a href="' . route( 'charterLocked', [ 'charter' => $charter->id ] ) . '" class="btn btn-info btn-sm">Locked Seats</a>';
			} )
			->addColumn( 'aircraft_id', function ( Charter $charter ) {
                return $charter->aircraft->name;
            } )
            ->addColumn( 'Copy_Flight', function ( Charter $charter ) {
                return \Form::open(array('route' => array('charterCopy', $charter->id)))."
                <input type='date' name='copyDate'/>
                    <button type='submit' class='btn btn-success'>Copy Flight</button>
                ".\Form::close();
			} )
			->addColumn( 'actions', function ( Charter $charter ) {
				return '<a href="' . route( 'charterOrders', [ 'charter' => $charter->id ] ) . '" class="btn btn-success btn-sm">PASSENGERS</a>
                            <a href="' . route( 'editCharter', [ 'charter' => $charter->id ] ) . '" class="btn btn-info btn-sm">Edit</a>
                            <a href="' . route( 'charterPricing', [ 'charter' => $charter->id ] ) . '" class="btn btn-warning btn-sm">Pricing</a>
                            <button data-url="' . route( 'deleteCharter', [ 'charter' => $charter->id ] ) . '" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-charter"><i class="fa fa-trash" style="font-size: 14px;"></i></button>
                            <a href="' . route( 'lockCharter', [ 'charter' => $charter->id ] ) . '" class="btn btn-brand btn-sm"><i class="fa fa-' . ( $charter->locked ? 'unlock' : 'lock' ) . '"></i> ' . ( $charter->locked ? 'Unlock' : 'Lock' ) . '</a>';
			} )
			->editColumn( 'economy_seats', function ( Charter $charter ) {
                // Economy seats
                $seats = $charter->prices()->where('flight_class','Economy')->sum('seats');
                $soldSeats = $charter->prices()->where('flight_class','Economy')->sum('available_seats');
              $stats = [];
              
              $stats['sold_economy_seats'] = 0;
		$economy_orders              = $charter->orders()->where( 'status', '!=', 'cancelled' )->where( 'flight_class', 'Economy' )->get();
		foreach ( $economy_orders  as $economy_order ) {
			$stats['sold_economy_seats'] += $economy_order->passengers()->count();
		}

                return $seats ? "<ul><li title='Booked'>" . ( $stats['sold_economy_seats'] ) . "</li><li title='Available'>" . ( $soldSeats ) . "</li><li title='All Seats'>{$seats}</li></ul>" : 0;

			})
			->editColumn( 'business_seats', function ( Charter $charter ) {
                // Business seats
                // $seats = $charter->business_seats;
                $seats = $charter->prices()->where('flight_class','Business')->sum('seats');
                $soldSeats = $charter->prices()->where('flight_class','Business')->sum('available_seats');
                return $seats ? "<ul><li title='Booked'>" . ( $seats - $soldSeats ) . "</li><li title='Available'>" . ( $soldSeats ) . "</li><li title='All Seats'>{$seats}</li></ul>" : 0;

            } )
			->editColumn( 'commission', function ( Charter $charter ) {
				return $charter->commission . ( $charter->is_percent ? '%' : '$' );
			} )
			->editColumn( 'flight_type', function ( Charter $charter ) {
				return $charter->flight_type == "RoundTrip" ? "Round Trip" : "One Way";
			} )
			->rawColumns( [ 'special_commission', 'locked_seats', 'Copy_Flight', 'actions', 'economy_seats', 'business_seats' ] )
			->filter( function ( $query ) {
				if ( request( 'flight_type' ) ) {
					$query->where( 'flight_type', request( 'flight_type' ) );
				}

				if ( request( 'from_date' ) ) {
					$query->where( 'flight_date', '>=', request( 'from_date' ) );
				}

				if ( request( 'to_date' ) ) {
					$query->where( 'flight_date', '<=', request( 'to_date' ) );
				}
			}, true )
			->make();
	}

	public function show( Charter $charter ) {
		Session::flash( 'sidebar', 'charter' );

		return response()->json( [ 'status' => 'success', 'charter' => $charter ] );
	}

	public function create() {
		Session::flash( 'sidebar', 'charter' );
		$countries = Country::all();
		$aircrafts = Aircraft::all();

		return view( 'admin.charter.create', compact( 'countries', 'aircrafts' ) );
	}
	
	public function dateRange($begin, $end, $interval = null)
    {
      $begin = new \DateTime($begin);
      $end = new \DateTime($end);
    
      $end = $end->modify('+1 day');
      $interval = new \DateInterval($interval ? $interval : 'P1D');
    
      return iterator_to_array(new \DatePeriod($begin, $interval, $end));
    }
    
    public function daysR($days,$dates)
    {
        $weekendss=[];
      foreach($days as $key => $val){
          if($val=='monday'){
              $weekends = array_filter($dates, function ($date) {
                  return $date->format("N") === '1';
                });
                $weekendss=array_merge($weekendss,$weekends);
          }elseif($val=='tuesday'){
              $weekends = array_filter($dates, function ($date) {
                  return $date->format("N") === '2';
                });
                $weekendss=array_merge($weekendss,$weekends);
          }elseif($val=='wednesday'){
              $weekends = array_filter($dates, function ($date) {
                  return $date->format("N") === '3';
                });
                $weekendss=array_merge($weekendss,$weekends);
          }elseif($val=='thursday'){
              $weekends = array_filter($dates, function ($date) {
                  return $date->format("N") === '4';
                });
                $weekendss=array_merge($weekendss,$weekends);
          }elseif($val=='friday'){
              $weekends = array_filter($dates, function ($date) {
                  return $date->format("N") === '5';
                });
                $weekendss=array_merge($weekendss,$weekends);
          }elseif($val=='saturday'){
              $weekends = array_filter($dates, function ($date) {
                  return $date->format("N") === '6';
                });
                $weekendss=array_merge($weekendss,$weekends);
          }elseif($val=='sunday'){
              $weekends = array_filter($dates, function ($date) {
                  return $date->format("N") === '7';
                });
                $weekendss=array_merge($weekendss,$weekends);
          }
      }
      return $weekendss;
    }

	public function store( Request $request ) {
	    $allData=$request->all();
	    
		$charter = Charter::create($allData);
		$days=$request->get("frequent_days");
		$from=$request->get("frequent_from_date");
		$to=$request->get("frequent_to_date");
		
		if(isset($days,$from,$to)){
		    $x=0;
		    $dates = $this->dateRange($from, $to);
		    
		    $weekends=$this->daysR($days,$dates);
		    foreach($weekends as $perDay){
		        $allData['flight_date']=$perDay->format("Y-m-d");
              $allData['arrival_day']=$perDay->format("Y-m-d");
		        $charter = Charter::create($allData);
		    }
		}
		
		if ( $request->post( 'flight_type' ) == "RoundTrip" ) {
			$charter->roundtrip->create( [
				'flight_number'  => $request->post( '2way_flight_number' ),
				'flight_date'    => $request->post( '2way_flight_date' ),
				'departure_time' => $request->post( '2way_departure_time' ),
				'arrival_time'   => $request->post( '2way_arrival_time' ),
              'arrival_day'   => $request->post( 'arrival_day' ),
				'charter_id'     => $charter->id,
			] );
		}

		return redirect()->back()->with( [ 'success' => 'Charter Created Successfully.' ] );
	}


	public function edit( Charter $charter, Builder $builder ) {
		Session::flash( 'sidebar', 'charter' );
		$countries = Country::all();
		$aircrafts = Aircraft::all();

		$pricing = [
			[ "title" => "Economy", "special" => "One Way", "name" => "price_[age]" ],
			[ "title" => "Economy", "special" => "Two Way", "name" => "price_[age]_2way" ],
			[ "separator" => true ],
			[ "title" => "Business", "special" => "One Way", "name" => "business_[age]" ],
			[ "title" => "Business", "special" => "Two Way", "name" => "business_2way_[age]" ],
			[ "separator" => true ],
			[ "title" => "Open Return Economy", "special" => "1 Month", "name" => "open_return_1month_[age]" ],
			[ "title" => "Open Return Economy", "special" => "3 Month", "name" => "open_return_3month_[age]" ],
			[ "title" => "Open Return Economy", "special" => "6 Month", "name" => "open_return_6month_[age]" ],
			[ "title" => "Open Return Economy", "special" => "1 Year", "name" => "open_return_12month_[age]" ],
			[ "separator" => true ],
			[
				"title"   => "Open Return Business",
				"special" => "1 Month",
				"name"    => "open_return_business_1month_[age]"
			],
			[
				"title"   => "Open Return Business",
				"special" => "3 Month",
				"name"    => "open_return_business_3month_[age]"
			],
			[
				"title"   => "Open Return Business",
				"special" => "6 Month",
				"name"    => "open_return_business_6month_[age]"
			],
			[
				"title"   => "Open Return Business",
				"special" => "1 Year",
				"name"    => "open_return_business_12month_[age]"
			],
		];

		$ages = [ "adult", "child", "baby" ];

		return view( 'admin.charter.update', compact( 'charter', 'countries', 'aircrafts', 'ages', 'pricing' ) );
	}

	public function update( Charter $charter, Request $request ) {
     // dd($request->arrival_day);
      //dd($request->all());
      $request->arrival_day = \Carbon\Carbon::parse($request->arrival_day)->format("D, d M, Y");
		$charter->update( $request->all() );
        // dd($charter);
		if ( $request->post( 'flight_type' ) == "RoundTrip" ) {
			$data = [
				'flight_number'  => $request->post( '2way_flight_number' ),
				'flight_date'    => $request->post( '2way_flight_date' ),
				'departure_time' => $request->post( '2way_departure_time' ),
				'arrival_time'   => $request->post( '2way_arrival_time' ),
              'arrival_day'   => $request->post( 'arrival_day' ),
				'charter_id'     => $charter->id,
			];


			$charter->roundtrip ? $charter->roundtrip->update( $data ) : $charter->roundtrip()->create( $data );
		} else {
			$charter->roundtrip ? $charter->roundtrip->delete() : false;
		}


		return redirect()->back()->with( [ 'success' => 'Charter Updated Successfully.' ] );
	}

	public function lockCharter( Charter $charter ) {
		$message = $charter->locked == 1 ? 'Charter UnLocked Successfully.' : 'Charter Locked Successfully.';

		$charter->locked = $charter->locked == 1 ? 0 : 1;
		$charter->save();

		return redirect()->route( 'listCharter' )->with( [ 'success' => $message ] );
    }
    
    public function charterCopy( Charter $charter , Request $request) {
        $newCharter=new Charter();
        $newCharter=$charter->replicate();
        $newCharter->flight_date=$request->copyDate;
        // return $newCharter;
        $newCharter->save();
        // dd($newCharter);
        // Charter::create();
		return redirect()->route( 'listCharter' )->with( [ 'success' => 'Charter Copied Successfully.' ] );
	}

	public function destroy( Charter $charter ) {
		$charter->delete();

		return redirect()->route( 'listCharter' )->with( [ 'success' => 'Charter Deleted Successfully.' ] );
	}

	############### Commission ###########################
	public function commission( Charter $charter ) {
		$excluded  = SpecialCommission::where( 'charter_id', $charter->id )->pluck( 'user_id' );
		$companies = User::whereNotIn( 'id', $excluded )->get();

		return view( 'admin.charter.commission', compact( 'charter', 'companies' ) );
	}

	public function storeCommission( Charter $charter, Request $request ) {
		SpecialCommission::create( $request->all() );

		return redirect()->back()->with( [ 'success' => 'Commission has been added Successfully.' ] );
	}

	public function commissionData( Datatables $datatables, Charter $charter, Request $request ) {
		$builder = SpecialCommission::where( 'charter_id', $charter->id )->orderBy( 'id', 'desc' );

		return $datatables
			->of( $builder )
			->editColumn( 'user_id', function ( SpecialCommission $commission ) {
				return User::find( $commission->user_id )->name;
			} )
			->editColumn( 'commission', function ( SpecialCommission $commission ) {
				return $commission->commission . ( $commission->is_percent ? '%' : '$' );
			} )
			->addColumn( 'actions', function ( SpecialCommission $commission ) use ( $charter ) {
				return '<button data-url="' . route( 'deleteCommission', [
						'charter'    => $charter->id,
						'commission' => $commission->id
					] ) . '" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-commission"><i class="fa fa-trash" style="font-size: 14px;"></i></button>';
			} )
			->rawColumns( [ 'actions' ] )
			->make();
	}

	public function deleteCommission( Charter $charter, SpecialCommission $commission ) {
		$commission->delete();

		return redirect()->back()->with( [ 'success' => 'Commission has been deleted Successfully.' ] );
	}

	############### End Commission ###########################

	############### Locked ###########################

	public function locked( Charter $charter ) {
		$companies = User::all();

		return view( 'admin.charter.locked', compact( 'charter', 'companies' ) );
	}

	public function storeLocked( Charter $charter, Request $request ) {
        
        $seatsEdit=CharterPrice::where('charter_id',$request->get('charter_id'))->where('flight_class',$request->flight_class)->get();
		if(($seatsEdit->isEmpty()) || ($seatsEdit->sum('available_seats')< (int)$request->seats)){
            return redirect()->back()->with( [ 'fail' => 'there is no such that flight class in this charter or no enough available seats.' ] );
        }
		$reqSeats=(int)$request->seats;
		$lockCheck=Locked::where('user_id',$request->user_id)->where('charter_id',$request->charter_id)->where('seat_price',$request->seat_price)->get();
		if($lockCheck->isEmpty()){
		    Locked::create( $request->all() );
		}else{
		    $lockCheck[0]->seats+=$reqSeats;
		    $lockCheck[0]->price+=$request->price;
		    $lockCheck[0]->save();
		}
        
        
        
        foreach($seatsEdit as $seat){
    		if($seat->available_seats >= $reqSeats){
    		  //  dd($reqSeats);
    		    $seat->available_seats-=$reqSeats;
    		    $seat->save();
    		    break;
    		}else{
                $reqSeats-= $seat->available_seats;
    		    $seat->available_seats=0;
    		    $seat->save();
    		}
        }
		
		// Save to transactions
		$price       = $request->price;
		$user        = User::find( $request->user_id );
		$new_balance = $user->balance - $price;
		$user->userTransactions()->create( [
			'to'             => $user->id,
			'amount'         => $price,
			'comment'        => "Charter Locked Seats",
			'type'           => "withdrawal",
			'creditBefore'   => $user->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $charter->id,
			'connectedTable' => 'charter'
		] );

		$user->update( [ 'balance' => $new_balance ] );

		return redirect()->back()->with( [ 'success' => 'Locked seats have been added successfully.' ] );
	}

	public function lockedData( Datatables $datatables, Charter $charter, Request $request ) {
		$builder = Locked::where( 'charter_id', $charter->id )->orderBy( 'id', 'desc' );

		return $datatables
			->of( $builder )
			->editColumn( 'user_name', function ( Locked $commission ) {
				return User::find( $commission->user_id )->name;
			} )
			->addColumn( 'actions', function ( Locked $locked ) use ( $charter ) {
				return '<a href="#" class="subtract-seats btn btn-danger btn-sm" data-id="' . $locked->id . '" data-single="' . $locked->seat_price . '" data-total="' . $locked->price . '" data-seats="' . $locked->seats . '">Subtract Seats</a>';
			} )
			->rawColumns( [ 'actions' ] )
			->make();
	}

	public function deleteLocked( Charter $charter, Locked $locked, Request $request ) {
		$seats = $locked->seats - $request->seats;
		$price = $locked->price - $request->price;

		if ( $seats == 0 ) {
			$locked->delete();
		} else {
			$locked->update( [
				"seats" => $seats,
				"price" => $price,
			] );
		}

		// Save to transactions
		$price       = $request->price;
		$user        = User::find( $locked->user_id );
		$new_balance = $user->balance - $price;
		$user->userTransactions()->create( [
			'to'             => $user->id,
			'amount'         => $price,
			'comment'        => "Subtract Charter Locked Seats",
			'type'           => "DepositOfCredit",
			'creditBefore'   => $user->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $charter->id,
			'connectedTable' => 'charter'
		] );

		$user->update( [ 'balance' => $new_balance ] );

		return redirect()->back()->with( [ 'success' => 'Locked seats has been subtracted Successfully.' ] );
	}

	################## End Locked #################
	public function prices( Charter $charter ) {
		return view( 'admin.charter.prices', compact( 'charter' ) );
	}

	################## Orders #################
	public function charterOrders( Charter $charter, CharterOrders $order, Request $request ) {
		$stats = [];
		$users = User::whereIn( 'id', $charter->orders()->pluck( 'user_id' ) )->get();

		// Economy seats
		$stats['total_economy_seats'] = $charter->economy_seats;

		$stats['sold_economy_seats'] = $charter->business_seats ;
		$economy_orders              = $charter->orders()->where( 'status', '!=', 'cancelled' )->where( 'flight_class', 'Economy' )->get();
		foreach ( $economy_orders  as $economy_order ) {
			$stats['sold_economy_seats'] += $economy_order->passengers()->count();
		}

		// Business seats
		$stats['total_business_seats'] = 0;

		$stats['sold_business_seats'] = 0;
		$business_orders              = $charter->orders()->where( 'status', '!=', 'cancelled' )->where( 'flight_class', 'Business' )->get();
		foreach ( $business_orders as $business_order ) {
			$stats['sold_business_seats'] += $business_order->passengers()->count();
		}

		// Amount
		$stats['total_amount']     = $charter->orders()->where( 'status', '!=', 'cancelled' )->sum( 'price' );
		$stats['total_commission'] = $charter->orders()->where( 'status', '!=', 'cancelled' )->sum( 'commission' );
		$stats['total_profit']     = $stats['total_amount'] - $stats['total_commission'];

		//dd($charter , $stats , $users);
		return view( 'admin.orders.charter.charter', compact( 'charter', 'stats', 'users' ) );
	}

	public function charterOrdersData( Datatables $datatables, Charter $charter, Request $request ) {
		$builder = $charter->orders()->orderBy( 'id', 'DESC' )->get();

		return $datatables
			->of( $builder )
			->editColumn( 'name', function ( CharterOrders $order ) {
				return $order->charter->name;
			} )
			->editColumn( 'date', function ( CharterOrders $order ) {
				return $order->charter->flight_date;
			} )
			->editColumn( 'status', function ( CharterOrders $order ) {
				return ucfirst( $order->status );
			} )
			->editColumn( 'flight_type', function ( CharterOrders $order ) {
				$type = "One Way";
				if ( $order->flight_type == "RoundTrip" ) {
					$type = "Round Trip";
				}
				if ( $order->flight_type == "OpenReturn" ) {
					$type = "Open Return";
				}

				return $type;
			} )
			->editColumn( 'flights', function ( CharterOrders $order ) {
				return '<button class="btn btn-sm btn-accent show-flights" data-id="' . $order->id . '"><strong>(' . $order->flights()->count() . ')</strong> <i class="fa fa-plane" style="top: 2px;position: relative;left: 2px;"></i></button>';
			} )
			->editColumn( 'user_id', function ( CharterOrders $order ) {
				return $order->user->name;
			} )
			->addColumn( 'passengers', function ( CharterOrders $order ) use ( $charter ) {
				return '<span class="btn btn-success btn-sm">(' . $order->passengers()->count() . ') Passengers</span> <a href="' . route( 'download-charter-ticket', [ 'pnr' => $order->pnr ] ) . '" class="btn btn-brand btn-sm"><i class="fa fa-ticket" style="font-size: 14px;"></i></a> <a href="' . route( 'charterOrdersDownload', [ 'charter' => $charter->id ] ) . '?order=' . $order->id . '" class="btn btn-brand btn-sm"><i class="fa fa-download" style="font-size: 14px;"></i></a>
                <a target="_blank" href="' . route( 'charterDetails', ['order' => $order->id] ) .'?eye=1' . '" class="btn btn-info btn-sm"><i class="fa fa-eye" style="font-size: 14px;"></i> &nbsp; details</a>';
			} )
			->addColumn( 'actions', function ( CharterOrders $order ) use ( $charter ) {
				$buttons[] = '<a href="' . route( 'editCharterOrder', [
						'charter' => $charter->id,
						'order'   => $order->id
					] ) . '" class="btn btn-info btn-sm">Edit</a> ';
				if ( $order->status != "cancelled") {
					$buttons[] = '<button data-href="' . route( 'cancel-charter-ticket', [
							'charter' => $charter->id,
							'order'   => $order->id
						] ) . '" class="confirm-cancel btn btn-danger btn-sm" data-id="' . $order->id . '" data-text="refund" data-title="Cancel Order">Cancel</i></button>';
				}

				if ( $order->flights()->onlyTrashed()->count() > 0 ) {
					$buttons[] = '<button data-href="' . route( 'rebook-charter-ticket', [
							'charter' => $charter->id,
							'order'   => $order->id,
						] ) . '" class="confirm-cancel rebook-order btn btn-success btn-sm ml-1" data-id="' . $order->id . '" data-text="rebook" data-title="Rebook Order">ReBook</i></button>';
				}

				return join( $buttons );
			} )
			->rawColumns( [ 'actions', 'passengers', 'flights' ] )
			->make();
	}

	public function charterPassengersData( Datatables $datatables, Charter $charter, CharterOrders $order ) {
		$builder = $order->passengers()->orderBy( 'id', 'DESC' )->get();

		return $datatables
			->of( $builder )
			->addColumn( 'actions', function ( CharterPassengers $passenger ) use ( $charter, $order ) {
				return '<a href="' . route( 'editCharterOrder', [
						'charter'                => $charter->id,
						'order'                  => $order->id,
						'passenger' => $passenger->id
					] ) . '" class="btn btn-info btn-sm">Edit</a>
                            <button data-url="' . route( 'deleteCharter', [ 'charter' => $passenger->id ] ) . '" class="delete-modal btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-charter" hidden><i class="fa fa-trash" style="font-size: 14px;"></i></button>';
			} )
			->addColumn( 'check', function ( CharterPassengers $passenger ) use ( $charter, $order ) {
				return '<label class="mt-checkbox mt-checkbox-outline"><input type="checkbox" name="selected_passengers" value="' . $passenger->id . '" /><span></span></label>';
			} )
			->rawColumns( [ 'actions', 'check' ] )
			->make();
	}

	public function charterOrderFlights( Request $request ) {
		$order   = $request->get( 'order' );
		$flights = CharterOrderFlights::where( 'order_id', $order )->with( 'charter' )->get();

		return json_encode( $flights );
	}

	public function charterOrdersDownload( Charter $charter, Request $request ) {
		$order_id = $request->get( 'order' );
		$user     = $request->get( 'user' );

		if ( $order_id ) {
			$order    = CharterOrders::find( $order_id );
			$download = ( new ExportSingleOrder( $order ) );
		} else {
			$download = ( new DownloadExport( $charter, $user ) );
		}

		return $download->download( 'PassengersData.xlsx' );
	}
	################## End Orders ###############

	/**
	 * @param Charter $charter
	 * @param CharterOrders $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function changeCharterStatus( Charter $charter, CharterOrders $order, Request $request ) {
		if ( $order->status !== 'rejected' ) {
			$this->validate( $request, [
				'pdf' => 'required|mimes:pdf'
			], [
				'pdf.mimes' => 'Charter document must be a file of type: pdf.'
			] );

			$pdf = Storage::disk( 'public' )->put( 'charter/pdf', $request->file( 'pdf' ) );

			$order->update( [ 'status' => '1', 'delivered_by' => Auth::user()->id, 'charter_pdf' => $pdf ] );

			Notification::send( User::find( $order->user_id ), new Notifier( [
				'message' => 'your charter ticket has been delivered',
				'url'     => route( 'listUserCharters' )
			], 'Charter Ticket Request' ) );
		} else {
			return redirect()->back()->with( [ 'fail' => 'charter already rejected!' ] );
		}

		return redirect()->back()->with( [ 'success' => 'charter approved successfully!' ] );
	}

	public function rebookCharterTicket( Charter $charter, Request $request ) {
		$order_id = $request->get( 'order' );
		$order    = CharterOrders::find( $order_id );
		$amount   = $request->post( "amount" );

		foreach ( $order->cancelledFlights as $flight ) {
			$flight->restore();

			// Remove flights from passengers related
			CharterPassengersRelated::where( [
				'order_id'  => $order_id,
				'flight_id' => $flight->id
			] )->restore();
		}

		$order->update( [ 'status' => 'awaiting', 'delivered_by' => Auth::user()->id ] );

		// Save to transactions
		$user        = User::find( $order->user_id );
		$new_balance = $user->balance - $amount;
		$user->userTransactions()->create( [
			'to'             => $user->id,
			'amount'         => $amount,
			'comment'        => "Charter ReBook",
			'type'           => "withdrawal",
			'creditBefore'   => $user->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $order->id,
			'pnr'            => $order->pnr,
			'connectedTable' => 'charter'
		] );

		$user->update( [ 'balance' => $new_balance ] );

		return redirect()->back()->with( [ 'success' => 'Charter ticket has been re-booked!' ] );
	}

	public function cancelCharterTicket( Charter $charter, Request $request ) {

		$order_id    = $request->get( 'order' );
		$order       = CharterOrders::findOrCreate( $order_id );
		$isCancelled = $order->status == "Cancelled";

		$cancel_all = $request->post( "cancel_all" );

		$amount = $request->post( "amount" );

		$flights = $request->post( 'flights' );
      

		if ( $cancel_all == 1 ) {
			foreach ( $order->flights as $flight ) {
              

                $editSeats=   $flight->charter->prices()
                                      ->where('flight_class',$order->flight_class)
                                     //->where('price_adult_1',($order->passengerRelated)[0]->price)
                                     // ->whereNotNull('price_adult_1')
                                       ->get();
              


              
              // $editSeats1 =   $flight->charter->prices()
                                  //    ->where('price_adult_1',($order->passengerRelated)[0]->price)
                                //->get();
              if($editSeats->isEmpty()){
                DB::table('charter_price')->insert([
                  'charter_id' => $flight->charter->id,
                  'flight_class' => $order->flight_class,
                  'price_adult_1' => ($order->passengerRelated)[0]->price,
                  'price_class' => 'C1',
                ]);
                
                $editSeats=   $flight->charter->prices()
                                      ->where('flight_class',$order->flight_class)
                                     ->where('price_adult_1',($order->passengerRelated)[0]->price)
                                       ->get()[0];
              }
              {
                $editSeats->where('flight_class',$order->flight_class);
                $editSeats = $editSeats[0];
              }
              
                $editSeats->available_seats+=1;
                $editSeats->save();
                
                $flight->delete();
				// Remove flights from passengers related
				CharterPassengersRelated::where( [
					'order_id'  => $order_id,
					'flight_id' => $flight->id
				] )->delete();
			}

			$order->update( [
			    'price'=>$order->price-$amount,
				'status'       => $isCancelled ? 'Confirmed' : 'Cancelled',
				'delivered_by' => Auth::user()->id
			] );
		} else {
			if ( count( $flights ) > 0 ) {
              
            //    dd($flights);
				foreach ( $order->flights as $flight ) {
                  
				    // $editSeats=$flight->charter->prices()->where('flight_class',$order->flight_class)->where('price_adult_1',($order->passengerRelated)[0]->price)->get()[0];
                  
                     $editSeats=   $flight->charter->prices()
                                      ->where('flight_class',$order->flight_class)
                                     //->where('price_adult_1',($order->passengerRelated)[0]->price)
                                     ->whereNotNull('price_adult_1')
                                       ->get()[0];
                    $editSeats->available_seats  +=1;
                    $editSeats->save();
				    
					// Remove flights from order flights
					CharterOrderFlights::where( [
						'order_id'   => $order_id,
						'charter_id' => $flight
					] )->delete();

					// Remove flights from passengers related
					CharterPassengersRelated::where( [
						'order_id'  => $order_id,
						'flight_id' => $flight
					] )->delete();
				}
				$order->update(['price' => $order->price-$amount]);
			}
		}

		// Save to transactions
		$user        = User::find( $order->user_id );
		$new_balance = ( $user->balance + $amount ) - $order->commission;
		$user->userTransactions()->create( [
			'to'             => $user->id,
			'amount'         => $amount,
			'comment'        => "Refund charter",
			'type'           => "DepositOfCredit",
			'creditBefore'   => $user->balance,
			'creditAfter'    => $new_balance,
			'connectedID'    => $order->id,
			'pnr'            => $order->pnr,
			'connectedTable' => 'charter'
		] );

		$user->update( [ 'balance' => $new_balance ] );

		return redirect()->back()->with( [ 'success' => 'Charter ticket has been cancelled!' ] );
	}

	/**
	 * @param Charter $charter
	 * @param CharterOrders $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function changeCharterStatusToReject( Charter $charter, CharterOrders $order ) {
		if ( $order->status === '0' || $order->status === 'received' ) {
			$order->update( [ 'status' => 'rejected' ] );

			Notification::send( User::find( $order->user_id ), new Notifier( [
				'message' => 'your charter ticket request has been rejected',
				'url'     => route( 'listUserCharters' )
			], 'Charter Ticket Request' ) );
		} else {
			return redirect()->back()->with( [ 'fail' => 'charter already submitted!' ] );
		}

		return redirect()->back()->with( [ 'success' => 'charter rejected successfully!' ] );
	}

	/**
	 * @param Charter $charter
	 * @param CharterOrders $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function changeCharterStatusToReceive( Charter $charter, CharterOrders $order ) {
		if ( $order->status === '0' ) {
			$order->update( [ 'status' => 'received' ] );

			Notification::send( User::find( $order->user_id ), new Notifier( [
				'message' => 'your charter ticket request has been received',
				'url'     => route( 'listUserCharters' )
			], 'Charter Ticket Request' ) );
		} else {
			return redirect()->back()->with( [ 'fail' => 'charter already submitted!' ] );
		}

		return redirect()->back()->with( [ 'success' => 'charter canceled successfully!' ] );
	}

	public function editCharterOrder( Charter $charter, CharterOrders $order, Request $request ) {
		$countries = Nationality::all();

		$isEdit    = false;
		$passenger = CharterPassengers::first();
            $passenger11 =  CharterPassengers::first();


		if ( $request->get( 'passenger' ) ) {
			$isEdit    = true;
			$passenger = CharterPassengers::find( $request->get( 'passenger' ) );
                $passenger11 =  CharterPassengers::find( $request->get( 'passenger' ) );

		}

		if ( $request->get( 'do' ) == "split" ) {
			$passengers = $request->get( "passengers" );

			if ( ! $passengers or count( $passengers ) == 0 ) {
				return 'Error';
			}

			$pnr = generatePNR();

			$newOrder      = $order->replicate();
			$newOrder->pnr = $pnr;
			$newOrder->save();

			$price = 0;
			foreach ( $passengers as $passenger_id ) {
				$passenger           = CharterPassengers::find( $passenger_id );
				$passenger->order_id = $newOrder->id;
				$passenger->save();

				$passengerRelated           = $order->passengerRelated()->where( 'passenger_id', $passenger_id );
				$passengerRelated->update([
					'order_id' => $newOrder->id
				]);

				$price += $passenger->price;
			}
          $order->update( [
				'price' => $order->price - $price
			] );

			$newOrder->update( [
				'price' => $price
			] );

			foreach ( $order->flights as $flight ) {
				$newFlight           = $flight->replicate();
				$newFlight->order_id = $newOrder->id;
				$newFlight->save();
			}

			

			Session::flash( 'success', 'Passenger has been transferred to new order successfully with PNR: ' . $pnr );

			return 'Done';
		}

		return view( 'admin.orders.charter.edit', compact( 'charter', 'order', 'countries', 'isEdit', 'passenger', 'passenger11' ) );
	}

	/**
	 * @param Charter $charter
	 * @param CharterOrders $order
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function editOrder( Charter $charter, CharterOrders $order, Request $request ) {
		$do      = $request->post( "do" );
		$message = '';

		if ( $do == "modify" ) {
			$cancel = $request->get( "cancel" ) == "yes";
             $order = User::firstOrNew($id );
			if ( $cancel ) {
				$message = 'Order has been cancelled successfully!';
				
                
                $order->status = "status";
                 $order->expire_at = "null";
                $order->save();
           

				return redirect()->route( 'charterOrders', [
					'charter' => $charter->id
				] )->with( [ 'success' => $message ] );
			} else {
				$message = 'Time limit has been modified successfully!';

				$add      = $request->get( "add" );
				$subtract = $request->get( "subtract" );

				$newTime = $order->expire_at;

				if ( $add > 0 ) {
					$newTime = $order->expire_at->addHours( $add );
				}
				if ( $subtract > 0 ) {
					$newTime = $order->expire_at->subHours( $add );
				}

               $order->expire_at = $newTime;
                $order->save();
			}

		}

		if ( $do == "passenger" ) {
			$message   = 'Passenger details has been updated successfully!';
			$passenger = CharterPassengers::find( $request->post( 'passenger' ) );
			$passenger->update( $request->all() );
		}

		if ( $do == "change" ) {
			$message = 'Order details has been updated successfully!';

			$newClass   = $request->post( "flight_class" );
			$flights    = $order->flights;
			$passengers = $order->passengers;

			$price = 0;

			foreach ( $flights as $flight ) {
				if ( $request->post( "flight_" . $order->charter_id ) == $request->post( "flight_" . $flight->charter_id ) ) {
					$order->charter_id = $request->post( "flight_" . $flight->charter_id );
				}

				$flight->charter_id = $request->post( "flight_" . $flight->charter_id );
				$flight->save();
			}

			foreach ( $passengers as $passenger ) {
				$flight_price = floatval( $request->post( "modified_price_" . $passenger->id ) );
				$price        += $flight_price;

				// Change passenger price
				$modifiedPassenger        = CharterPassengers::find( $passenger->id );
				$modifiedPassenger->save();
			}

			// Change order price
			$order->price        = $price;
			$order->flight_class = $newClass;
			$order->save();
		}

		return redirect()->route( 'editCharterOrder', [
			'charter' => $charter->id,
			'order'   => $order->id
		] )->with( [ 'success' => $message ] );
	}
  
  
 
 
}

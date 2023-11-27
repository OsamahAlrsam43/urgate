<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Notifications\Notifier;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class UsersController extends Controller {
	/**
	 * UsersController constructor.
	 */
	public function __construct() {
		$this->middleware( [ 'auth', 'dashboardAccess' ] );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		Session::flash( 'sidebar', 'users' );
		$users = User::where( 'id', '!=', 1 )->orderBy( 'id', 'DESC' )->get();

		return view( 'admin.user.index', compact( 'users' ) );
	}

	public function usersData( Datatables $datatables, Request $request ) {
		$builder = User::where( 'id', '!=', 1 )->where("parent", 0)->orderBy( 'id', 'desc' );

		if (\auth()->user()->type == 'GSA')$builder = User::where( 'id', '!=', 1 )->where("parent",\auth()->user()->id)->orderBy( 'id', 'desc' );
        
         
		return $datatables
			->of( $builder )
          
         
			->addColumn( 'actions', function ( User $user ) {
              
               if(! Auth::user()->type === 'GSA' ){
                 return '<a href="'.route('editUser',['user' => $user->id]) .'"
                               class="btn btn-brand m-btn btn-sm m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
                                <i class="fa flaticon-edit-1"></i>
                            </a>
                            
							<a href="'.route('deleteUser',['user' => $user->id]) .'" 
							class="link-confirm btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                <i class="fa flaticon-delete"></i>
                            </a>';
                 
               }else{
                 return '<a href="'.route('editUser',['user' => $user->id]) .'"
                               class="btn btn-brand m-btn btn-sm m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
                                <i class="fa flaticon-edit-1"></i>
                            </a>';
                 
               }
				
			} )
          
			->editColumn( 'balance', function ( User $user ) {
				return '<button class="btn btn-success btn-sm add-credit" data-link="'.route('userAddAmount',['user' => $user->id]).'">$'.number_format($user->balance, 2).'</button>';
			} )
			->addColumn( 'employees', function ( User $user ) {
				return '<a href="' . route( 'userEmployee', [ 'user' => $user->id ] ) . '" class="btn btn-info btn-sm">Employees</a>';
			} )
			->addColumn( 'GSA-List', function ( User $user ) {
				if ( $user->type == 'GSA' ) {
					return '<a href="' . route( 'gsaList', [ 'user' => $user->id ] ) . '" class="btn btn-info btn-sm">GSA List</a>';
				}else{
					return "----";
				}
			} )
			->addColumn( 'transactions', function ( User $user ) {
				return '<a href="' . route( 'userTransactions', [ 'user' => $user->id ] ) . '" class="btn btn-info btn-sm">Transactions</a>';
			} )
			->addColumn( 'orders', function ( User $user ) {
				return '<div class="btn-group">
						  <button type="button" class="btn btn-brand btn-sm dropdown-toggle" 
						  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Orders</button>
						  <div class="dropdown-menu">
						    <a class="dropdown-item" href="' . route( 'userTravelOrders', [ 'user' => $user->id ] ) . '">Travel Orders</a>
						    <a class="dropdown-item" href="' . route( 'userFlightOrders', [ 'user' => $user->id ] ) . '">Flights Orders</a>
						    <a class="dropdown-item" href="' . route( 'userVisaOrders', [ 'user' => $user->id ] ) . '">Visa Orders</a>
						  </div> 
						</div>';
			} )
			->addColumn( 'activation', function ( User $user ) {
				if ( $user->type == 'Super Admin' ) {
					return $user->type;
				}

				return '<a href="' . route( 'userActivation', [ 'user' => $user->id ] ) . '"
                                   class="btn-sm btn btn-' . ( $user->activation === '0' ? 'brand' : 'danger' ) . ' link-confirm">
                                    ' . ( $user->activation === '0' ? 'Approve' : 'Disapprove' ) . '
                                </a>';
			} )
			->rawColumns( [ 'actions', 'employees', 'GSA-List', 'activation', 'orders', 'transactions', 'balance' ] )
			->make();
	}

	public function employeesData( Datatables $datatables, Request $request ) {
		$parent = User::find($request->get('id'));
		$builder = User::where( 'parent', $parent->id )->orderBy( 'id', 'desc' );

		return $datatables
			->of( $builder )
			->addColumn( 'actions', function ( User $user ) use ($parent) {
				return '<a href="' . route( 'userEmployee', [ 'user' => $parent, 'id' => $user->id ] ) . '" class="btn btn-info btn-sm">Edit</a>
               <a href="' . route( 'deleteEmployee', [ 'user' => $user->id ] ) . '" class="link-confirm btn btn-danger btn-sm"><i class="fa fa-trash" style="font-size: 14px;"></i></a>';
			} )
			->rawColumns( [ 'actions' ] )
			->make();
	}

	public function userEmployee(User $user, Request $request) {
		Session::flash( 'sidebar', 'users' );

		$employee = new \stdClass();
		$employee->id = null;
		$employee->name = null;
		$employee->email = null;

		if($request->has("id")) {
			$employee = User::find($request->get("id"));
		}

		return view( 'admin.user.employees', compact('user', 'employee') );
	}

	public function gsaList(User $user, Request $request) {
		$builder = User::where( 'id', '!=', 1 )->where("parent", $user->id)->orderBy( 'id', 'desc' )->get();
		$gsa = User::where( 'id', '!=', 1 )->where("type", "GSA")->orderBy( 'id', 'desc' )->get();

		return view( 'admin.user.gsaList', compact('builder','gsa') );
	}
	public function changeRole( User $user ,Request $request) {
        if(Auth::user()->type === 'Super Admin') {
            $user->update(['parent' => $request->get('role')]);

            return redirect()->back()->with(['success' => 'User Updated Successfully.']);
        }
        abort(404);
	}

	public function storeEmployee( Request $request, User $user ) {

		if($request->has("employee")) {
			$employee = User::find($request->employee)->update( [
				'name'     => $request->name,
				'email'    => $request->email,
			] );

			if(!empty($request->password)) {
				$employee->password = bcrypt( $request->password );
				$employee->save();
			}

			$message = 'Employee Updated Successfully.';

		}else{
			User::create( [
				'name'     => $request->name,
				'email'    => $request->email,
				'password' => bcrypt( $request->password ),
				'parent' => $request->parent
			] );

			$message = 'Employee Created Successfully.';
		}

		return redirect(route("userEmployee", ["user" => $user->id]))->with( [ 'success' => $message] );
	}

	public function deleteEmployee( User $user ) {
		$user->delete();
		return redirect()->back()->with( [ 'success' => 'Employee Deleted Successfully.' ] );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() {
		Session::flash( 'sidebar', 'users' );

		return view( 'admin.user.create' );
	}

	/**
	 * @param StoreUserRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store( StoreUserRequest $request ) {
	    $this_user =  Auth::user();
        if($this_user->type == 'GSA') {
            $newBalance = $this_user->balance - $request->balance;
            $this_user->balance = $newBalance;
            if ($newBalance < 0) return redirect()->back()->withErrors([ 'balance' => 'the balance should be meaner than yours' ] );
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'balance' => $request->balance ? $request->balance : 0 ,
                'type' => 'User',
                'company' => $request->company,
                'address' => $request->address,
                'phone' => $request->phone,
                'parent' => $this_user->id,
            ]);
            $this_user->save();
        }else{
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'balance' => $request->balance ? $request->balance : 0 ,
                    'type' => $request->type,
                    'company' => $request->company,
                    'address' => $request->address,
                    'phone' => $request->phone,
                ]);
            }
		return redirect()->back()->with( [ 'success' => 'User Created Successfully.' ] );
	}

	/**
	 * @param User $user
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit( User $user ) {
        if(Auth::user()->type == 'Super Admin' || $user->parent == Auth::user()->id) {
            Session::flash('sidebar', 'users');

            return view('admin.user.update', compact('user'));
        }
        abort(404);
	}

	/**
	 * @param User $user
	 * @param UpdateUserRequest $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function update( User $user, UpdateUserRequest $request ) {
        if(Auth::user()->type === 'Super Admin' or $user->parent == Auth::user()->id) {
            $user->update($request->only(['name', 'email', 'type', 'company', 'address', 'phone', 'showInvoices','parent']));

            if ($request->new_password) {
                $user->update(['password' => bcrypt($request->new_password)]);
            }

            return redirect()->back()->with(['success' => 'User Updated Successfully.']);
        }
        abort(404);
	}

	/**
	 * @param User $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function destroy( User $user ) {
		if ( $user->avatar ) {
			Storage::disk( 'public' )->delete( $user->avatar );
		}

		$user->delete();

		return redirect()->back()->with( [ 'success' => 'User Deleted Successfully.' ] );
	}


	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function travelOrders( User $user ) {
		$travels = $user->travelPurchases;

		return view( 'admin.orders.travel.travels', compact( 'travels' ) );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function flightOrders( User $user ) {
		$flights = $user->flightPurchases;

		return view( 'admin.orders.flight.flights', compact( 'flights' ) );
	}


	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function visaOrders( User $user ) {
		$visas = $user->visaPurchases;

		return view( 'admin.orders.visa.visa', compact( 'visas' ) );
	}

	/**
	 * @param User $user
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function addAmount( User $user, Request $request ) {
		// return $request->comment;
		$this->validate( $request, [
			'amount' => 'required|integer',
		] );

		$newBalance = (int) $user->balance + $request->amount;
		if ( $request->get( 'type' ) == "withdrawal" ) {
			$newBalance = (int) $user->balance - $request->amount;
		}

		Auth::user()->adminTransactions()->create( [
			'to'           => $user->id,
			'amount'       => $request->amount,
			'comment'      => $request->comment,
			'type'         => $request->type,
			'creditBefore' => $user->balance,
			'creditAfter'  => $newBalance,
		] );

		$user->update( [
			'balance' => $newBalance
		] );

		Notification::send( $user, new Notifier( [
			'message' => $request->amount . ' $ has benn added to your account successfully.',
			'url'     => route( 'user-profile' )
		], 'Account Transactions' ) );

		// Send email notification
//		$msg = "$$request->amount has been added to your account successfully.";
//		$title = "Account Transactions";
//
//		Mail::send('emails.notification', ["msg" => ["message" => $msg, "title" => $title]], function($message) use ($user) {
//			$message->to($user->email)->subject('Account Transactions');
//			$message->from('no-reply@alnkhel.com','Al-Nakheel Group');
//		});

		return redirect()->back()->with( [ 'success' => 'Transaction has been processed successfully' ] );
	}

	/**
	 * @param User $user
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function userTransactions( User $user, Request $request ) {
		$transactions = $user->userTransactions;

		if ( $request->from || $request->to ) {
			$transactions = $user->userTransactions()->where( 'created_at', '>=', Carbon::parse( $request->from )->format( 'Y-m-d' ) )
			                     ->where( 'created_at', '<=', Carbon::parse( $request->to )->format( 'Y-m-d' ) )
			                     ->orderBy( 'id', 'DESC' )->get();
		}

		return view( 'admin.user.transactions', compact( 'transactions', 'user' ) );
	}

	/**
	 * @param User $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function userActivation( User $user ) {
		$user->update( [ 'activation' => $user->activation === '0' ? '1' : '0' ] );

		Notification::send( $user, new Notifier( [
			'message' => 'your account has benn activated successfully and now you can use your account to book any ticket.',
			'url'     => route( 'user-profile' )
		], 'Account Verification' ) );

		return redirect()->back()->with( [ 'success' => 'user account activated successfully!' ] );
	}
}

<?php

namespace App\Providers;

use App\Country;
use App\User;
use App\News;
use App\Page;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Sheet;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		$url = '/';
		foreach ( request()->segments() as $key => $segment ) {
			if ( $key !== 0 ) {
				$url .= $segment . '/';
			}
		}

		View::share( 'url', $url );

		view()->composer('*', function($view)
		{
			$delayedOrder = false;
			if(Auth::check()) {
				$user = Auth::user();
				$openReturnOrdersQuery = $user->charterPurchases()->where("flight_type", "OpenReturn")
				->where(function ($query) {
                    $query->whereDate('open_end', '>', Carbon::now()->toDateTimeString());
                    $query->whereDate('notiAt', '<', Carbon::now()->toDateTimeString());
                    
                });
				
				if($openReturnOrdersQuery->count() > 0) {
					$orders = $openReturnOrdersQuery->get();
					foreach($orders as $order) {
						if($order->flights()->count() == 1){
							$delayedOrder = $order;
							break;
						}
					}
				}
			}

			View::share('delayedOrder', $delayedOrder);
		});

		View::share( 'countries_order', Country::orderBy('updated_at', 'ASC')->get() );
      View::share( 'countries', Country::all() );
      View::share( 'news', Page::where('page_type' , 'news')->orderBy('id', 'desc')->take(3)->get() );

		Validator::extend( 'valid_old_password', function ( $attribute, $value, $parameters, $validator ) {
			$user = User::find( $parameters[0] );

			return Hash::check( $value, $user->password );
		} );

		Sheet::macro( 'styleCells', function ( Sheet $sheet, string $cellRange, array $style ) {
			$sheet->getDelegate()->getStyle( $cellRange )->applyFromArray( $style );
		} );
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}

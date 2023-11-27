<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::put( 'login', 'MainPageController@checklogin' )->name( 'front_login' );
Route::put( 'register', 'MainPageController@register' )->name( 'user-register' );



Route::get('/raload', function() {
     Artisan::call('cache:clear');
   Artisan::call('config:clear');
   Artisan::call('config:cache');
   Artisan::call('view:clear');
return Redirect::back();
  
})->name('raload');


Route::get('/404', function () {
    $pt = "Page Not Found";
    return view('404', compact('pt'));
})->name('404');

Route::get('/foo', function () {
Artisan::call('storage:link');
});



// Ajax
Route::post( 'autocomplete', 'AjaxController@autoComplete' )->name( 'autoComplete' );
Route::get( 'check-user-messages', 'AjaxController@checkMessages' )->name( 'checkMessages' );
Route::get( 'read-user-messages', 'AjaxController@readMessages' )->name( 'readMessages' );
Route::post( 'calculate-charter-price', 'AjaxController@calculateCharterPrice' )->name( 'calculateCharterPrice' );
Route::get( 'cancel-charter-form', 'AjaxController@cancelCharterForm' )->name( 'cancelCharterForm' );
Route::get( 'rebook-charter-form', 'AjaxController@rebookCharterForm' )->name( 'rebookCharterForm' );
Route::get( 'charter-reserve-form', 'AjaxController@charterReserveForm' )->name( 'charterReserveForm' );

Route::group( [ 'prefix' => 'admin' ], function () {
	// Authentication
	Route::get( 'login', 'AuthenticationController@index' )->name( 'login' );
	Route::post( 'login', 'AuthenticationController@login' )->name( 'authenticate' );
	Route::get( 'logout', 'AuthenticationController@logout' )->name( 'logout' );

	// Home & Profile
	Route::get( '/', 'AuthenticationController@home' )->name( 'home' );
	Route::group( [ 'prefix' => 'profile' ], function () {
		Route::get( '/', 'ProfileController@index' )->name( 'profile' );
		Route::post( 'update', 'ProfileController@update' )->name( 'updateProfile' );
		Route::post( 'update-password', 'ProfileController@updatePassword' )->name( 'updatePassword' );
	} );

	// Countries
	Route::group( [ 'prefix' => 'countries' ], function () {
		Route::get( '/', 'CountriesController@index' )->name( 'listCountries' );
		Route::get( 'create', 'CountriesController@create' )->name( 'createCountry' );
		Route::post( 'store', 'CountriesController@store' )->name( 'storeCountry' );

		Route::group( [ 'prefix' => '{country}' ], function () {
			Route::get( '/', 'CountriesController@show' )->name( 'showCountry' );
			Route::get( 'edit', 'CountriesController@edit' )->name( 'editCountry' );
			Route::post( 'update', 'CountriesController@update' )->name( 'updateCountry' );
			Route::get( 'delete', 'CountriesController@destroy' )->name( 'deleteCountry' );
		} );
	} );
	
	// aircraft
	Route::group( [ 'prefix' => 'aircraft' ], function () {
		Route::get( '/', 'AircraftController@index' )->name( 'listAircraft' );
		Route::get( 'create', 'AircraftController@create' )->name( 'createAircraft' );
		Route::post( 'store', 'AircraftController@store' )->name( 'storeAircraft' );

		Route::group( [ 'prefix' => '{aircraft}' ], function () {
			Route::get( '/', 'AircraftController@show' )->name( 'showAircraft' );
			Route::get( 'edit', 'AircraftController@edit' )->name( 'editAircraft' );
			Route::post( 'update', 'AircraftController@update' )->name( 'updateAircraft' );
			Route::get( 'delete', 'AircraftController@destroy' )->name( 'deleteAircraft' );
		} );
	} );

	// Invoices
	Route::group( [ 'prefix' => 'invoices' ], function () {
		Route::get( '/', 'InvoicesController@index' )->name( 'listInvoices' );
		Route::get( 'create', 'InvoicesController@create' )->name( 'createInvoice' );
		Route::post( 'store', 'InvoicesController@store' )->name( 'storeInvoice' );

		Route::group( [ 'prefix' => '{invoice}' ], function () {
			Route::get( '/', 'InvoicesController@show' )->name( 'showInvoice' );
			Route::get( 'edit', 'InvoicesController@edit' )->name( 'editInvoice' );
			Route::get( 'pdf', 'InvoicesController@pdf' )->name( 'printInvoice' );
			Route::get( 'pdf/download', 'InvoicesController@pdfDownload' )->name( 'downloadInvoice' );
			Route::post( 'update', 'InvoicesController@update' )->name( 'updateInvoice' );
			Route::get( 'delete', 'InvoicesController@destroy' )->name( 'deleteInvoice' );
			Route::post( 'insert_item', 'InvoicesController@insertItem' )->name( 'insertItem' );
			Route::get( 'delete_item/{item}', 'InvoicesController@deleteItem' )->name( 'deleteItem' );
		} );
	} );

	// Travels
	Route::group( [ 'prefix' => 'travels' ], function () {
		Route::get( '/', 'TravelController@index' )->name( 'listTravels' );
		Route::get( 'create', 'TravelController@create' )->name( 'createTravel' );
		Route::post( 'store', 'TravelController@store' )->name( 'storeTravel' );

		Route::group( [ 'prefix' => '{travel}' ], function () {
			Route::get( 'edit', 'TravelController@edit' )->name( 'editTravel' );
			Route::post( 'update', 'TravelController@update' )->name( 'updateTravel' );
			Route::get( 'delete', 'TravelController@destroy' )->name( 'deleteTravel' );

			Route::group( [ 'prefix' => 'orders' ], function () {
				Route::get( '/', 'TravelController@travelOrders' )->name( 'travelOrders' );
				Route::post( '/{order}/status', 'TravelController@changeTravelStatus' )->name( 'changeTravelStatus' );
				Route::get( '/{order}/cancel', 'TravelController@cancelTravelTicket' )->name( 'cancel-travel-ticket' );
				Route::get( '/{order}/status/reject', 'TravelController@changeTravelStatusToReject' )->name( 'changeTravelStatusToReject' );
				Route::get( '/{order}/status/receive', 'TravelController@changeTravelStatusToReceive' )->name( 'changeTravelStatusToReceive' );
				Route::get( '/{order}/edit', 'TravelController@editTravelOrder' )->name( 'editTravelOrder' );
				Route::post( '/{order}/edit', 'TravelController@editOrder' )->name( 'updateTravelOrder' );
				Route::get( '/download', 'TravelController@travelOrdersDownload' )->name( 'travelOrdersDownload' );
			} );
		} );

		Route::get( 'images/{image}/remove', 'TravelController@removeImage' )->name( 'deleteImage' );
	} );

	// Flights
	Route::group( [ 'prefix' => 'flights' ], function () {
		Route::get( '/', 'FlightsController@index' )->name( 'listFlights' );
		Route::get( 'create', 'FlightsController@create' )->name( 'createFlight' );
		Route::post( 'store', 'FlightsController@store' )->name( 'storeFlight' );

		Route::group( [ 'prefix' => '{flight}' ], function () {
			Route::get( '/', 'FlightsController@show' )->name( 'showFlight' );
			Route::get( 'edit', 'FlightsController@edit' )->name( 'editFlight' );
			Route::post( 'update', 'FlightsController@update' )->name( 'updateFlight' );
			Route::get( 'delete', 'FlightsController@destroy' )->name( 'deleteFlight' );

			Route::group( [ 'prefix' => 'orders' ], function () {
				Route::get( '/', 'FlightsController@flightOrders' )->name( 'flightOrders' );
				Route::post( '/{order}/status', 'FlightsController@changeFlightStatus' )->name( 'changeFlightStatus' );
				Route::get( '/{order}/status/reject', 'FlightsController@changeFlightStatusToReject' )->name( 'changeFlightStatusToReject' );
				Route::get( '/{order}/status/receive', 'FlightsController@changeFlightStatusToReceive' )->name( 'changeFlightStatusToReceive' );
				Route::get( '/{order}/edit', 'FlightsController@editFlightOrder' )->name( 'editFlightOrder' );
				Route::post( '/{order}/edit', 'FlightsController@editOrder' )->name( 'updateFlightOrder' );
			} );
		} );
	} );

	// Charter
	Route::group( [ 'prefix' => 'charter' ], function () {
		Route::get( '/', 'CharterController@index' )->name( 'listCharter' );
		Route::get( 'data', 'CharterController@charterData' )->name( 'charterData' );
		Route::get( 'create', 'CharterController@create' )->name( 'createCharter' );
		Route::post( 'store', 'CharterController@store' )->name( 'storeCharter' );

		// Order flights ajax
		Route::get( 'order/flights', 'CharterController@charterOrderFlights' )->name( 'charterOrderFlights' );

		Route::group( [ 'prefix' => '{charter}' ], function () {
			Route::get( '/', 'CharterController@show' )->name( 'showCharter' );
			Route::get( 'edit', 'CharterController@edit' )->name( 'editCharter' );
			Route::post( 'update', 'CharterController@update' )->name( 'updateCharter' );
			Route::post( 'update-locked', 'CharterController@updateLocked' )->name( 'updateLockedCharter' );
			Route::get( 'delete', 'CharterController@destroy' )->name( 'deleteCharter' );
			Route::get( 'prices', 'CharterController@prices' )->name( 'pricesCharter' );
			Route::post( '/order-cancel', 'CharterController@cancelCharterTicket' )->name( 'cancel-charter-ticket' );
			Route::post( '/order-rebook', 'CharterController@rebookCharterTicket' )->name( 'rebook-charter-ticket' );

			Route::get( 'pricing', 'Charter\CharterPricing@index' )->name( 'charterPricing' );
			Route::post( 'pricing', 'Charter\CharterPricing@addPricing' )->name( 'charterAddPricing' );
			Route::get( 'pricing/delete', 'Charter\CharterPricing@deletePricing' )->name( 'charterDeletePricing' );
			Route::post( 'pricing/update', 'Charter\CharterPricing@updatePricing' )->name( 'charterUpdatePricing' );

			Route::get( 'lock', 'CharterController@lockCharter' )->name( 'lockCharter' );

            Route::get( 'locked', 'CharterController@locked' )->name( 'charterLocked' );
            Route::Post( 'copy', 'CharterController@charterCopy' )->name( 'charterCopy' );
			Route::post( 'locked', 'CharterController@storeLocked' )->name( 'storeLocked' );
			Route::post( 'locked/{locked}/delete', 'CharterController@deleteLocked' )->name( 'deleteLocked' );
			Route::get( 'locked/data', 'CharterController@lockedData' )->name( 'lockedData' );

			Route::get( 'commission', 'CharterController@commission' )->name( 'charterCommission' );
			Route::post( 'commission', 'CharterController@storeCommission' )->name( 'storeCommission' );
			Route::get( 'commission/{commission}/delete', 'CharterController@deleteCommission' )->name( 'deleteCommission' );
			Route::get( 'commission/data', 'CharterController@commissionData' )->name( 'commissionData' );

			Route::get( 'passengers_data/{order}', 'CharterController@charterPassengersData' )->name( 'charterPassengersData' );


			Route::group( [ 'prefix' => 'orders' ], function () {
				Route::get( '/', 'CharterController@charterOrders' )->name( 'charterOrders' );

				Route::get( '/download', 'CharterController@charterOrdersDownload' )->name( 'charterOrdersDownload' );
				Route::get( '/data', 'CharterController@charterOrdersData' )->name( 'charterOrdersData' );
				Route::post( '/{order}/status', 'CharterController@changeCharterStatus' )->name( 'changeCharterStatus' );
				Route::get( '/{order}/status/reject', 'CharterController@changeCharterStatusToReject' )->name( 'changeCharterStatusToReject' );
				Route::get( '/{order}/status/receive', 'CharterController@changeCharterStatusToReceive' )->name( 'changeCharterStatusToReceive' );
				Route::get( '/{order}/edit', 'CharterController@editCharterOrder' )->name( 'editCharterOrder' );
				Route::post( '/{order}/edit', 'CharterController@editOrder' )->name( 'updateCharterOrder' );
			} );
		} );
	} );

	// Visa
	Route::group( [ 'prefix' => 'visa' ], function () {
		Route::get( '/', 'VisaController@index' )->name( 'listVisas' );
		Route::get( 'create', 'VisaController@create' )->name( 'createVisa' );
		Route::post( 'store', 'VisaController@store' )->name( 'storeVisa' );

		Route::group( [ 'prefix' => '{visa}' ], function () {
			Route::get( 'edit', 'VisaController@edit' )->name( 'editVisa' );
			Route::post( 'update', 'VisaController@update' )->name( 'updateVisa' );
            Route::get( 'delete', 'VisaController@destroy' )->name( 'deleteVisa' );
            Route::get( 'lock', 'VisaController@lockVisa' )->name( 'lockVisa' );

			Route::group( [ 'prefix' => 'orders' ], function () {
				Route::get( '/', 'VisaController@visaOrders' )->name( 'visaOrders' );
				Route::post( '/{order}/status', 'VisaController@changeVisaStatus' )->name( 'changeVisaStatus' );
				Route::get( '/{order}/status/reject', 'VisaController@changeVisaStatusToReject' )->name( 'changeVisaStatusToReject' );
				Route::get( '/{order}/status/cancel', 'VisaController@changeVisaStatusToCancel' )->name( 'changeVisaStatusToCancel' );
				Route::get( '/{order}/status/receive', 'VisaController@changeVisaStatusToReceive' )->name( 'changeVisaStatusToReceive' );
				Route::get( '/{order}/edit', 'VisaController@editVisaOrder' )->name( 'editVisaOrder' );
				Route::post( '/{order}/edit', 'VisaController@editOrder' )->name( 'updateVisaOrder' );
			} );
		} );
	} );

	// Users
	Route::group( [ 'prefix' => 'users' ], function () {
		Route::get( '/', 'UsersController@index' )->name( 'listUsers' );
		Route::get( '/users-data', 'UsersController@usersData' )->name( 'usersData' );
		Route::get( '/employees-data', 'UsersController@employeesData' )->name( 'employeesData' );
		Route::get( 'create', 'UsersController@create' )->name( 'createUser' );
		Route::post( 'store', 'UsersController@store' )->name( 'storeUser' );

		Route::group( [ 'prefix' => '{user}' ], function () {
			Route::get( 'edit', 'UsersController@edit' )->name( 'editUser' );
			Route::post( 'update', 'UsersController@update' )->name( 'updateUser' );
			Route::get( 'delete', 'UsersController@destroy' )->name( 'deleteUser' );
			Route::get( '/travels', 'UsersController@travelOrders' )->name( 'userTravelOrders' );
			Route::get( '/flights', 'UsersController@flightOrders' )->name( 'userFlightOrders' );
			Route::get( '/visa', 'UsersController@visaOrders' )->name( 'userVisaOrders' );
			Route::get( '/transactions', 'UsersController@userTransactions' )->name( 'userTransactions' );
			Route::post( '/credit/add', 'UsersController@addAmount' )->name( 'userAddAmount' );
			Route::get( '/activation', 'UsersController@userActivation' )->name( 'userActivation' );
			Route::get( '/employee', 'UsersController@userEmployee' )->name( 'userEmployee' );
			Route::get( '/gsaList', 'UsersController@gsaList' )->name( 'gsaList' );
			Route::get( '/delete-employee', 'UsersController@deleteEmployee' )->name( 'deleteEmployee' );
			Route::post( '/store-employee', 'UsersController@storeEmployee' )->name( 'storeEmployee' );
			Route::post( '/changeRole', 'UsersController@changeRole' )->name( 'changeRole' );
		} );
	} );

	// News
	Route::group( [ 'prefix' => 'news' ], function () {
		Route::get( '/', 'NewsController@index' )->name( 'listNews' );
		Route::get( 'create', 'NewsController@create' )->name( 'createNews' );
		Route::post( 'store', 'NewsController@store' )->name( 'storeNews' );

		Route::group( [ 'prefix' => '{news}' ], function () {
			Route::get( '/', 'NewsController@show' )->name( 'showNews' );
			Route::get( 'edit', 'NewsController@edit' )->name( 'editNews' );
			Route::post( 'update', 'NewsController@update' )->name( 'updateNews' );
			Route::get( 'delete', 'NewsController@destroy' )->name( 'deleteNews' );
		} );
	} );

	// Pages
	Route::group( [ 'prefix' => 'pages' ], function () {
		Route::get( '/', 'PagesController@index' )->name( 'listPages' );
		Route::get( 'create', 'PagesController@create' )->name( 'createPage' );
		Route::post( 'store', 'PagesController@store' )->name( 'storePage' );

		Route::group( [ 'prefix' => '{page}' ], function () {
			Route::get( '/', 'PagesController@show' )->name( 'showPage' );
			Route::get( 'edit', 'PagesController@edit' )->name( 'editPage' );
			Route::post( 'update', 'PagesController@update' )->name( 'updatePage' );
			Route::get( 'delete', 'PagesController@destroy' )->name( 'deletePage' );
		} );
	} );

    Route::get( '/messages', 'MessageController@messages' )->name( 'messages' );
    Route::post( '/messages/threads', 'MessageController@threads' )->name( 'messages.threads' );
    Route::post( '/messages/send', 'MessageController@sendMessage' )->name( 'messages.send' );
    Route::post( '/messages/messages', 'MessageController@getMessages' )->name( 'messages.messages' );


//    Route::get( '/messages', 'MessageController@create' )->name( 'messages' );
//    Route::post( '/messages', 'MessageController@store' )->name( 'storeMessage' );

    Route::get( '/about', 'SettingsController@about' )->name( 'about-page' );
	Route::post( '/about', 'SettingsController@updateAbout' )->name( 'updateAbout' );

	Route::get( '/contact', 'SettingsController@contact' )->name( 'contact-page' );
	Route::post( '/contact', 'SettingsController@updateContact' )->name( 'updateContact' );

	Route::get( '/settings', 'SettingsController@index' )->name( 'settings-page' );
	Route::post( '/settings', 'SettingsController@update' )->name( 'settings-form' );

	Route::post( '/read-notifications', 'AuthenticationController@readNotification' )->name( 'read-notification' );
} );

Route::group( [ 'prefix' => 'profile' ], function () {
	Route::get( '/', 'UserPortalController@index' )->name( 'user-profile' );
	Route::post( '/avatar', 'UserPortalController@changeAvatar' )->name( 'changeAvatar' );
	Route::get( '/travels', 'UserPortalController@travels' )->name( 'listUserTravels' );
	Route::get( '/travels/{order}/cancel', 'UserPortalController@cancelTravel' )->name( 'cancelTravel' );
	Route::get( '/flights', 'UserPortalController@flights' )->name( 'listUserFlights' );
	Route::get( '/flights/{order}/cancel', 'UserPortalController@cancelFlight' )->name( 'cancelFlight' );

	Route::get( '/messages', 'UserMessageController@messages' )->name( 'user.messages' );
	Route::post( '/messages/threads', 'UserMessageController@threads' )->name( 'user.messages.threads' );
	Route::post( '/messages/send', 'UserMessageController@sendMessage' )->name( 'user.messages.send' );
	Route::post( '/messages/messages', 'UserMessageController@getMessages' )->name( 'user.messages.messages' );

	#---- Charter ------#
	Route::get( '/charter', 'UserPortalController@charter' )->name( 'listUserCharter' );
	Route::any( '/charter-buttons/{order?}', 'UserPortalController@charterButtons' )->name( 'charterButtons' );
	Route::get( '/charter/{order}', 'UserPortalController@charterDetails' )->name( 'charterDetails' );
	Route::get( '/charter/{order}/cancel', 'UserPortalController@cancelCharter' )->name( 'cancelCharter' );
	Route::get( '/charter/{charter}/pay/{order}', 'UserPortalController@payOrder' )->name( 'payOrder' );

	Route::get( '/visa', 'UserPortalController@visa' )->name( 'listUserVisas' );
	Route::get( '/visa/{order}/cancel', 'UserPortalController@cancelVisa' )->name( 'cancelVisa' );

	Route::get( '/history', 'UserPortalController@history' )->name( 'history' );
	Route::get( '/history_data', 'UserPortalController@historyData' )->name( 'historyData' );

	Route::get( '/user/history', 'UserPortalController@search' )->name( 'searchUserHistory' );
	Route::get( '/tickets', 'UserPortalController@ticketCharter' )->name( 'ticketCharter' );

	// Invoices
	Route::group( [ 'prefix' => 'invoices' ], function () {
		Route::get( '/', 'UserInvoicesController@index' )->name( 'listUserInvoices' );
		Route::get( 'create', 'UserInvoicesController@create' )->name( 'createUserInvoice' );
		Route::post( 'store', 'UserInvoicesController@store' )->name( 'storeUserInvoice' );

		Route::group( [ 'prefix' => '{invoice}' ], function () {
			Route::get( '/', 'UserInvoicesController@show' )->name( 'showUserInvoice' );
			Route::get( 'edit', 'UserInvoicesController@edit' )->name( 'editUserInvoice' );
			Route::get( 'pdf', 'UserInvoicesController@pdf' )->name( 'printUserInvoice' );
			Route::get( 'pdf/download', 'UserInvoicesController@pdfDownload' )->name( 'downloadUserInvoice' );
			Route::post( 'update', 'UserInvoicesController@update' )->name( 'updateUserInvoice' );
			Route::get( 'delete', 'UserInvoicesController@destroy' )->name( 'deleteUserInvoice' );
			Route::post( 'insert_item', 'UserInvoicesController@insertItem' )->name( 'insertUserItem' );
			Route::get( 'delete_item/{item}', 'UserInvoicesController@deleteItem' )->name( 'deleteUserItem' );
		} );
	} );
} );

Route::group( [
	'prefix'     => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function () {
	Route::get( '/', 'MainPageController@index' )->name( 'front-home' ); 
	Route::get( '/flights', 'MainPageController@flights' )->name( 'flights' );
	Route::get( '/flights/{flight}', 'MainPageController@singleFlight' )->name( 'singleFlight' );
	Route::get( '/charter', 'MainPageController@charter' )->name( 'charter' );

	Route::any( '/charter-create', 'MainPageController@charterCreate' )->name( 'charter.create' );
	Route::post( '/charter-create/results', 'MainPageController@charterCreateSearch' )->name( 'charter.create.results' );
	Route::post( '/charter-create/results/ajax', 'MainPageController@charterAjaxSearch' )->name( 'charter.search.ajax' );

	Route::get( '/charter-search', 'MainPageController@charterSearch' )->name( 'charter.search' )->middleware('auth');
	Route::post( '/charter-search', 'MainPageController@getSearchresult' )->name( 'get.result' )->middleware('auth');;
	Route::get( '/charter/reserved', 'MainPageController@reservedSeats' )->name( 'reservedSeats' );
	Route::get( '/travels', 'MainPageController@travels' )->name( 'travels' );
	Route::get( '/travels/{travel}', 'MainPageController@singleTravel' )->name( 'singleTravel' );
	Route::get( '/visa', 'MainPageController@visas' )->name( 'visas' );
	Route::get( '/visa/{visa}', 'MainPageController@singleVisa' )->name( 'singleVisa' );

	Route::get( 'logout', 'MainPageController@logout' )->name( 'front-logout' );
	Route::post( 'login', 'MainPageController@login' )->name( 'user-login' );
	Route::get( 'forget-password', 'MainPageController@forgetPassword' )->name( 'forgetPassword' );
	Route::post( 'reset-password', 'MainPageController@resetPassword' )->name( 'resetPassword' );

	Route::get( '/travels/{travel}/pre-checkout', 'MainPageController@travelPreCheckoutPage' )->name( 'travel-pre-checkout' );
	Route::post( '/travels/{travel}/pre-checkout', 'MainPageController@travelPreCheckout' )->name( 'travel-pre-checkout-form' );
	Route::get( '/travels/{travel}/checkout', 'MainPageController@travelCheckoutPage' )->name( 'travel-checkout' );
	Route::get( '/travels/{travel}/checkout/complete', 'MainPageController@travelCheckout' )->name( 'travel-checkout-form' );
	Route::get( '/travels/{pnr}/ticket', 'MainPageController@travelTicket' )->name( 'travel-ticket' );
	Route::get( '/travels/{pnr}/ticket/download', 'MainPageController@downloadTravelTicker' )->name( 'download-travel-ticket' );
	Route::get( '/travels/{order}/ticket/cancel', 'UserPortalController@cancelTravelTicket' )->name( 'cancelTravel' );

	Route::get( '/flights/{flight}/pre-checkout', 'MainPageController@flightPreCheckoutPage' )->name( 'flight-pre-checkout' );
	Route::post( '/flights/{flight}/pre-checkout', 'MainPageController@flightPreCheckout' )->name( 'flight-pre-checkout-form' );
	Route::get( '/flights/{flight}/checkout', 'MainPageController@flightCheckoutPage' )->name( 'flight-checkout' );
	Route::get( '/flights/{flight}/checkout/complete', 'MainPageController@flightCheckout' )->name( 'flight-checkout-form' );

	Route::post( '/charter/locked-form', 'MainPageController@charterLockedForm' )->name( 'charterLockedForm' );
	Route::post( '/charter/checkRound', 'MainPageController@checkRound' )->name( 'checkRound' );
	Route::post( '/charter/checkout', 'MainPageController@charterCheckout' )->name( 'charterCheckout' );

	Route::post( '/charter/checkout/complete', 'MainPageController@completeCharterOrder' )->name( 'completeCharterOrder' );

//	Route::post( '/charter/{flight}/pre-checkout', 'MainPageController@charterPreCheckout' )->name( 'charter-pre-checkout-form' );
//	Route::get( '/charter/{flight}/checkout', 'MainPageController@charterCheckoutPage' )->name( 'charter-checkout' );
//	Route::get( '/charter/{flight}/checkout/complete', 'MainPageController@charterCheckout' )->name( 'charter-checkout-form' );

	Route::get( '/charter/{pnr}/ticket', 'MainPageController@charterTicket' )->name( 'charter-ticket' );
	Route::get( '/charter/{pnr}/ticket/download', 'MainPageController@downloadCharterTicker' )->name( 'download-charter-ticket' );
	Route::get( '/charter/{order}/ticket/cancel', 'UserPortalController@cancelCharterTicket' )->name( 'cancelCharter' );

	Route::post( '/visa/{visa}/pre-checkout', 'MainPageController@visaPreCheckout' )->name( 'visa-pre-checkout-form' );
	Route::get( '/visa/{visa}/checkout', 'MainPageController@visaCheckoutPage' )->name( 'visa-checkout' );
	Route::get( '/visa/{visa}/checkout/complete', 'MainPageController@visaCheckout' )->name( 'visa-checkout-form' );
	Route::get( '/visa/{visa}/download/pdf', 'MainPageController@visaDownloadPdf' )->name( 'visaDownloadPdf' );
	Route::get( '/travel/{travel}/download/pdf', 'MainPageController@travelDownloadPdf' )->name( 'travelDownloadPdf' );
	Route::get( '/flight/{flight}/download/pdf', 'MainPageController@flightDownloadPdf' )->name( 'flightDownloadPdf' );
	Route::get( '/about-us', 'MainPageController@aboutUs' )->name( 'aboutUs' );
	Route::get( '/contact-us', 'MainPageController@contactUs' )->name( 'contactUs' );
	Route::post( '/contact-us', 'MainPageController@contact' )->name( 'contact-form' );
	Route::get( '/page/{page}', 'MainPageController@page' )->name( 'page' );
  
  

	Route::get( '/search/{searchable}', 'MainPageController@search' )->name( 'search' );
	Route::get( '/pnr_search', 'MainPageController@pnrSearch' )->name( 'pnrSearch' );
} );


Route::group( [ 'prefix' => 'web' ], function () {

	Route::get( '/', 'web\webController@index' );

} );
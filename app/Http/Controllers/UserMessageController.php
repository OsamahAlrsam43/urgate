<?php

namespace App\Http\Controllers;

use App\Messages;
use App\Threads;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserMessageController extends Controller {
	public function __construct() {
		$this->middleware( [ 'auth' ] );
	}

	public function messages() {
		$admins = User::where( "type", "Super Admin" )->get();

		return view( 'admin.messages.user_messages', compact( 'admins' ) );
	}

	public function threads() {
		$currentUser = Auth::user();
		$admins = User::where( "type", "Super Admin" )->get()->toArray();

		$threads = [];

		foreach($admins as $admin) {
			$admin['last_message'] = Messages::where("user_id", $currentUser->id)->where("admin_id", $admin['id'])->orderBy("id", "DESC")->first();

			$threads[] = $admin;
		}

		return response()->json( [
			'threads' => $threads
		] );
	}

	public function getMessages( Request $request ) {
		$currentUser = Auth::user();
		$messagesQuery = Messages::where("user_id", $currentUser->id)->where("admin_id", $request->thread)->orderBy("id", "DESC");

		$messagesQuery->update([
			"read_at" => Carbon::now()
		]);

		$messages = $messagesQuery->get();

		return response()->json([
			'messages' => $messages
		]);
	}

	public function sendMessage( Request $request ) {
		$currentUser = Auth::user();

		$currentUser->messages()->create( [
			"message"  => $request->message,
			"title"    => $request->title,
			"admin_id"    => $request->admin,
			"is_admin" => 0
		] );

		return response()->json( [] );
	}
}// end class
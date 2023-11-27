<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Message;
use App\Messages;
use App\Threads;
use App\User;
use App\UserMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller {
	public function __construct() {
		$this->middleware( [ 'auth', 'dashboardAccess' ] );
	}

	public function create() {
		$users = User::where( 'type', "User" )->get();

		return view( 'admin.messages.create_message', compact( 'users' ) );
	}

	public function messages() {
		return view( 'admin.messages.messages' );
	}

	public function threads() {
		$currentUser = Auth::user();
//		$users = User::where("type", "User")->get();
		$users = User::all()->toArray();

		$threads = [];

		foreach($users as $user) {
			$user['last_message'] = Messages::where("admin_id", $currentUser->id)->where("user_id", $user['id'])->orderBy("id", "DESC")->first();

			$threads[] = $user;
		}

		return response()->json( [
			'threads' => $threads
		] );
	}

	public function getMessages(Request $request) {
		$currentUser = Auth::user();
		$messages = Messages::where("admin_id", $currentUser->id)->where("user_id", $request->thread)->orderBy("id", "DESC")->get();

		return response()->json([
			'messages' => $messages
		]);
	}

	public function sendMessage(Request $request) {
		$currentUser = Auth::user();
		$selectedSend = $request->sendMode == "specific";
		$singleMessage = $request->singleMessage;

		if($selectedSend or $singleMessage) {
			$ids = array_column($request->selectedUsers, 'id');
			$users = User::whereIn("id", $ids)->get();
		}else{
			$users = User::where("type", "!=", "Super Admin")->get();
		}

		foreach($users as $user) {
			$user->messages()->create([
				"message" => $request->message,
				"title" => $request->title,
				"is_admin" => 1,
				"admin_id" => $currentUser->id,
			]);
		}

		return response()->json($users);
	}
}// end class
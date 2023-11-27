<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticationController extends Controller
{
    /**
     * AuthenticationController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['home', 'logout']);
        $this->middleware('dashboardAccess')->except(['login', 'index', 'readNotification']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        Session::flash('sidebar', 'home');

        return view('admin.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function readNotification(Request $request)
    {
        Auth::user()->unreadNotifications()->where('id', $request->id)->first()->markAsRead();

        return response()->json(['success' => 'notification marked as read successfully!']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('admin.login');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        if (User::where('email', $request->email)->first()->hasRole('User')) {
            return redirect()->back()->with(['fail' => 'Enter valid Email Or Password']);
        }

        if (Auth::attempt($request->only(['email', 'password']))) {
            return redirect()->route('home');
        }

        return redirect()->back()->with(['fail' => 'Enter valid Email Or Password']);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

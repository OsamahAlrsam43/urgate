<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.profile');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(UpdateProfileRequest $request)
    {
        Auth::user()->update($request->only(['name', 'email', 'company', 'address', 'phone']));

        return redirect()->back()->with(['success' => 'Personal information updated successfully.']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        Auth::user()->update(['password' => bcrypt($request->new_password)]);

        return redirect()->back()->with(['success' => 'Password updated successfully.']);
    }
}
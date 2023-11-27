<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingsRequest;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    /**
     * SettingsController constructor.
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
        Session::flash('sidebar', 'settings');

        $setting = Setting::first();

        return view('admin.settings', compact('setting'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        Setting::first()->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'mail' => $request->mail,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'linked' => $request->linked,
            'charter' => $request->charter,
            'create_charter' => $request->create_charter,
        ]);

        return redirect()->back()->with(['success' => 'settings updated successfully.']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        Session::flash('sidebar', 'about');

        $setting = Setting::first();

        return view('admin.about', compact('setting'));
    }

    /**
     * @param UpdateSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAbout(UpdateSettingsRequest $request)
    {
        Setting::first()->update([
            'about_title' => $request->about_title,
            'about_content' => $request->about_content,
        ]);

        return redirect()->back()->with(['success' => 'about page updated successfully.']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        Session::flash('sidebar', 'contact');

        $setting = Setting::first();

        return view('admin.contact', compact('setting'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateContact(Request $request)
    {
        Setting::first()->update([
            'contact' => $request->contact,
            'mail' => $request->mail,
        ]);

        return redirect()->back()->with(['success' => 'contact page updated successfully.']);
    }
}

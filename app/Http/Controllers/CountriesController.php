<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CountriesController extends Controller
{

    /**
     * CountriesController constructor.
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
        Session::flash('sidebar', 'countries');

        $countries = Country::all();

        return view('admin.country.index', compact('countries'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Country $country)
    {
        return response()->json(['country' => $country], 200);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        Session::flash('sidebar', 'countries');

        return view('admin.country.create');
    }

    /**
     * @param StoreCountryRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StoreCountryRequest $request)
    {
        $country = Country::create($request->all());

        return redirect()->back()->with(['success' => 'Country Created Successfully.']);
    }


    /**
     * @param Country $country
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Country $country)
    {
        Session::flash('sidebar', 'countries');

        return view('admin.country.update', compact('country'));
    }

    /**
     * @param Country $country
     * @param UpdateCountryRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Country $country, UpdateCountryRequest $request)
    {
        $country->update($request->all());

        return redirect()->back()->with(['success' => 'Country Updated Successfully.']);
    }

    /**
     * @param Country $country
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()->back()->with(['success' => 'Country Deleted Successfully.']);
    }
}

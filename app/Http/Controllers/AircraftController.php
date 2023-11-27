<?php

namespace App\Http\Controllers;

use App\Aircraft;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AircraftController extends Controller
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
        Session::flash('sidebar', 'aircraft');

        $aircrafts = Aircraft::all();

        return view('admin.aircraft.index', compact('aircrafts'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Aircraft $aircraft)
    {
        return response()->json(['aircraft' => $aircraft], 200);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        Session::flash('sidebar', 'aircraft');

        return view('admin.aircraft.create');
    }

    /**
     * @param StoreCountryRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required'
        ]); 
        
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/charter/logos');
            $image->move($destinationPath, $name);
            $request->logo='charter/logos/'.$name;
        }
        
        
        
        $aircraft = new Aircraft();
        $aircraft->name = $request->name;
        $aircraft->logo = $request->logo;
        $aircraft->save();
        
        // $aircraft = Aircraft::create($request->all());

        return redirect()->back()->with(['success' => 'Aircraft Created Successfully.']);
    }


    /**
     * @param Country $country
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Aircraft $aircraft)
    {
        Session::flash('sidebar', 'aircraft');

        return view('admin.aircraft.update', compact('aircraft'));
    }

    /**
     * @param Country $country
     * @param UpdateCountryRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Aircraft $aircraft, Request $request)
    {
        
        $this->validate($request, [
            'name' => 'required'
        ]); 
        
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/charter/logos');
            $image->move($destinationPath, $name);
            $request->logo='charter/logos/'.$name;
            $aircraft->logo = $request->logo;
        }
        
        $aircraft->name = $request->name;
        $aircraft->save();
        
        // $aircraft->update($request->all());

        return redirect()->back()->with(['success' => 'Aircraft Updated Successfully.']);
    }

    /**
     * @param Country $country
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Aircraft $aircraft)
    {
        $aircraft->delete();

        return redirect()->back()->with(['success' => 'Aircraft Deleted Successfully.']);
    }
}

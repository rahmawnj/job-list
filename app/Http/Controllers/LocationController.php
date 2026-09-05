<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Location::all());
        return view('dashboard.locations.index', [
            'title' => 'Location',
            'locations' => Location::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.locations.create', [
            'title' => 'Location'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Location::create([
            'name' => $request->name,
        ]);
        return redirect('/dashboard/locations')->with('success', 'New Job Category has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        return view('dashboard.locations.edit', [
            'title' => 'Location',
            'location' => $location
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required',
        ]);
        Location::where('id', $location->id)->update([
            'name' => $request->name,
        ]);
        return redirect('/dashboard/locations')->with('success', 'Job Category has been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        if (count($location->jobs) == 0) {
            Location::destroy($location->id);
            return redirect('/dashboard/locations')->with('success', 'Job Category has been Deleted');
        } else {
            return redirect('/dashboard/locations')->with('error', 'Delete Job Category failed');
        }
    }

}

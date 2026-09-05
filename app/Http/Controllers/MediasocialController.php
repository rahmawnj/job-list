<?php

namespace App\Http\Controllers;

use App\Models\Mediasocial;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class MediasocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Mediasocial::all());
        return view('dashboard.mediasocials.index', [
            'title' => 'Media Socials',
            'mediasocials' => Mediasocial::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.mediasocials.create', [
            'title' => 'Media Socials'
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
            'link' => 'required',
            'icon' => 'required',
            'status' => 'required',
        ]);

        Mediasocial::create([
            'name' => $request->name,
            'link' => $request->link,
            'icon' => $request->icon,
            'status' => $request->status,
        ]);
        return redirect('/dashboard/mediasocials')->with('success', 'New Media Social has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mediasocial  $mediasocial
     * @return \Illuminate\Http\Response
     */
    public function show(Mediasocial $mediasocial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mediasocial  $mediasocial
     * @return \Illuminate\Http\Response
     */
    public function edit(Mediasocial $mediasocial)
    {
        return view('dashboard.mediasocials.edit', [
            'title' => 'Media Socials',
            'mediasocial' => $mediasocial
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mediasocial  $mediasocial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mediasocial $mediasocial)
    {
      
        $request->validate([
            'name' => 'required',
            'link' => 'required',
            'icon' => 'required',
            'status' => 'required',
        ]);
        Mediasocial::where('id', $mediasocial->id)->update([
            'name' => $request->name,
            'link' => $request->link,
            'icon' => $request->icon,
            'status' => $request->status,
        ]);
        return redirect('/dashboard/mediasocials')->with('success', 'Media Social has been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mediasocial  $mediasocial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mediasocial $mediasocial)
    {
        Mediasocial::destroy($mediasocial->id);
        return redirect('/dashboard/mediasocials')->with('success', 'Media Social has been Deleted');
    }

}

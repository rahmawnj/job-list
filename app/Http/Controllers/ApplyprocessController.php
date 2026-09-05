<?php

namespace App\Http\Controllers;

use App\Models\Applyprocess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ApplyprocessController extends Controller
{
    public function form()
    {
        return view('dashboard.applyprocess.index', [
            'title' => 'Apply Process',
            'applyprocess' => Applyprocess::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title_s1' => 'required',
            'description_s1' => 'required',
            'logo_s1' => 'image|file',
            'title_s2' => 'required',
            'description_s2' => 'required',
            'logo_s2' => 'image|file',
            'title_s3' => 'required',
            'description_s3' => 'required',
            'logo_s3' => 'image|file',
            'title_s4' => 'required',
            'description_s4' => 'required',
            'logo_s4' => 'image|file',
        ]);
        $ap = Applyprocess::all();

        $logo_s1 = Applyprocess::find($request->id_logo_s1);
        if ($request->file('logo_s1')) {
            if ($ap[0]->logo) {
                Storage::delete([$ap[0]->logo]);
            } 
            $validatedData['logo_s1'] = $request->file('logo_s1')->store('uploads/image/applyprocesses');
        } else {
            $validatedData['logo_s1'] = $ap[0]->logo;
        }
        Applyprocess::where('id', $request->id_s1)->update([
            'title' => $validatedData['title_s1'],
            'logo' => $validatedData['logo_s1'],
            'description' => $validatedData['description_s1'],
        ]);

        $logo_s2 = Applyprocess::find($request->id_logo_s2);
        if ($request->file('logo_s2')) {
            if ($ap[1]->logo) {
                Storage::delete([$ap[1]->logo]);
            } 
            $validatedData['logo_s2'] = $request->file('logo_s2')->store('uploads/image/applyprocesses');
        } else {
            $validatedData['logo_s2'] = $ap[1]->logo;
        }
        Applyprocess::where('id', $request->id_s2)->update([
            'title' => $validatedData['title_s2'],
            'logo' => $validatedData['logo_s2'],
            'description' => $validatedData['description_s2'],
        ]);
       
        $logo_s3 = Applyprocess::find($request->id_logo_s3);
        if ($request->file('logo_s3')) {
            if ($ap[2]->logo) {
                Storage::delete([$ap[2]->logo]);
            } 
            $validatedData['logo_s3'] = $request->file('logo_s3')->store('uploads/image/applyprocesses');
        } else {
            $validatedData['logo_s3'] = $ap[2]->logo;
        }
        Applyprocess::where('id', $request->id_s3)->update([
            'title' => $validatedData['title_s3'],
            'logo' => $validatedData['logo_s3'],
            'description' => $validatedData['description_s3'],
        ]);

        $logo_s4 = Applyprocess::find($request->id_logo_s3);
        if ($request->file('logo_s4')) {
            if ($ap[3]->logo) {
                Storage::delete([$ap[3]->logo]);
            } 
            $validatedData['logo_s4'] = $request->file('logo_s4')->store('uploads/image/applyprocesses');
        } else {
            $validatedData['logo_s4'] = $ap[3]->logo;
        }
        Applyprocess::where('id', $request->id_s4)->update([
            'title' => $validatedData['title_s4'],
            'logo' => $validatedData['logo_s4'],
            'description' => $validatedData['description_s4'],
        ]);
        

        return redirect('dashboard/applyprocess')->with('success', 'Applyprocess has been Updated');

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.users.index', [
            'title' => 'Users',
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create', [
            'title' => 'Users'
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
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'image' => 'image|file|max:2048'
        ]);
        
        $validatedData['password'] = Hash::make($request->password);
        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('uploads/image/users');
        }
     
        User::create($validatedData);
        return redirect('/dashboard/users')->with('success', 'New User has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('dashboard.users.view', [
            'title' => 'Users',
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', [
            'title' => 'Users',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($request->email == $user->email){
            $rules_email = 'required';
        } else{
            $rules_email = 'required|unique:users';
        }
        
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => $rules_email,
            'image' => 'image|file|max:2048'
        ]);

        if ($request->file('image')) {
            if ($user->image) {
                Storage::delete([$user->image]);
            } 
            $validatedData['image'] = $request->file('image')->store('uploads/image/users');
        }
        
        if($request->password != "") {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            $validatedData['password'] = $user->password;
        }

        User::where('id', $user->id)->update($validatedData);
        return redirect('/dashboard/users')->with('success', 'User has been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('/dashboard/users')->with('success', 'User has been Deleted');
    }

}

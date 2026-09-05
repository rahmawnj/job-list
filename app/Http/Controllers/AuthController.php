<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login', [
            'title' => 'Login'
        ]);
    }

    public function login_post(Request $request){
        $credentials = $request->validate([
           'email' => 'required', 
           'password' => 'required' 
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        } else {
            return back()->with('error', 'Login Error');
        }
    }

    public function logout(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
    
    public function profile(){
        $user = User::find(auth()->user()->id);
        
        return view('auth.profile', [
            'title' => 'Profile',
            'user' => $user
        ]);
    }

    public function profile_post(Request $request){
        $user = User::find(auth()->user()->id);

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
        
        return redirect('/profile')->with('success', 'Your Profile has been Updated');

    }
}

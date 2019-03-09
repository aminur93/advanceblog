<?php

namespace App\Http\Controllers\Backend;

use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends BackendController
{
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.home.index');
    }
    
    public function error()
    {
        return view('403');
    }
    
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('backend.home.edit',compact('user'));
    }
    
    public function update(Requests\UserUpdateRequest $request)
    {
        $user = $request->user();
        $old_image = $user->image;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->slug = $request->slug;
        $user->bio = $request->bio;
    
        if ($request->hasFile('image')) {
            $usersImage = public_path("/img/{$user->image}");
            if (File::exists($usersImage)) {
                unlink($usersImage);
            }
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(64, 64)->save(public_path('/img/'.$filename));
            $user->image = $filename;
        }else{
            $user->image = $old_image;
        }
    
    
        $user->save();
        $user->detachRoles();
        $user->attachRole($request->role);
    
        return redirect()->back()->with('message','User Update Successfully!!');
    }
}

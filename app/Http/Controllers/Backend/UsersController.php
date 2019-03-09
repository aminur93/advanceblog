<?php

namespace App\Http\Controllers\Backend;

use App\User;
use App\Http\Requests;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Image;

class UsersController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name')->paginate($this->limit);
        $usersCount = User::count();
        return view('backend.users.index',compact('users','usersCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('backend.users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\UsersRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
              Image::make($image)->resize(64, 64)->save(public_path('/img/'.$filename));
          }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->slug = $request->slug;
        $user->bio = $request->bio;
        $user->image = $filename;
        
        $user->save();
        $user->attachRole($request->role);
        
//        $user = User::create($request->all());
//        $user->attachRole($request->role);

        return redirect('/backend/users')->with('message','User Added successfully!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UserUpdateRequest $request, $id)
    {
        
        $user = User::findOrFail($id);
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
        
        return redirect('/backend/users')->with('message','User Update Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requests\UsersConfirmRequest $request, $id)
    {
        $users = User::findOrFail($id);
//        $deleteOption = $request->delete_option;
//        $selectedUser = $request->selected_user;
//
//        if ($deleteOption == "delete")
//        {
//            // delete users posts
//            $users->posts()->delete();
//            // delete the user
//        }
//        elseif ($deleteOption == "attribute")
//        {
//            $users->posts()->update(['author_id' => $selectedUser]);
//        }
        $image_old = public_path("/img/{$users->image}");
        unlink($image_old);
        $users->posts()->delete();
        return redirect('/backend/users')->with('message','User Delete Successfully!!');
    }
    
    public function confirm(Requests\UsersConfirmRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $users = User::where('id', '!=', $user->id)->pluck('name','id');
        
        return view('backend/users/confirm',compact('user','users'));
    }
}

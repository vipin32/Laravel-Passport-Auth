<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        
        if(\Auth::user())
        {
            $user = User::all();
            return response(['users'=> $user, 'status'=>200]);
        }
        else
        {
            return response(['message'=> 'You are not logged in', 'status'=>201]);
        }
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->is_admin)
        {
            $validatedData = $request->validate([
                'name' => 'required|max:55',
                'email' => 'email|required|unique:users',
                'password' => 'required|confirmed'
            ]);
    
            $validatedData['password'] = bcrypt($request->password);
    
            $user = User::create($validatedData);

            // $accessToken = $user->createToken('authToken')->accessToken;

            return response(['success'=> 'User Created Successfully', 'status'=>200]);
        }
        else
        {
            return response(['failed'=>'You do not have access to create user.', 'status'=>201]);
        }
        
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(auth()->user()->is_admin)
        {
            $user = User::find($id);

            $user->update($request->all());

            return response(['success'=> 'User Updated Successfully', 'status'=>200]);
        }
        else
        {
            return response(['failed'=>'You have no access to update user', 'status'=>201]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->is_admin)
        {
            $user = User::find($id);
            $user->delete();

            return response(['success'=>'User Deleted Successfully', 'status'=>200]);
        }
        else
        {
            return response(['success'=>'You have no access to delete any user', 'status'=>201]);
        }
    }
}

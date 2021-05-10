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
        $user = User::all();

        return ['users'=> $user];
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

            return response(['success'=> 'User Created Successfully']);
        }
        else
        {
            return ['failed'=>'You do not have access to create user.'];
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

            return response(['success'=> 'User Updated Successfully']);
        }
        else
        {
            return ['failed'=>'You have no access to update user.'];
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

            return ['success'=>'User Deleted Successfully'];
        }
        else
        {
            return ['success'=>'You have no access to delete any user'];
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' =>'required|max:255',
            'email' =>'required|email|unique:users',
            'password' => 'required|max:255',
            'role_id' => 'required|'.Rule::in('1','2','3','4')
        ]);

        // create the user
        $request['password'] = Hash::make($request->password);
        $user = User::create($request->all());


        // Return a success response
        return response(['data' => $user]);
    }
}

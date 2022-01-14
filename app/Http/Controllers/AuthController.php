<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return "Auth Successfull";
        }
  
        return "Auth Error";
    }


    public function signup(Request $request)
    {  
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validation->fails()){
            return $request->input("name");
        }
           
        $user = new User();
        $user->name = $request->input("name");
        $user->password = Hash::make($request->input("password"));
        $user->email = $request->input("email");

        $user->save();
         
        return "Registration successfull";
    }


    public function create(array $data)
    {

      return User::create([
        'name' => $data['name'],
        'password' => Hash::make($data['password'])
      ]);
    }
}

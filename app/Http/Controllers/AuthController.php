<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request) {

    //validation field
        $validUser=Validator::make($request->all(), [
            'name'=> 'required|string',
            'email'=> 'required|email',
            'password'=> 'required|string',
        ]);
        
        if($validUser->fails()) {
            return response([
                'message'=> 'bad request'
            ], 400);
        }

    //create user
        $user= new User();
        $user->name= $request->name;
        $user->email= $request->email;
        $user->password= bcrypt($request->password);
        $user->user_atribute_1= '';
        $user->user_atribute_2= '';
        $user->user_atribute_3= '';
        $user->user_atribute_4= '';
        $user->user_atribute_5= '';
        $user->save();

    //response
        return response([ 
            'user'=> $user,
            'token'=> $user->createToken('secret')->plainTextToken,
        ], 200);
    }

    public function login(Request $request) {

    //validation field
        $validUser=Validator::make($request->all(), [
            'email'=> 'required|email',
            'password'=> 'required|confirmed'
        ]);

        $credentials = request(['email', 'password']);

    //attempt and feedback
        if (!Auth::attempt($credentials)) {
            return response([
                'message'=> 'invalid credentials'
            ], 500);
        } 

        $user= User::where('email', $request->email)->first();
        $userToken= $user->createToken('authToken')->plainTextToken;

    //response
        return response([
            'user'=> $user,
            'token'=> $userToken
        ], 200);
    }

    public function logout(Request $request) {

    //user
        $user= User::find(PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id);

    //delete token
        $user->tokens()->delete();

    //reponse
        return response([
            'message'=> 'logout success',
        ], 200);
    }

    public function user() {

    //user
        $user= auth()->user();

    //response
        return response([
            'user'=> $user,
        ], 200);
    }

    public function update(Request $request) {

    //user
        $validUser=Validator::make($request->all(), [
            'name'=> 'required|string',
            'email'=> 'required|email',
            'password'=> 'required|string',
        ]);

    //update
        auth()->user()->update([
            'name'=> $validUser->name,
            'email'=> $validUser->email,
            'password'=> bcrypt($validUser->password),
        ]);
        
    //response
        return response([
            'message'=> 'updated',
            'user'=> $user,
        ], 200);
    }
}

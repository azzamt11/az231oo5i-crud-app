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
                'message'=> 'bad request',
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
                'message'=> 'invalid credentials', 
                'credentials'=> $credentials['password']
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
        $user= User::find(PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id);

        $validUser=Validator::make($request->all(), [
            'name'=> 'required|string',
            'password'=> 'required|string',
            'user_atribute_1'=> 'nullable|string',
            'user_atribute_2'=> 'nullable|string',
        ]);

        if($validUser->fails()) {
            return response([
                'message'=> 'bad request'
            ], 400);
        }

    //update
        $user->update([
            'name'=> $request->name,
            'password'=> bcrypt($request->password),
            'user_atribute_1'=> $request->user_atribute_1,
            'user_atribute_2'=> $request->user_atribute_2,
        ]);
        
    //response
        return response([
            'message'=> 'updated',
            'user'=> $user,
        ], 200);
    }

    public function delete(Request $request) {

    //user
        $user= User::find(PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id);
    
    //delete
        $user->delete();

    //response
        return response([
            'message'=>'delete success'
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubPost;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;


class SubPostController extends Controller
{
    public function subindex($id) {

    //response
        return response([
            'subposts'=> SubPost::orderBy('created_at', 'desc')->where('subpost_parent', $id)->get(),
        ], 200);
    }
    
    public function showSubPostById($id, $sid) {
    
    //response
        return response([
            'subpost'=> SubPost::orderBy('created_at', 'desc')->where('subpost_parent', $id)->where('id', $sid)->get(),
        ], 200);
    }

    public function storeSubPost(Request $request, $id) {

    //validation
        $validSubPost=Validator::make($request->all(), [
            'subpost_body'=> 'required|string',
            'subpost_type'=> 'required|integer'
        ]);
    
        if($validSubPost->fails()) {
            return response([
                'message'=> 'bad request'
            ], 400);
        }
    
    //subpost
        $subpost= SubPost::create([
            'subpost_body'=> $request['subpost_body'],
            'subpost_user'=> PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id,
            'subpost_type'=> $request['subpost_type'],
            'subpost_parent'=> $id,
            'subpost_attribute_1'=> 0,
            'subpost_attribute_2'=> '',
            'subpost_attribute_3'=> '',
        ]);
        
    //response
        return response([
            'message'=> 'SubPost created',
            'subpost'=> $subpost,
        ],200);    
    }

    public function userSubPost(Request $request) {

    //response
        return response([
            'user_subposts'=> SubPost::where('subpost_user', PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id)->orderBy('created_at', 'desc')->get(),
        ], 200);
    }

    public function addAttribute(Request $request, $id, $sid) {

    //finding post
        $subpost= SubPost::where('subpost_parent', $id)->where('id', $sid)->get(); 
    
    //update attributes
        $subpost->first()->update([
            'subpost_attribute_1'=> PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id,
            'subpost_attribute_2'=> $request['attribute_2'],
        ]);
    
    //response
        return response([
            'message'=> 'attributes have been added',
            'subpost'=> $subpost,
        ], 200);
    }

    public function updateSubPost(Request $request, $id, $sid) {

    //validation field
        $validNewPost=Validator::make($request->all(), [
            'subpost_body'=> 'required|string',
            'attribute_3'=> 'required|string'
        ]);
    
        if($validNewPost->fails()) {
            return response([
                'message'=> 'bad request', 
                'request'=> $request,
            ], 400);
        }
    
    //subpost
        $subpost= SubPost::where('subpost_parent', $id)->where('id', $id)->where('subpost_user', PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id);
    
    //access evaluation, response, and deletion
        if($subpost->first()==null) {
            return response([
                'message'=> 'you dont have access to the requested subpost',
                'subpost'=> $subpost
            ], 403);
        } else {
            $subpost->update([
                'subpost_body'=> $request['subpost_body'],
                'subpost_attribute_3'=> $request['attribute_3'],
            ]);
            return response([
                'message'=> 'update subpost success',
                'subpost'=> $subpost,
            ], 200);
        }
            
    }

    public function deleteSubPost(Request $request, $id, $sid) {
    
    //subpost
        $subpost= SubPost::where('subpost_parent', $id)->where('id', $sid)->where('subpost_user', PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id);
    
    //subpost authorization, deleting, and response
        if($subpost->first()==null) {
            return response([
                'message'=> 'you dont have access to the requested subpost',
                'subpost'=> $subpost
            ], 403);
        } else {
            $subpost->delete();
            return response([
                'message'=> 'subpost deleted',

            ],200);
        }    
    }
    
}

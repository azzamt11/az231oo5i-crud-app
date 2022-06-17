<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\SubPost;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index() {

    //middleware call
        $this->middleware('auth');

    //response
        return response([
            'posts'=> Post::orderBy('created_at', 'desc')->get(),
        ], 200);
    }

    public function showPostById($id) {

    //response
        return response([
            'post'=> Post::where('id',$id)->get(),
        ], 200);
    }

    public function userPost(Request $request) {

    //response
        return response([
            'user_posts'=> DB::table('posts')->where('post_user', PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id)->orderBy('created_at', 'desc')->get(),
        ], 200);
    }

    public function storePost(Request $request) {

    //validation
        $validPost=Validator::make($request->all(), [
            'post_body'=> 'required|string',
            'post_type'=> 'required|integer'
        ]);

        if($validPost->fails()) {
            return response([
                'message'=> 'bad request'
            ], 400);
        }

    //post
        $post= Post::create([
            'post_body'=> $request['post_body'],
            'post_user'=> PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id,
            'post_type'=> $request['post_type'],
            'post_id'=> 0,
            'post_atribute_1'=> 0,
            'post_atribute_2'=> '',
            'post_atribute_3'=> '',
        ]);
    
    //response
        return response([
            'message'=> 'Post created',
            'post'=> $post,
        ],200);    
    }

    public function addAtribute(Request $request, $id) {

    //finding post
        $post= Post::where('id', $id); 

    //update atributes
        $post->update([
            'post_atribute_1'=> PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id,
            'post_atribute_2'=> $request['atribute_2'],
        ]);

    //response
        return response([
            'message'=> 'Atributes have been added',
            'post'=> $post,
        ], 200);
    }

    public function updatePost(Request $request, $id) {

    //validation field
        $validNewPost=Validator::make($request->all(), [
            'post_body'=> 'required|string',
            'atribute_3'=> 'required|string'
        ]);

        if($validNewPost->fails()) {
            return response([
                'message'=> 'bad request', 
                'request'=> $request,
            ], 400);
        }

    //post
        $post= Post::where('id', $id)->where('post_user', PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id);

    //post authorization and response
        if($post->first()==null) {
            return response([
                'message'=> 'you dont have access to the requested post',
                'post'=> $post
            ], 403);
        } else {
            $post->update([
                'post_body'=> $request['post_body'],
                'post_atribute_3'=> $request['atribute_3'],
            ]);
            return response([
                'message'=> 'update post success',
                'post'=> $post,
            ], 200);
        }
        
    }

    public function deletePost(Request $request, $id) {
    
    //post
        $post= Post::where('id', $id)->where('post_user', PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id);
        SubPost::where('subpost_parent', $id)->delete();

    //post authorization and response
        if($post->first()==null) {
            return response([
                'message'=> 'you dont have access to the requested post',
                'post'=> $post
            ], 403);
        } else {
            $post->delete();
            return response([
                'message'=> 'post deleted'
            ],200);
        }    
    }
}

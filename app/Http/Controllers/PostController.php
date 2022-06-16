<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class PostController extends Controller
{
    public function index() {

    //middleware call
        $this->middleware('auth');

    //response
        return response([
            'posts'=> Post::orderBy('created_at', 'desc')->with('user:id,name,user_atribute_1')->get(),
        ], 200);
    }

    public function showPostById($id) {

    //response
        return response([
            'post'=> Post::find($id)->get(),
        ], 200);
    }

    public function userPost(Request $request) {

    //response
        return response([
            'user_posts'=> DB::table('posts')->where('post_user', PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id)->get(),
        ], 200);
    }

    public function storePost(Request $request) {

    //validation
        $validPost= $request->validate([
            'body'=> 'required|string',
            'type'=> 'required|integer'
        ]);

    //post
        $post= Post::create([
            'post_body'=> $validPost['body'],
            'post_user'=> PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id,
            'post_type'=> $validPost['type'],
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
        $post= Post::find($id); 

    //update atributes
        $post->update([
            'post_atribute_1'=> PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id,
            'post_atribute_2'=> $request['atribute_2'],
        ]);

    //response
        return response([
            'message'=> 'Atributes have been added',
            'post_body'=> $post,
        ], 200);
    }

    public function updatePost(Request $request, $id) {

    //new post
        $validNewPost= $request->validate([
            'body'=> 'required|string',
            'atribute_3'=> $request['atribute_3'],
        ]);

    //post
        $post= Post::find($id)->where('post_user', PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id);

    //post authorization and response
        if($post==null) {
            return response([
                'you dont have access to the requested post'
            ]);
        } else {
            $post->update([
                'post_body'=> $validNewPost['body'],
                'post_atribute_3'=> $validNewPost['atribute_3'],
            ], 403);
            return response([
                'message'=> 'update post success',
                'post'=> $post,
            ], 200);
        }
        
    }

    public function deletePost(Request $request, $id) {
    
    //post
        $post= Post::find($id)->where('post_user', PersonalAccessToken::findToken(explode(' ',$request->header('Authorization'))[1])->tokenable_id);

    //post authorization, deleting, and response
        if($post==null) {
            return response([
                'message'=> 'you dont have access to the requested post'
            ], 403);
        } else {
            $post->subposts()->delete();
            $post->delete();
            return response([
                'message'=> 'post deleted'
            ],200);
        }    
    }
}

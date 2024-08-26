<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index()
    {
        $posts= Post::all();
        return response()->json([
            'message'=>'This is all Posts',
            'data'=>$posts
        ],200);
    }

    public function show($id){
        $post=Post::find($id);
        if(!$post){
            return response()->json(['message'=>'Post not found'],404);
        }
        return response()->json([
            'message'=>'Post Found',
            'data'=>$post
        ],200);
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
        $post = Auth::user()->posts()->create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);
        return response()->json([
            'message' => 'Post create Successfully',
            'data' => $post
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        if (Auth::id() !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'body' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $post->update($request->only(['title', 'body']));
        return response()->json([
            'message' => 'Post update Successfully',
            'data' => $post
        ], 200);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        if (Auth::id() !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $post->delete();
        return response()->json(['message' => 'Post deleted Successfully'], 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index() {
        $posts = Post::orderBy('created_at', 'DESC')->get();
        if (!($posts)) {
            return response()->json([
                'message' => 'There is no items ...'
            ], 200);
        }
        return PostResource::collection($posts);
    }

    public function paginate() {
        $posts = Post::paginate(10);    
        return response()->json($posts, 200);
    }

    public function show($id) {
        $post = Post::find($id);
        if (!($post)) {
            return response()->json([
                'message' => 'Item Not Found ...'
            ], 200);
        }
        return new PostResource($post);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts',
            'body' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'validition Error',
                'errors' => $validator->errors()
            ], 400);
        }

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return new PostResource($post);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts',
            'body' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'validition Error',
                'errors' => $validator->errors()
            ], 400);
        }

        $post = Post::findorfail($id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->update();

        return $post;
    }

    public function destroy($id) {
        $post = Post::findorfail($id);
        $post->delete();
        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => 'Post Deleted ...'
        ]);
    }
}

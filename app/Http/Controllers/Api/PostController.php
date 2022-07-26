<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    public function index() {
        $posts = Post::orderBy('created_at', 'DESC')->get();
        return PostResource::collection($posts);
    }

    public function show($id) {
        $post = Post::findorfail($id);
        return new PostResource($post);
    }

    public function store(Request $request) {
        request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return new PostResource($post);
    }

    public function update(Request $request, $id) {
        request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

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

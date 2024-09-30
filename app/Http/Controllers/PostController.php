<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Get all posts
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return response()->json($posts);
    }

    // Create a new post
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return response()->json($post, 201);
    }

    public function destroy($id)
    {
        // Find the post by its ID
        $post = Post::findOrFail($id);
        $post->delete();

        // Return a success response
        return response()->json(['message' => 'Post deleted successfully']);
    }
}

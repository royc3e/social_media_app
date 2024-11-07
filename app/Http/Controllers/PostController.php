<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PostCreated;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Get all posts
    public function index()
    {
        $posts = Post::with('user', 'comments.user')->latest()->get();
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

        // Log to confirm broadcasting
        \Log::info('Broadcasting post created event', ['post' => $post]);

        // Broadcast event
        broadcast(new PostCreated($post))->toOthers();
        
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

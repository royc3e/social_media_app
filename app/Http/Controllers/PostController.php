<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PostCreated;
use App\Models\Post;
use App\Events\TestNotification;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Get all posts
    public function index()
    {
        $posts = Post::with('user', 'likes', 'comments.user')->latest()->get();

        // Add 'isLiked' property for each post
        $posts->each(function ($post) {
            $post->isLiked = $post->likes->contains('user_id', Auth::id());
        });

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

        $post->load('user');

        event(new TestNotification([
            'author' => $post->user->name,  // Using the user's name here
            'title' => $post->content,      // Assuming title is the content of the post
        ]));

        return response()->json([
            'post' => $post,
            'created_at' => $post->created_at->format('Y-m-d H:i:s') // Format date properly
        ], 201);        
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

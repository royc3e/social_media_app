<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Store a new comment for a specific post
    public function store(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $comment = Comment::create([
            'post_id' => $postId,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        // Load the user relationship
        $comment->load('user');

        return response()->json([
            'message' => 'Comment added successfully.',
            'comment' => $comment, // Includes user data
        ], 201);
    }


    // Fetch all posts with their comments
    public function index()
    {
        $posts = Post::with(['comments.user'])->get(); // Eager load comments and their users
        \Log::info('Fetched posts with comments:', $posts->toArray()); // Log the posts with comments
        return response()->json($posts);
    }

    // Update a specific comment
    public function update(Request $request, $postId, $commentId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $comment = Comment::where('id', $commentId)->where('post_id', $postId)->firstOrFail();
        $comment->comment = $request->input('comment');
        $comment->save();

        return response()->json(['comment' => $comment]);
    }

    // Delete a specific comment
    public function destroy($postId, $commentId)
    {
        $comment = Comment::where('id', $commentId)->where('post_id', $postId)->firstOrFail();
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}

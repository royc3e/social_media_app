<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
{
    $request->validate([
        'comment' => 'required|string|max:255',
    ]);

    $comment = Comment::create([
        'post_id' => $postId,
        'user_id' => auth()->id(), // Ensure to set the user_id if using authentication
        'comment' => $request->comment,
    ]);

    return response()->json([
        'message' => 'Comment added successfully.',
        'comment' => $comment
    ], 201);
}

    public function index()
    {
        $posts = Post::with(['comments.user'])->get(); // Eager load comments and their users
        \Log::info('Fetched posts with comments:', $posts->toArray()); // Log the posts with comments
        return response()->json($posts);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // Check if the user has already liked the post
        $existingLike = Like::where('post_id', $post->id)
                            ->where('user_id', Auth::id())
                            ->first();

        if (!$existingLike) {
            // Create a new like
            Like::create([
                'post_id' => $post->id,
                'user_id' => Auth::id(),
            ]);
        }
        
        // Refresh the post to get updated likes count and check if the user has liked it
        $post->load('likes');
        $isLiked = $post->likes->contains('user_id', Auth::id());

        return response()->json([
            'likes_count' => $post->likes->count(),
            'isLiked' => $isLiked // Return the like status for the current user
        ]);
    }

    public function destroy(Post $post)
    {
        // Find the like by the authenticated user
        $like = Like::where('post_id', $post->id)
                    ->where('user_id', Auth::id())
                    ->first();

        if ($like) {
            $like->delete();
        }
        
        // Refresh the post to get updated likes count and check if the user has liked it
        $post->load('likes');
        $isLiked = $post->likes->contains('user_id', Auth::id());

        return response()->json([
            'likes_count' => $post->likes->count(),
            'isLiked' => $isLiked // Return the like status for the current user
        ]);
    }
}

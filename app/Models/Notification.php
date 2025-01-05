<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Notification extends Model implements ShouldBroadcast
{
    use HasFactory;

    // Fillable fields for the Notification model
    protected $fillable = ['user_id', 'post_id', 'type', 'is_read', 'message'];

    // Relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to the Post model
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Define the channel the notification will broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new Channel('notification.' . $this->user_id);  // Unique channel for each user
    }

    /**
     * Define the data that will be broadcasted.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'author' => $this->user->name,
            'title' => $this->type, // You can customize this according to your notification type
            'post_id' => $this->post_id,
            'is_read' => $this->is_read,
        ];
    }
}

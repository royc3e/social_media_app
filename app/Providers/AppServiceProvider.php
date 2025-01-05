<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Events\PostCreated;
use App\Events\PostLiked;
use App\Events\CommentAdded;
use App\Listeners\SendPostNotification;
use App\Listeners\SendLikeNotification;
use App\Listeners\SendCommentNotification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register event listeners
        Event::listen(PostCreated::class, [SendPostNotification::class, 'handle']);
        Event::listen(PostLiked::class, [SendLikeNotification::class, 'handle']);
        Event::listen(CommentAdded::class, [SendCommentNotification::class, 'handle']);
    }
}

<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use App\BlogPost;
use App\User;

class ActivityComposer
{
    public function compose(View $view)
    {
        // Time in minutes
        $cachedTime = 60;

        $mostCommented = Cache::tags(['blog-post'])->remember('blog-post-commented', $cachedTime, function () {
            return BlogPost::mostCommented()->take(5)->get();
        });

        $mostActive = Cache::tags(['blog-post'])->remember('users-most-active', $cachedTime, function () {
            return User::withMostBlogPosts()->take(5)->get();
        });

        $mostActiveLastMonth = Cache::tags(['blog-post'])->remember('users-most-active-last-month', $cachedTime, function () {
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });

        $view->with('mostCommented', $mostCommented);
        $view->with('mostActive', $mostActive);
        $view->with('mostActiveLastMonth', $mostActiveLastMonth);
    }
}
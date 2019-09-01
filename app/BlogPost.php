<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    // protected $table = 'blog_posts';
    use SoftDeletes;

    protected $fillable = ['title', 'content'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public static function boot()
    {
        // ->forceDelete(); will delete the blog post no matter what.

        parent::boot();

        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });

        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class Comment extends Model
{
    use SoftDeletes;

    public function blogPost()
    {

        // This will look for the blog_post + _id, this is because the name of the function is "blogPost"
        // The function can have a different name but then a second parameter will be needed like so: ->belongsTo('App\BlogPost', 'blog_post_id')
        return $this->belongsTo('App\BlogPost');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }
}

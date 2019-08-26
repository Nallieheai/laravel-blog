<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function blogPost()
    {
        // This will look for the blog_post + _id, this is because the name of the function is "blogPost"
        // The function can have a different name but then a second parameter will be needed like so: ->belongsTo('App\BlogPost', 'blog_post_id')
        return $this->belongsTo('App\BlogPost');
    }
}

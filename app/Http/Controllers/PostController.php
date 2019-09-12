<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Cache;

// Laravel can figure out which policy to use when using "authorize()"
// because of the method names defined.
//     'method name' => 'policy to use'
// [
//     'show' => 'view',
//     'create' => 'create',
//     'store' => 'create',
//     'edit' => 'update',
//     'update' => 'update',
//     'destroy' => 'delete'
// ]

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Time in minutes
        $cachedTime = 60;

        $mostCommented = Cache::remember('blog-post-commented', $cachedTime, function () {
            return BlogPost::mostCommented()->take(5)->get();
        });

        $mostActive = Cache::remember('users-most-active', $cachedTime, function () {
            return User::withMostBlogPosts()->take(5)->get();
        });

        $mostActiveLastMonth = Cache::remember('users-most-active-last-month', $cachedTime, function () {
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });
        

        // comments_count
        return view('posts.index', [
            'posts' => BlogPost::latest()->withCount('comments')->with('user')->get(),
            'mostCommented' => $mostCommented,
            'mostActive' => $mostActive,
            'mostActiveLastMonth' => $mostActiveLastMonth
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Request $request, <= argument
        // $request->session()->reflash();
        // return view('posts.show', ['post' => BlogPost::with(['comments' => function($query) {
        //     return $query->latest();
        // }])->findOrFail($id)]);
        $blogPost = Cache::remember("blog-post-{$id}", 60, function() use($id) {
            return BlogPost::with('comments')->findOrFail($id);
        });

        return view('posts.show', ['post' => $blogPost]);
    }

    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        // bail|  (Stops validating after the first rule fails)
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        $blogPost = BlogPost::create($validatedData);
        $request->session()->flash('status', 'Blog post was created!');

        return redirect()->route('posts.show', ['post' => $blogPost->id]);
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize($post);

        return view('posts.edit', ['post' => $post]);
    }

    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize($post);
        
        $validatedData = $request->validated();

        $post->fill($validatedData);
        $post->save();
        $request->session()->flash('status', 'Blog post was updated!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function destroy(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);

        $post->delete();
        // BlogPost::destroy($id);

        $request->session()->flash('status', 'Blog post was deleted!');
        return redirect()->route('posts.index');
    }
}

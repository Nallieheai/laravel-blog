@extends('layout')

@section('content')
<h1>
    {{ $post->title }} 
    @badge(['type'=> 'primary', 'show' => now()->diffInMinutes($post->created_at) < 30])
        New post!
    @endbadge
</h1>

<p>{{ $post->content }}</p>

<p class="text-muted">{{ $post->created_at->diffForHumans() }} by {{ $post->user->name }}</p>



<h4>Comments</h4>
@forelse ($post->comments as $comment)
<div class="card">
    <div class="card-body">
        <p>{{ $comment->content }}</p>
        <em class="text-muted">Added {{ $comment->created_at->diffForHumans() }}</em>
    </div>
</div>
@empty
<p>No comments yet!</p>
@endforelse
@endsection
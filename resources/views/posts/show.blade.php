@extends('layout')

@section('content')
<h1>
    {{ $post->title }} 
    @badge(['type'=> 'primary', 'show' => now()->diffInMinutes($post->created_at) < 30])
        New post!
    @endbadge
</h1>

<p>{{ $post->content }}</p>
@updated(['date' => $post->created_at, 'name' => $post->user->name])
@endupdated
@updated(['date' => $post->updated_at])
Updated
@endupdated
<p>Currently read by {{ $counter }} people!</p>

<h4>Comments</h4>
@forelse ($post->comments as $comment)
<div class="card">
    <div class="card-body">
        <p>{{ $comment->content }}</p>
        @updated(['date' => $comment->created_at])
        @endupdated
    </div>
</div>
@empty
<p>No comments yet!</p>
@endforelse
@endsection
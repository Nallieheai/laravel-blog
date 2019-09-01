@extends('layout')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>

    <p>{{ $post->created_at->diffForHumans() }}</p>

    @if ((new Carbon\Carbon())->diffInMinutes($post->created_at) < 5)
        <strong>New post!</strong>
    @endif

    <h4>Comments</h4>
    @forelse ($post->comments as $comment)
        <div class="card">
            <div class="card-body">
                <p>{{ $comment->content }}</p>
                <em class="text-muted">Added {{ $comment->created_at->diffForHumans() }} by {{ $post->user->name }}</em>
            </div>
        </div>
    @empty
        <p>No comments yet!</p>
    @endforelse
@endsection
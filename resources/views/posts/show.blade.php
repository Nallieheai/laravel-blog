@extends('layout')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>

    <p class="text-muted">{{ $post->created_at->diffForHumans() }}  by {{ $post->user->name }}</p>

    @if ((new Carbon\Carbon())->diffInMinutes($post->created_at) < 30)
        @badge(['type' => 'primary'])
            New post!
        @endbadge
    @endif

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
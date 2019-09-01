@extends('layout')

@section('content')
    @forelse ($posts as $post)
        <div class="card" style="margin-bottom: 10px;">
            <div class="card-body">
                <h3>
                    <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                </h3>
                <em class="text-muted">Added {{ $post->created_at->diffForHumans() }} by {{ $post->user->name }}</em>
    
                @if($post->comments_count)
                    <p>{{ $post->comments_count }} comments!</p>
                @else
                    <p>No comments yet!</p>
                @endif
    
                <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
                <form class="fm-inline" method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete!" class="btn btn-danger"/>
                </form>
            </div>
        </div>
    @empty
        <p>No blog posts yet</p>
    @endforelse
@endsection
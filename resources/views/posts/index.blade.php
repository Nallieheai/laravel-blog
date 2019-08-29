@extends('layout')

@section('content')
    @forelse ($posts as $post)
        <div>
            <h3>
                <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
            </h3>

            @if($post->comments_count)
                <p>{{ $post->comments_count }}</p>
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
    @empty
        <p>No blog posts yet</p>
    @endforelse
@endsection
@extends('layout')

@section('content')
    {{-- @foreach ($posts as $post)
        <p>
            <h3>{{ $post->title }}</h3>
            {{ $post->content }}
        </p>
    @endforeach --}}
    @forelse ($posts as $post)
        <div style="background-color: grey; border: 1px solid black; padding: 5px; margin: 10px;">
            <h3>
                <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
            </h3>
            <a href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
            <form method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                @csrf
                @method('DELETE')
                <input type="submit" value="Delete!" />
            </form>
        </div>
    @empty
        <p>No blog posts yet</p>
    @endforelse
@endsection
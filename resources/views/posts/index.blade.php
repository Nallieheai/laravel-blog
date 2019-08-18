@extends('layout')

@section('content')
    {{-- @foreach ($posts as $post)
        <p>
            <h3>{{ $post->title }}</h3>
            {{ $post->content }}
        </p>
    @endforeach --}}
    @forelse ($posts as $post)
        <div>
            <h3>
                <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
            </h3>
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
@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
        @forelse ($posts as $post)
        <div class="card mb-2">
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

                @can('update', $post)
                <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
                @endcan

                {{-- @cannot('update')
                    <p>You can't edit this post!</p>
                @endcannot --}}

                @can('delete', $post)
                <form class="fm-inline" method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete!" class="btn btn-danger" />
                </form>
                @endcan
            </div>
        </div>
        @empty
        <p>No blog posts yet</p>
        @endforelse
    </div>
    <div class="col-4">
        <div class="container">
            <div class="row">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Most commented</h5>
                        <p class="card-text">What people are currently talking about</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostCommented as $post)
                        <li class="list-group-item">
                            <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}
                                ({{ $post->comments_count }})</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row mt-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Most active users</h5>
                        <p class="card-text">The users that post the most</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mostActive as $user)
                        <li class="list-group-item">{{ $user->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
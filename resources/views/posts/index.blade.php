@extends('layout')

@section('content')
<div class="row">
    <div class="col-8">
        @forelse ($posts as $post)
        <div class="card mb-2">
            <div class="card-body">

                <h3>
                    @if ($post->trashed())
                        <del>
                    @endif
                    <a class="{{ $post->trashed() ? 'text-muted' : '' }}" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                    @if ($post->trashed())
                        </del>
                    @endif
                </h3>
                @updated(['date' => $post->created_at, 'name' => $post->user->name])
                @endupdated

                @tags(['tags' => $post->tags])
                @endtags

                @if($post->comments_count)
                <p>{{ $post->comments_count }} comments!</p>
                @else
                <p>No comments yet!</p>
                @endif

                @auth
                    @can('update', $post)
                    <a class="btn btn-sm btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
                    @endcan
                @endauth

                @auth
                    @if (!$post->trashed())
                        @can('delete', $post)
                        <form class="fm-inline" method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete!" class="btn btn-sm btn-danger" />
                        </form>
                        @endcan
                    @endif
                @endauth
            </div>
        </div>
        @empty
        <p>No blog posts yet</p>
        @endforelse
    </div>
    
    <div class="col-4">
        @include('posts._activity')
    </div>
</div>
@endsection
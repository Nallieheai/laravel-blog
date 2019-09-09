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

                @if($post->comments_count)
                <p>{{ $post->comments_count }} comments!</p>
                @else
                <p>No comments yet!</p>
                @endif

                @can('update', $post)
                <a class="btn btn-sm btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
                @endcan

                {{-- @cannot('update')
                    <p>You can't edit this post!</p>
                @endcannot --}}
                @if (!$post->trashed())
                @can('delete', $post)
                <form class="fm-inline" method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete!" class="btn btn-sm btn-danger" />
                </form>
                @endcan
                @endif
            </div>
        </div>
        @empty
        <p>No blog posts yet</p>
        @endforelse
    </div>
    
    <div class="col-4">
        <div class="container">
            <div class="row">
                @card(['title' => 'Most active posts', 'subtitle' => 'What people are talking about!'])
                    @slot('items')
                        @foreach ($mostCommented as $post)
                            <li class="list-group-item">
                                <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                    {{ $post->title }}
                                </a>
                            </li>
                        @endforeach
                    @endslot
                @endcard
            </div>

            <div class="row mt-4">
                @card(['title' => 'Most active users', 'subtitle' => 'The user that post the most'])
                    @slot('items', collect($mostActive)->pluck('name'))
                @endcard
            </div>
            
            <div class="row mt-4">
                @card(['title' => 'Most active last month', 'subtitle' => 'The users that posted the most last month'])
                    @slot('items', collect($mostActiveLastMonth)->pluck('name'))
                @endcard
            </div>
        </div>
    </div>
</div>
@endsection
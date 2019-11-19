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
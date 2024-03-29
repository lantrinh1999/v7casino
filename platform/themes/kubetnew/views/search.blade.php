@php Theme::layout('has-sidebar') @endphp

<div class="page-intro">
    <h1 class="page-intro__title py-2">{{ __('Search result for: ') . ' "' . Request::input('q') . '"' }}</h1>
</div>

@if ($posts->count() > 0)
    @foreach ($posts as $post)
        <article class="post post__horizontal mb-40 clearfix">
            <div class="post__thumbnail">
                <img src="{{ RvMedia::getImageUrl($post->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $post->name }}"><a href="{{ $post->url }}" class="post__overlay"></a>
            </div>
            <div class="post__content-wrap">
                <header class="post__header">
                    <h3 class="post__title"><a href="{{ $post->url }}">{{ $post->name }}</a></h3>
                    <div class="post__meta"><span class="post__created-at"><i class="ion-clock"></i>{{ $post->created_at->format('M d, Y') }}</span>
                        <span class="post-category"><i class="ion-cube"></i>
                            @if ($post->categories->first())
                                <a href="{{ $post->categories->first()->url }}">{{ $post->categories->first()->name }}</a>
                            @endif
                        </span>
                    </div>
                </header>
                <div class="post__content">
                    <p data-number-line="4">{{ $post->description }}</p>
                </div>
            </div>
        </article>
    @endforeach
    <div class="page-pagination text-right">
        {!! $posts->withQueryString()->links() !!}
    </div>
@else
    <div class="alert alert-warning">
        <p>{{ __('There is no data to display!') }}</p>
    </div>
@endif

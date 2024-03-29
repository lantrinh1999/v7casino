@php Theme::layout('has-sidebar') @endphp
<div class="page-intro">
    <h1 class="page-intro__title py-2">{{ $category->name }}</h1>
</div>
<article class="post post--single">
    <div class="post__content">
        {!! $category->content ?? null !!}
    </div>
</article>
<br>
@if ($posts->count() > 0)
    @foreach ($posts as $post)
        <article class="post post__horizontal mb-40 clearfix">
            <div class="post__thumbnail pb-1">
                <img src="{{ RvMedia::getImageUrl($post->image, 'medium', false, RvMedia::getDefaultImage()) }}"
                    alt="{{ $post->name }}"><a href="{{ $post->url }}" class="post__overlay"></a>
            </div>
            <div class="post__content-wrap">
                <header class="post__header">
                    <h3 class="post__title"><a href="{{ $post->url }}">{{ $post->name }}</a></h3>
                    <div class="post__meta">
                        <span class="post__created-at">
                            <i class="ion-clock"></i>{{ $post->created_at->format('M d, Y') }}</span>
                        <span class="post-category"><i class="ion-cube"></i><a
                                href="{{ $category->url }}">{{ $category->name }}</a></span>
                    </div>
                </header>
                <div class="post__content">
                    <p data-number-line="4">{{ $post->description }}</p>
                </div>
            </div>
        </article>
    @endforeach
    <div class="page-pagination text-right">
        {!! $posts->links() !!}
    </div>
@else
    <article class="post post--single">
        <div class="post__content">
            {!! $category->content ?? null !!}
        </div>
    </article>
    <br>
    <div class="alert alert-warning">
        <p>{{ __('There is no data to display!') }}</p>
    </div>
@endif

<div>
    {!! Theme::partial('horizontal-banner') !!}
</div>

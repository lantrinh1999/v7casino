@php Theme::layout('no-sidebar') @endphp
@php
    if ($category_id1 = theme_option('home-category-1')) {
        $category1 = get_posts_by_category($category_id1, 4, 4);
    }
    if ($category_id2 = theme_option('home-category-2')) {
        $category2 = get_posts_by_category($category_id2, 4, 4);
    }
@endphp
<main>
    {!! Theme::partial('popup') !!}
    {!! Theme::partial('home.slider') !!}
    <div class="container container-home">
        <div class="wrap-main">
            @if (!empty($category1) && !empty(count($category1)))
            <div class="block block-post">
                <div class="block-header">
                    <div class="block-title">{{ theme_option('home-category-title-1') ?? 'LINK KU MỚI HOT NHẤT HÔM NAY' }}</div>
                    {{-- <a href="#" class="block-link">
                        BLOG KU <i class="fas fa-chevron-right"></i>
                    </a> --}}
                </div>

                <div class="block-content">
                    <div class="row">

                        @foreach ($category1 as $post)
                        <div class="col-md-6 col-lg-3">
                            <div class="post-item">
                                <div class="post-img">
                                    <a href="{{ $post->url }}" title="{{ $post->name ?? 'post' }}">
                                        <img src="{{ RvMedia::getImageUrl($post->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $post->name ?? 'post' }}">
                                    </a>
                                </div>
                                <a href="{{ $post->url }}" title="{{ $post->name ?? 'post' }}">
                                    <h5 class="text-white pt-2 mt-lg-2">{{ $post->name }}</h5>
                                </a>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            @endif

            @if (!empty($category2) && !empty(count($category2)))
            <div class="block block-post">
                <div class="block-header">
                    <div class="block-title">{{ theme_option('home-category-title-2') ?? 'LINK KU MỚI HOT NHẤT HÔM NAY' }}</div>
                    {{-- <a href="#" class="block-link">
                        BLOG KU <i class="fas fa-chevron-right"></i>
                    </a> --}}
                </div>

                <div class="block-content">
                    <div class="row">
                        @foreach ($category2 as $post)
                        <div class="col-md-6 col-lg-3">
                            <div class="post-item">
                                <div class="post-img">
                                    <img src="{{ RvMedia::getImageUrl($post->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $post->name ?? 'post' }}">
                                </div>
                                <a href="{{ $post->url }}" class="post-link">
                                    {{ $post->name }}
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif


            <div class="block block-paragraph">
                {!! theme_option('home-description') !!}
            </div>

            {!! Theme::partial('home.faq') !!}
            {!! Theme::partial('home.feedback') !!}
        </div>
    </div>
</main>


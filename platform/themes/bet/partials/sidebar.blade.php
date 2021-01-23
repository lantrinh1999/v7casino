<style>
    .page-sidebar .post__horizontal {
        box-shadow: none;
    }


    .page-sidebar .post__title a {
        color: #666;
        font-size: 15px;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: 0;

    }

    .sidebar-header * {
        color: rgb(73, 73, 73) !important;
    }

</style>
<div class="page-sidebar mt-lg-0">
    @php
    $newest_posts = get_latest_posts(3);
    @endphp
    @if (!empty($newest_posts))
        <section class="sidebar-wrap mt-4 mt-lg-0">
            <div class="sidebar-header pb-2 ">
                <h3 class="border-bottom">BÀI VIẾT MỚI NHẤT</h3>
            </div>
            <div class="row">

                @foreach ($newest_posts as $item)
                    <div class="col-sm-12 col-md-6 col-lg-12">
                        <div class="">
                            <a href="{{ $item->url }}" title="">
                                <img src="{{ RvMedia::getImageUrl($item->image, 'medium', false, RvMedia::getDefaultImage()) }}"
                                    alt="{{ $item->name }}">
                            </a>
                        </div>
                        <h4 class="post__title  mb-4 mt-2 mx-2">
                            <a href="{{ $item->url }}">{{ $item->name }}</a>
                        </h4>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>

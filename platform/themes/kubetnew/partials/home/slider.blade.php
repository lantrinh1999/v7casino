@if (is_plugin_active('slider'))
@php
$sliders = getSliders(10);
@endphp
@if (!empty($sliders) && count($sliders) > 0)
<div class="home-slider">
    @foreach ($sliders as $item)
    <div class="slide-item-wrap">
        <div class="slide-img">
            <img src="{{ get_object_image($item->image ?? '/vendor/core/core/base/images/placeholder.png')  }}" alt="slider">
        </div>
    </div>
    @endforeach
</div>
@endif
@endif

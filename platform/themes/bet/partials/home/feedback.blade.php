@if (is_plugin_active('feedback'))
@php
    $feedbacks = getFeedbacks(10);
@endphp
@if (!empty($feedbacks) && count($feedbacks) > 0)
<div class="block block-feedback">
    <div class="block-content">
        <div class="feedback-slider">
            @foreach ($feedbacks as $item)
            <div class="feedback-item-wrap">
                <div class="feedback-item">
                    <div class="feedback-img">
                        <img src="{{ get_object_image($item->image) }}" alt="feedback">
                    </div>
                    <div class="feedback-rate">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="feedback-content">
                        {!! $item->description !!}
                    </div>
                    <div class="feedback-name">
                        {!! $item->name !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endif

@endif
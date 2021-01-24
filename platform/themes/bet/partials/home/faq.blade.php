@if (is_plugin_active('faq'))
@php
    $faqs = getFaqs(10);
@endphp
@if (!empty($faqs) && count($faqs))
<div class="block block-accordion">
    <div class="block-content">
        <div class="accordion" id="accordionExample">
            @foreach ($faqs as $item)
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne_{{ $item->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne_{{ $item->id }}" aria-expanded="true" aria-controls="collapseOne_{{ $item->id }}">
                        {{ $item->title }}
                    </button>
                </h2>
                <div id="collapseOne_{{ $item->id }}" class="accordion-collapse collapse" aria-labelledby="headingOne_{{ $item->id }}"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {!! $item->content !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endif

@endif

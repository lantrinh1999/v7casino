
@if (!empty(theme_option('horizontal_banner')))
<div class="horizontal-banner py-3">
    <img width="100%" src="{{ get_object_image(theme_option('horizontal_banner')) }}" alt="horizontal-banner">
</div>
@endif
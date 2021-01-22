@php Theme::layout('has-sidebar') @endphp
<div class="page-intro">
    <h1 class="page-intro__title py-2">{{ $page->name }}</h1>
</div>

{!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, ($page->content), $page) !!}

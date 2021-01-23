<div class="col-6 col-md-4 col-lg-2">
    <div class="footer-col">
        @foreach ($menu_nodes as $row)
            <div class="footer-title">
                <a href="{{ $row->url }}" title="{{ $row->title }}">{{ $row->title }}</a>
            </div>
            @if ($row->has_child)
                <div class="footer-menu-wrap">
                    <ul class="footer-menu">
                        @php $count = 1 @endphp
                        @foreach ($row->child as $child)
                            @php if ($count++ == 6) {
                            break;
                            } @endphp
                            <li class="footer-menu-item">
                                <a href="{{ $child->url }}" title="{{ $child->title }}" class="footer-menu-link">
                                    {{ $child->title }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            @endif
            @php
            break;
            @endphp
        @endforeach
    </div>
</div>

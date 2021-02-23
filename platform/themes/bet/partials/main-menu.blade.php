<ul {!! clean($options) !!}>
    @foreach ($menu_nodes as $key => $row)
    <li class="menu-item {{ $row->css_class }} @if ($row->url == Request::url()) current @endif @if ($row->has_child) menu-item-has-children @endif">
        <a href="{{ $row->url }}" target="{{ $row->target }}" class="menu-link">
            {{ $row->title }}
        </a>
        @if ($row->has_child)
        <ul class="sub-menu-wrap">
            <li class="sub-menu-col">

                {!!
                    Menu::generateMenu([
                        'menu'       => $menu,
                        'menu_nodes' => $row->child,
                        'view'       => 'main-menu',
                        'options'    => ['class' => 'sub-menu'],
                    ])
                !!}
            </li>
        </ul>
        @endif
    </li>
    @endforeach
</ul>


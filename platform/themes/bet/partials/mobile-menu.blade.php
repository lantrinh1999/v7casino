<ul>
    @foreach ($menu_nodes as $key => $row)
    <li class="Selected">
        <a href="{{ $row->url }}" target="{{ $row->target }}">
            {{ $row->title }}
        </a>
        @if ($row->has_child)
            {!!
                Menu::generateMenu([
                    'menu'       => $menu,
                    'menu_nodes' => $row->child,
                    'view'       => 'mobile-menu',
                ])
            !!}
        @endif
    </li>
    @endforeach
</ul>



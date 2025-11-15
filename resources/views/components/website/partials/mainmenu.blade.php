{{-- <ul class="navbar-nav text-nowrap gap-4">
    @if (isset($menus) && count($menus) > 0)
        @foreach ($menus as $menu)
            <li class="nav-item">
                <a class="nav-link px-3 {{ Path::AppUrl($menu->segment) === url()->current() ? 'active' : '' }}"
                    href="{{ $menu->link }}">{{ $menu->name }}</a>
            </li>
        @endforeach
    @endif
</ul> --}}

    @if (isset($menus) && count($menus) > 0)
        @foreach ($menus as $menu)
            <li>
                <a href="{{ $menu->link }}">{{ $menu->name }}</a>
            </li>
            @if ($menu->children->isNotEmpty())
            <li class="dropdown"><a href="{{ $menu->link }}">{{ $menu->name }}</a>
                <ul>
                    @foreach ($menu->children as $child)
                    <li>
                        <a href="{{ $child->link }}">{{ $child->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endif
        @endforeach
    @endif
 

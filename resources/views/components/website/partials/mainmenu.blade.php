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
            <li @if($menu->children->isNotEmpty()) class="dropdown" @endif  >
                <a href="{{ $menu->link }}">{{ $menu->name }}</a>
            
            @if ($menu->children->isNotEmpty())
                <ul>
                    @foreach ($menu->children as $child)
                    <li>
                        <a href="{{ $child->link }}">{{ $child->name }}</a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
        @endforeach
    @endif
 

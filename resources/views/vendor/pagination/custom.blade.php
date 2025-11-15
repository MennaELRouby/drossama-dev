@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="pagination-nav">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="nav-button disabled">
                <i class="fas fa-chevron-left"></i>
                {{ __('website.pagination.previous') }}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="nav-button">
                <i class="fas fa-chevron-left"></i>
                {{ __('website.pagination.previous') }}
            </a>
        @endif

        {{-- Pagination Elements --}}
        <ul class="pagination">
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true">
                        <span>{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page">
                                <span>{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="nav-button">
                {{ __('website.pagination.next') }}
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <span class="nav-button disabled">
                {{ __('website.pagination.next') }}
                <i class="fas fa-chevron-right"></i>
            </span>
        @endif
    </nav>
@endif

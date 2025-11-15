@if ($headerServices && $headerServices->count() > 0)
    <ul class="submenu">
        @foreach ($headerServices->take(5) as $service)
            <li><a href="{{ $service->link }}">{{ $service->name }}</a></li>
        @endforeach
        <li><a href="{{ route('website.services') }}">{{ __('website.view_all_services') }}</a></li>
    </ul>
@endif

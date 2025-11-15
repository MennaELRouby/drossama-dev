<x-website.layout>
    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'contact')
            @include('Website.partials._banner', ['page_title' => $section->title])
        @endif
    @endforeach
    <!-- end banner -->
    <!-- end banner -->

    @include('Website.home-partials.contact')

    <!-- end map -->
</x-website.layout>

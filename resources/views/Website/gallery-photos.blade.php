<x-website.layout>

    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'photos')
            @include('Website.partials._banner', ['page_title' => $section->title])
        @endif
    @endforeach
    <!-- end banner -->
    <!-- start about section -->
    @include('Website.partials._gallery_images', ['albums' => $gallery_photos])
    <!-- end about section -->
</x-website.layout>

<x-website.layout>

    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'about')
            @include('Website.partials._banner', ['page_title' => $section->title])
        @endif
    @endforeach
    <!-- end banner -->
    <!-- start about section -->
    @include('Website.about-partials._about', ['about' => $about, 'about_structs' => $about_structs])
    <!-- end about section -->


</x-website.layout>

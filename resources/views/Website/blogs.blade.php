<x-website.layout>
    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'blogs')
            @include('Website.partials._banner', ['banner' => $section])
        @endif
    @endforeach
    <!-- end banner -->
    <!-- start blog section -->
@include('Website.partials._blogs')    
<!-- end blog section -->
</x-website.layout>

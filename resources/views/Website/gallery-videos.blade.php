<x-website.layout>

    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'videos')
            @include('Website.partials._banner', ['page_title' => $section->title])
        @endif
    @endforeach
    <!-- end banner -->
    <!-- start gallery videos section -->
    @include('Website.partials._gallery_video', ['gallery_videos' => $gallery_videos])
    <!-- end gallery videos section -->
</x-website.layout>

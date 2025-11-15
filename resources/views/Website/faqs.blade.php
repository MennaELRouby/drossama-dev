<x-website.layout>

    <!-- start banner -->
    @foreach($sections as $section)
        @if($section->key == 'faqs')
        @include('Website.partials._banner', ['page_title' => $section->title])
        @endif
    @endforeach
    <!-- end banner -->
    <!-- start about section -->
    @include('Website.partials._faqs', ['faqs' => $faqs])
    <!-- end faqs section -->
</x-website.layout>

<x-website.layout>
    @if ($sliders->isNotEmpty())
        @include('Website.home-partials.slider')
    @endif
        @include('Website.home-partials.about')
        
    @if ($services->isNotEmpty())
        @include('Website.home-partials.services')
    @endif
    @if ($blogs->isNotEmpty())
        @include('Website.home-partials.blogs')
    @endif
    @if ($albums->isNotEmpty())
    @include('Website.home-partials.gallery')
    @endif
    @if ($testimonials->isNotEmpty())
        @include('Website.home-partials.testimonial')
    @endif
    @include('Website.home-partials.contact')

</x-website.layout>

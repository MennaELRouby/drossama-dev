<x-website.layout>
    <!-- start banner -->
    @include('Website.partials._banner', ['page_title' => __('website.careers')])
    <!-- end banner -->
    <section class="career-section mt-5">
        <div class="container">
            <div class="row">
               @include('Website.partials._gallery_video',['gallery_videos' => $gallery_videos])
                
               @include('Website.partials._career_applications',['job_positions' => $job_positions])
            </div>
        </div>
      </section>
</x-website.layout>

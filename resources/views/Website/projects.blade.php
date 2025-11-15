<x-website.layout>

    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'projects')
            @include('Website.partials._banner', ['banner' => $section])
        @endif
    @endforeach
    <!-- end banner -->

    <section class="py-5 text-center">
        <div class="container py-5 ">
            <div class="row g-5">
                @foreach ($projects as $project)
                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.1s">
                        <div class="product-card">
                            <a href="{{ $project->link }}" class="">
                                <img src="{{ $project->image_path }}" class="product-img shine-hover"
                                    alt="{{ $project->name }}">
                                <div class="product-body">
                                    <span
                                        class="product-category border border-primary text-primary text-opacity-75 px-3 py-1 rounded-2 mt-3"></span>
                                    <h3 class="product-title pb-2">{{ $project->name }}</h3>
                                    <p>{{ \Illuminate\Support\Str::limit($project->short_desc, 100) }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--==================clients Section===============================-->
    @include('Website.home-partials.clients')
    <!--==================clients Section===============================-->

</x-website.layout>

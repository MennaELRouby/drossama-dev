<x-website.layout>
    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'blogs')
            @include('Website.partials._banner', ['page_title' => $blog->name])
        @endif
    @endforeach
    <!-- end banner -->
    <!-- start blog details -->
    <section class="article-section py-5 bg-light">
        <div class="container py-5">
            <div class="row g-4">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="mb-5 wow fadeInUp" data-wow-delay="0.1s"
                        style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                        <img src="{{ $blog->image_path }}" alt="{{ $blog->name }}" class="img-fluid rounded-1 shadow">
                    </div>
                    <div class="text-dark lh-lg fw-medium wow fadeInUp" data-wow-delay="0.2s"
                        style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        <h2 class="fw-bold mb-4">{{ $blog->name }}</h2>
                        {!! $blog->long_desc !!}
                    </div>
                </div>
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="bg-white p-4 rounded-1 shadow-sm wow fadeInRight" data-wow-delay="0.3s"
                        style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInRight;">
                        <h3 class="mb-4 fw-bold border-bottom pb-2 wow fadeInRight" data-wow-delay="0.4s"
                            style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">Related
                            Articles</h3>
                        <div class="related-articles">
                            @foreach ($blogs as $relatedBlog)
                                <!-- Article Item  -->
                                <div class="d-flex mb-4 pb-2 border-bottom wow fadeInRight" data-wow-delay="0.5s"
                                    style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInRight;">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $relatedBlog->image_path }}" alt="{{ $relatedBlog->name }}"
                                            class="rounded-1 me-3" width="80" height="80">
                                    </div>
                                    <div class="flex-grow-1 d-grid justify-content-between">
                                        <h5 class="mb-2">
                                            <a href="{{ $relatedBlog->link }}"
                                                class="text-dark text-decoration-none fw-semibold fs-6">
                                                {{ $relatedBlog->name }}
                                            </a>
                                        </h5>
                                        <div class="text-muted small">
                                            <i class="far fa-calendar me-1"></i>{{ $relatedBlog->date }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- start contact -->
    @include('Website.home-partials.contact')
    <!-- end contact -->

</x-website.layout>

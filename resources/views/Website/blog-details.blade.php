<x-website.layout>
    <!-- start banner -->
    @foreach ($sections as $section)
        @if ($section->key == 'blogs')
            @include('Website.partials._banner', ['page_title' => $blog->name])
        @endif
    @endforeach
    <!-- end banner -->
    <!-- start blog details -->
    {{-- <section class="article-section py-5 bg-light">
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
    </section> --}}
    <section class="blog-details">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="blog-details__left">
                        <div class="blog-details__img">
                            <img src="{{ $blog->image_path }}" alt="image">
                        </div>
                        <div class="blog-details__content">
                            <h1 class="blog-details__title">{{$blog->name}}</h1>
                            <p class="blog-details__text-2">
                                {!! $blog->long_desc !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="sidebar">
                        <div class="sidebar__single sidebar__post">
                            <h3 class="sidebar__title">Blogs</h3>
                            <ul class="sidebar__post-list list-unstyled">
                                @foreach ($blogs as $relatedBlog)
                                    <li>
                                        <div class="sidebar__post-image"> <img
                                                src="{{$relatedBlog->image_path}}" alt="image">
                                        </div>
                                        <div class="sidebar__post-content">
                                            <h3> <span class="sidebar__post-content-meta">
                                                </span>
                                                <a href="{{ $relatedBlog->link }}">{{ $relatedBlog->name }}</a>
                                            </h3>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="subscribe-section" style=" margin-bottom:30px;">
                            <div class="bg bg-image"
                                style="background-image: url(../../assets/front/images/background/page-title-bg.png);">
                            </div>
                            <div class="subscribe-form" style="padding-right:15px; padding-left:15px;">
                                <x-website.partials.contact-form />
                            </div>
                        </div>
                        <!--End Form-->
                        <div class="map">
                            @include('Website.home-partials.map')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-website.layout>

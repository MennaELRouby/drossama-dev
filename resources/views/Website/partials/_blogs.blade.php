@if ($blogs->isNotEmpty())
    <!--===============Blogs==============-->

    {{-- <section class="py-5 wow fadeInUp" data-wow-delay="0.5s"
        style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">
        <div class="container py-5 wow fadeInUp" data-wow-delay="0.55s"
            style="visibility: visible; animation-delay: 0.55s; animation-name: fadeInUp;">

            <div class="row g-4 wow fadeInUp" data-wow-delay="0.65s"
                style="visibility: visible; animation-delay: 0.65s; animation-name: fadeInUp;">
                @foreach ($blogs as $blog)
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s"
                        style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                        <div class="card article-card h-100 border-0 overflow-hidden position-relative p-0">
                            <img src="{{ $blog->image_path }}" class="card-img-top" alt="{{ $blog->name }}">
                            <div class="card-body p-4 d-flex flex-column ">
                                <div class="article-meta mb-2 d-flex gap-3"><span>{{ $blog->author->name ?? '' }}</span> •
                                    <span>{{ $blog->date }}</span> </div>
                                <h4 class="article-title  mb-3">{{ $blog->name }}</h4>
                                <hr class="article-divider w-100 my-3">
                                <a href="{{ $blog->link }}" class="btn-send p-3 fs-6">{{ __('website.read_more') }}
                                    <span class="btn-arrow ms-2"><i class="fa-solid fa-arrow-right "></i></span></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- Pagination --}}
    {{--  @if ($blogs->hasPages())
            <div class="row">
                <div class="col-12">
                    <div class="pagination-wrapper text-center mt-5">
                        {{-- Pagination Info --}}
    {{--  <div class="pagination-info mb-3">
                            {{ __('website.pagination.showing') }} <strong>{{ $blogs->firstItem() }}</strong>
                            {{ __('website.pagination.to') }} <strong>{{ $blogs->lastItem() }}</strong>
                            {{ __('website.pagination.of') }} <strong>{{ $blogs->total() }}</strong>
                            {{ __('website.pagination.results') }}
                        </div>

                        {{-- Pagination Links --}}
    {{--  {{ $blogs->appends(request()->query())->links('pagination::custom') }}
                    </div>
                </div>
            </div>
        @endif
    </section> --}}
    <!--===============Blogs==============-->
    <!--===============Blogs==============-->
    <section class="news-section pt-0">
        <div class="container">
            <div class="row">
                @foreach ($blogs as $blog)
                    <!-- News Blog -->
                    <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="300ms">
                        <div class="inner-box">
                            <div class="image-box">
                                <figure class="image"><a href="{{ $blog->link }}"><img src="{{ $blog->image_path }}"
                                            alt="{{ $blog->name }}"></a></figure>

                            </div>
                            <div class="content-box">
                                <h4 class="title"><a href="{{ $blog->link }}">{{ $blog->name }}</a></h4>
                                <a href="{{ $blog->link }}" class="read-more">Read More <i
                                        class="icon fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--===============Blogs==============-->
@endif

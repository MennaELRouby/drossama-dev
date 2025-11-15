    <!--===============Blogs==============-->
        <section class="news-section pt-40">
            <div class="auto-container">
                <div class="row">
                    <div class="sec-title col-lg-6 col-md-8 col-sm-12">
                        <h2>{{ __('website.blogs') }}</h2>
                    </div>
                    <div class="top-btn col-lg-6 col-md-4 col-sm-12">
                        <a href="{{ Path::AppUrl('blogs') }}" class="theme-btn btn-style-one bg-dark"><span class="btn-title">{{ __('website.read_more') }}
                                <i class="icon fa fa-arrow-right"></i></span></a>
                    </div>
                </div>
                <div class="row">
                    @foreach ($blogs as $blog)
                    <!-- News Blog -->
                    <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="300ms">
                        <div class="inner-box">
                            <div class="content-box">
                                <h4 class="title"><a href="{{ $blog->link }}">{{ $blog->name }}</a></h4>
                                <div class="text">
                                    <div>{{ $blog->short_desc }}</div>
                                </div>
                                <a href="{{ $blog->link }}" class="read-more">{{ __('website.read_more') }} <i
                                        class="icon fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    <!--===============Blogs==============-->

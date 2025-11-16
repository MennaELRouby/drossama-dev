@if ($blogs->isNotEmpty())
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

<!-- gallery-page-section end -->

{{-- <section class="services-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                <div class="sec-title">
                    <span class="">HEAR FROM OUR PATIENTS</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="service-video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/a1L75o9HeTo"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="service-video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/Mk0sgwxJVfM"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="service-video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/TzRQYksE3JE"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="service-video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/L1b2jhU698U"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="service-video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/9B5ZgFPLNmo"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="service-video">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/pLBy6rZNB2Y"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- gallery-page-section Start -->
<section class="gallery-page-section ">
    <div class="container">
        <div class="row">
            @foreach ($albums as $album)
                <div class="col-sm-12 col-md-12 col-lg-12 text-center mb-4">
                    <h3>{{ $album->name }}</h3>
                </div>

                @if ($album->images && count($album->images) > 0)
                    @foreach ($album->images as $image)
                        <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                            <figure class="image-box">
                                <a href="{{ $image->image_url }}" class="lightbox-image"
                                    data-fancybox="gallery-{{ $album->id }}">
                                    <img src="{{ $image->image_url }}" alt="{{ $album->name }}" class="img-fluid">
                                </a>
                            </figure>
                        </div>
                    @endforeach
                @else
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                        <figure class="image-box">
                            <a href="{{ asset('storage/albums/' . $album->image) }}" class="lightbox-image"
                                data-fancybox="gallery-{{ $album->id }}">
                                <img src="{{ asset('storage/albums/' . $album->image) }}" alt="{{ $album->name }}"
                                    class="img-fluid">
                            </a>
                        </figure>
                    </div>
                @endif
            @endforeach


        </div>

    </div>
</section> --}}
<div class="services-section-two pull-up pt-5 pb-5">
    <div class="container">
        <div class="row">
            @foreach($gallery_photos as $key=>$album)
            <div class="col-md-4">
                <div class="service-block-two">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="../uploads/album_items/source/38377662.jpeg" class="lightbox-image"
                                    data-fancybox="gallery-{{ $key }}"><img src="../uploads/album_items/source/38377662.jpeg"
                                        alt="Image">
                                </a>

                                <div style="display:none">
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/60888404.jpeg">
                                        <img src="../uploads/album_items/source/60888404.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/45804164.jpeg">
                                        <img src="../uploads/album_items/source/45804164.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/60072829.jpeg">
                                        <img src="../uploads/album_items/source/60072829.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/13600894.jpeg">
                                        <img src="../uploads/album_items/source/13600894.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/40795297.jpeg">
                                        <img src="../uploads/album_items/source/40795297.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/43266345.jpeg">
                                        <img src="../uploads/album_items/source/43266345.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/45438966.jpeg">
                                        <img src="../uploads/album_items/source/45438966.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/94907809.jpeg">
                                        <img src="../uploads/album_items/source/94907809.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/78473964.jpeg">
                                        <img src="../uploads/album_items/source/78473964.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/62459731.jpeg">
                                        <img src="../uploads/album_items/source/62459731.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/70090606.jpeg">
                                        <img src="../uploads/album_items/source/70090606.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/13982516.jpeg">
                                        <img src="../uploads/album_items/source/13982516.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/40066131.jpeg">
                                        <img src="../uploads/album_items/source/40066131.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/77787249.jpeg">
                                        <img src="../uploads/album_items/source/77787249.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/72782167.jpeg">
                                        <img src="../uploads/album_items/source/72782167.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-0" href="../uploads/album_items/source/51522711.jpeg">
                                        <img src="../uploads/album_items/source/51522711.jpeg" />
                                    </a>

                                </div>
                                <h1><a href="../uploads/album_items/source/38377662.jpeg" class="lightbox-image"
                                        data-fancybox="gallery-0">{{ $album->name }}</a> </h1>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-md-4">
                <div class="service-block-two">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="../uploads/album_items/source/88739181.jpeg" class="lightbox-image"
                                    data-fancybox="gallery-1"><img src="../uploads/album_items/source/88739181.jpeg"
                                        alt="Image">
                                </a>

                                <div style="display:none">
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/11505455.jpeg">
                                        <img src="../uploads/album_items/source/11505455.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/53801111.jpeg">
                                        <img src="../uploads/album_items/source/53801111.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/32302821.jpeg">
                                        <img src="../uploads/album_items/source/32302821.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/76632809.jpeg">
                                        <img src="../uploads/album_items/source/76632809.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/93613568.jpeg">
                                        <img src="../uploads/album_items/source/93613568.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/75351831.jpeg">
                                        <img src="../uploads/album_items/source/75351831.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/14909904.jpeg">
                                        <img src="../uploads/album_items/source/14909904.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/75244399.jpeg">
                                        <img src="../uploads/album_items/source/75244399.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/19225438.jpeg">
                                        <img src="../uploads/album_items/source/19225438.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/36117480.jpeg">
                                        <img src="../uploads/album_items/source/36117480.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/53474390.jpeg">
                                        <img src="../uploads/album_items/source/53474390.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/91061656.jpeg">
                                        <img src="../uploads/album_items/source/91061656.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-1" href="../uploads/album_items/source/94185057.jpeg">
                                        <img src="../uploads/album_items/source/94185057.jpeg" />
                                    </a>

                                </div>
                                <h1><a href="../uploads/album_items/source/88739181.jpeg" class="lightbox-image"
                                        data-fancybox="gallery-1">lower Blepharoplasty</a> </h1>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-block-two">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="../uploads/album_items/source/90090613.jpeg" class="lightbox-image"
                                    data-fancybox="gallery-2"><img src="../uploads/album_items/source/90090613.jpeg"
                                        alt="Image">
                                </a>

                                <div style="display:none">
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/17442312.jpeg">
                                        <img src="../uploads/album_items/source/17442312.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/47005675.jpeg">
                                        <img src="../uploads/album_items/source/47005675.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/82025797.jpeg">
                                        <img src="../uploads/album_items/source/82025797.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/87489670.jpeg">
                                        <img src="../uploads/album_items/source/87489670.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/35708764.jpeg">
                                        <img src="../uploads/album_items/source/35708764.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/46853722.jpeg">
                                        <img src="../uploads/album_items/source/46853722.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/46197113.jpeg">
                                        <img src="../uploads/album_items/source/46197113.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/72732897.jpeg">
                                        <img src="../uploads/album_items/source/72732897.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/20107459.jpeg">
                                        <img src="../uploads/album_items/source/20107459.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/77758455.jpeg">
                                        <img src="../uploads/album_items/source/77758455.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/96476682.jpeg">
                                        <img src="../uploads/album_items/source/96476682.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/55626615.jpeg">
                                        <img src="../uploads/album_items/source/55626615.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/86514841.jpeg">
                                        <img src="../uploads/album_items/source/86514841.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-2" href="../uploads/album_items/source/35367934.jpeg">
                                        <img src="../uploads/album_items/source/35367934.jpeg" />
                                    </a>

                                </div>
                                <h1><a href="../uploads/album_items/source/90090613.jpeg" class="lightbox-image"
                                        data-fancybox="gallery-2">PTOSIS REPAIR</a> </h1>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-block-two">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="../uploads/album_items/source/75948414.jpeg" class="lightbox-image"
                                    data-fancybox="gallery-3"><img src="../uploads/album_items/source/75948414.jpeg"
                                        alt="Image">
                                </a>

                                <div style="display:none">
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/54741750.jpeg">
                                        <img src="../uploads/album_items/source/54741750.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/93651126.jpeg">
                                        <img src="../uploads/album_items/source/93651126.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/56782123.jpeg">
                                        <img src="../uploads/album_items/source/56782123.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/21657186.jpeg">
                                        <img src="../uploads/album_items/source/21657186.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/31607794.jpeg">
                                        <img src="../uploads/album_items/source/31607794.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/92982564.jpeg">
                                        <img src="../uploads/album_items/source/92982564.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/70791291.jpeg">
                                        <img src="../uploads/album_items/source/70791291.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/92695608.jpeg">
                                        <img src="../uploads/album_items/source/92695608.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/90225350.jpeg">
                                        <img src="../uploads/album_items/source/90225350.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/75281042.jpeg">
                                        <img src="../uploads/album_items/source/75281042.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/28219133.jpeg">
                                        <img src="../uploads/album_items/source/28219133.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/75016010.jpeg">
                                        <img src="../uploads/album_items/source/75016010.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/58776868.jpeg">
                                        <img src="../uploads/album_items/source/58776868.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/67986670.jpeg">
                                        <img src="../uploads/album_items/source/67986670.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/31638912.jpeg">
                                        <img src="../uploads/album_items/source/31638912.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/84248927.jpeg">
                                        <img src="../uploads/album_items/source/84248927.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/80074207.jpeg">
                                        <img src="../uploads/album_items/source/80074207.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/17872928.jpeg">
                                        <img src="../uploads/album_items/source/17872928.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/40116427.jpeg">
                                        <img src="../uploads/album_items/source/40116427.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/20321119.jpeg">
                                        <img src="../uploads/album_items/source/20321119.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/89331259.jpeg">
                                        <img src="../uploads/album_items/source/89331259.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/98550065.jpeg">
                                        <img src="../uploads/album_items/source/98550065.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-3" href="../uploads/album_items/source/97928529.jpeg">
                                        <img src="../uploads/album_items/source/97928529.jpeg" />
                                    </a>

                                </div>
                                <h1><a href="../uploads/album_items/source/75948414.jpeg" class="lightbox-image"
                                        data-fancybox="gallery-3">CONVERGENT SQUINT</a> </h1>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-block-two">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="../uploads/album_items/source/23129658.jpeg" class="lightbox-image"
                                    data-fancybox="gallery-4"><img src="../uploads/album_items/source/23129658.jpeg"
                                        alt="Image">
                                </a>

                                <div style="display:none">
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/35249484.jpeg">
                                        <img src="../uploads/album_items/source/35249484.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/66517507.jpeg">
                                        <img src="../uploads/album_items/source/66517507.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/18495075.jpeg">
                                        <img src="../uploads/album_items/source/18495075.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/56749113.jpeg">
                                        <img src="../uploads/album_items/source/56749113.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/38680766.jpeg">
                                        <img src="../uploads/album_items/source/38680766.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/36779678.jpeg">
                                        <img src="../uploads/album_items/source/36779678.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/84687657.jpeg">
                                        <img src="../uploads/album_items/source/84687657.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/35310447.jpeg">
                                        <img src="../uploads/album_items/source/35310447.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/88610671.jpeg">
                                        <img src="../uploads/album_items/source/88610671.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/98922026.jpeg">
                                        <img src="../uploads/album_items/source/98922026.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/49633836.jpeg">
                                        <img src="../uploads/album_items/source/49633836.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/16138738.jpeg">
                                        <img src="../uploads/album_items/source/16138738.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/89295272.jpeg">
                                        <img src="../uploads/album_items/source/89295272.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-4" href="../uploads/album_items/source/64033583.jpeg">
                                        <img src="../uploads/album_items/source/64033583.jpeg" />
                                    </a>

                                </div>
                                <h1><a href="../uploads/album_items/source/23129658.jpeg" class="lightbox-image"
                                        data-fancybox="gallery-4">DIVEGENT SQUINT</a> </h1>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-block-two">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="../uploads/album_items/source/91870001.jpeg" class="lightbox-image"
                                    data-fancybox="gallery-5"><img src="../uploads/album_items/source/91870001.jpeg"
                                        alt="Image">
                                </a>

                                <div style="display:none">
                                    <a data-fancybox="gallery-5" href="../uploads/album_items/source/12028798.jpeg">
                                        <img src="../uploads/album_items/source/12028798.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-5" href="../uploads/album_items/source/42399233.jpeg">
                                        <img src="../uploads/album_items/source/42399233.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-5" href="../uploads/album_items/source/32820922.jpeg">
                                        <img src="../uploads/album_items/source/32820922.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-5" href="../uploads/album_items/source/90615748.jpeg">
                                        <img src="../uploads/album_items/source/90615748.jpeg" />
                                    </a>
                                    <a data-fancybox="gallery-5" href="../uploads/album_items/source/60810306.jpeg">
                                        <img src="../uploads/album_items/source/60810306.jpeg" />
                                    </a>

                                </div>
                                <h1><a href="../uploads/album_items/source/91870001.jpeg" class="lightbox-image"
                                        data-fancybox="gallery-5">VERTICAL SQUINT</a> </h1>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

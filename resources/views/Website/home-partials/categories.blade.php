@if ($categories->isNotEmpty())
<!--==========================Categories==========================-->
<section class="homeproject-area py-128">
    <div class="container">
        <div class="row section-heading rel z-1 justify-content-center mb-96">
            <div class="section-title text-center wow fadeInUp delay-0-2s">
                <div class="sub-title mb-16">
                    <span class="dot-b"></span>
                    <span class="line"></span>
                    <span class="text">{{ \App\Helpers\Helper::getConfig('app_name', app()->getLocale()) }}</span>
                    <span class="line"></span>
                    <span class="dot-a"></span>
                </div>
                <h2 class="wow fadeInUp delay-0-2s">{{ trans('home.products') }}</h2>
            </div>
        </div>
        <!-- قائمة التصنيفات -->
        <div class="tab-content tab-pane project-active">
            @foreach($categories as $index => $categorie)
            @if($index % 2 == 0)
            <div class="row align-items-center odd-pro item category-{{ $index }}">
                <div class="col-lg-8 wow fadeInLeft delay-0-1s pro-img">
                    <a href="{{ url('category/' . $categorie->{'link_' . $lang} . '/projects') }}"><img src="{{url('uploads/categories/source/' , $categorie->image) }}" alt="Apartment"></a>
                </div>
                <div class="col-lg-4 wow fadeInRight delay-0-1s pro-content">
                    <div class="home-projects-content black-120-bg text-center">
                        <a href="{{ url('category/' . $categorie->{'link_' . $lang} . '/projects') }}">
                            <h3>{{ $categorie->{'name_' .$lang} }} </h3>
                        </a>
                        <div class="home-pro-desc mb-20">
                            <p>{!! $categorie->{'desc_' .$lang} !!}</p>
                        </div>
                        <div class="button-pri mt-16 button-left">
                            <a class="theme-btn text-center" href="{{ url('category/' . $categorie->{'link_' . $lang} . '/projects') }}"><i class="fa fa-solid fa-arrow-right"></i><br> Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row align-items-center even-pro item category-{{ $index }}">
                <div class="col-lg-4 wow fadeInRight delay-0-1s pro-content">
                    <div class="home-projects-content black-120-bg text-center">
                        <a href="{{ url('category/' . $categorie->{'link_' . $lang} . '/projects') }}">
                            <h3>{{ $categorie->{'name_' .$lang} }}</h3>
                        </a>
                        <div class="home-pro-desc mb-20">
                            <p>{!! $categorie->{'desc_' .$lang} !!}</p>
                        </div>
                        <div class="button-pri mt-16 button-left">
                            <a class="theme-btn text-center" href="{{ url('category/' . $categorie->{'link_' . $lang} . '/projects') }}"><i class="fa fa-solid fa-arrow-right"></i><br> Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 wow fadeInLeft delay-0-1s pro-img">
                    <a href="{{ url('category/' . $categorie->{'link_' . $lang} . '/projects') }}"><img src="{{url('uploads/categories/source/' , $categorie->image) }}" alt="Apartment"></a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <div class="col-12 text-center">
            <div class="button-pri mt-64 button-left">
                <a class="theme-btn text-center" href="{{LaravelLocalization::localizeUrl('categories')}}"><i class="fa fa-solid fa-arrow-right"></i><br> {{ trans('home.More products') }}</a>
            </div>
        </div>
    </div>
</section>
<!--==========================Categories==========================-->
@endif
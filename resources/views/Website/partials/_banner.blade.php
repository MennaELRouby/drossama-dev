<section class="page-title" style="background-image: url('{{ $section->image_path }}');">
    <div class="auto-container">
        <div class="title-outer d-sm-flex align-items-center justify-content-sm-between">
            <h2 class="title">{{ $section->title }}</h2>

            <ul class="page-breadcrumb">
                <li><a href="{{ Path::AppUrl('home') }}">{{ __('website.home') }}</a></li>
                <li>{{ $section->title }}</li>
            </ul>
        </div>
    </div>
</section>


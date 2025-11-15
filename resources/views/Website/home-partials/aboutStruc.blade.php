{{-- @php
    $aboutStrucTitles = $titles->where('type', 'aboutStruc');
@endphp
<section class="work-process2">
    <div class="container">
        <div class="section-title center">
            <h2 class="title">{{ trans('home.vission') }}</h2>
        </div>
        <div class="row">
            @php $count = count($aboutStrucs); @endphp
            @foreach($aboutStrucs as $index => $aboutStruc)
            <div class="col-lg-4 col-xl-{{ $count == 2 ? '6' : ($index == 1 ? '6' : '3') }}">
                <div class="process-item">
                    <div class="icon">
                        <span class="three-dimensional-number">{{ $index + 1 }}</span>
                    </div>                        
                    <div class="content">
                        <h3 class="title">{{ $aboutStruc->{'title_' .$lang} ?? 'Zatri Group' }}</h3>
                        <p class="description">{!!  $aboutStruc->{'text_' .$lang} ?? 'Default description here' !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="line">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
</section> --}}



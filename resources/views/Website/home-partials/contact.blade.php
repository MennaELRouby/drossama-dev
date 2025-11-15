<!-- <================================================================= StartContactForm =======================================================> -->
        <section class="subscribe-section">
            <div class="bg bg-image" style="background-image: url(uploads/titles/source/68715da79a5f6.png);"></div>
            <div class="auto-container">
                <div class="outer-box">
                    <div class="row">
                        @foreach ($sections as $section)
                            @if ($section->key == 'contact')
                                <div class="title-column col-lg-4 col-md-12">
                                    <div class="inner-column">
                                        <h2 class="title">{{ $section->title }}</h2>
                                        <div class="text">{!! $section->short_desc !!}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <!-- Form Column -->
                        <div class="form-column col-lg-8 col-md-12 col-sm-12">
                            <div class="subscribe-form">
                               <x-website.partials.contact-form />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<!-- <======================= EndContactForm =========================> -->

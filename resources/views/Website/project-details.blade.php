<x-website.layout>
  <!-- start banner -->
    <!-- start banner -->
    @foreach($sections as $section)
        @if($section->key == 'projects')
        @include('Website.partials._banner', ['page_title' => $project->name])
        @endif
    @endforeach
    <!-- end banner -->
  <!-- end banner -->

  <section class="py-5">
      <div class="container py-5">
        <!-- Product Details Section -->
        <div class="row gy-5 mb-5 wow fadeInUp" data-wow-delay="0.1s">

          <div
            class="col-lg-12 position-relative wow fadeInLeft"
            data-wow-delay="0.2s"
          >
            <!-- الصورة الرئيسية مع زر التكبير -->
            <img
              id="mainHDFImage"
              src="{{$project->image_path}}"
              alt="{{$project->name}}"
              class="w-100 rounded-4 shadow object-fit-cover wow zoomIn"
              data-wow-delay="0.4s"
              height="500"
            />

            <div class="row mt-4">
              <!-- الصور المصغرة -->
              @foreach($project->images as $image)
              <div
                class="col-lg-4 col-4 mb-3 wow fadeInUp"
                data-wow-delay="0.4s"
              >
                <div
                  class="thumbnail-item"
                  data-fullimg="{{$image->image_url}}"
                  data-caption="{{$project->name}}"
                >
                  <img
                    src="{{$image->image_url}}"
                    class="w-100 object-fit-cover rounded-4"
                    alt="{{$project->name}}"
                  />
                </div>
              </div>
              @endforeach
            </div>
            <div
              class="project-overview mt-4 wow fadeInUp"
              data-wow-delay="0.7s"
            >
              <h3 class="fs-2 mb-3 text-main">{{$project->name}}</h3>
              <p class="lh-lg text-muted">
                {!! $project->long_desc !!}
              </p>
            </div>

            
          </div>
        </div>
      </div>
    </section>
    
</x-website.layout>

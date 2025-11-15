<!--===================== StartProjects =========================-->
{{-- <section class="project-section pt_10 centred">
   <div class="outer-container">
         <div class="sec-title text-center">
            
            <h2>{{ trans('home.galleryImages') }} </h2>
            <div class="decor">
               <img src="assets/images/shape/decor.png" alt="">
            </div>
         </div>
         <div class="project-carousel owl-carousel owl-theme owl-dots-none owl-nav-none">
            @foreach ($galleryImages as $galleryImage)
            <div class="single-gallery-item">
               <div class="img-holder">
                     <img src="{{ $galleryImage->img }}" alt="Awesome Image">
                     <div class="overlay-content text-center">
                        <div class="zoom-button">
                           <a class="lightbox-image" data-fancybox="gallery"
                                 href="{{ $galleryImage->img }}">
                                 <i class="flaticon-plus"></i>
                           </a>
                        </div>
                        <div class="inner">
                           <div class="border-box"></div>
                        </div>
                     </div>
               </div>
            </div>
            @endforeach
         </div>
   </div>
</section> --}}
<!--===================== EndProjects =====================-->

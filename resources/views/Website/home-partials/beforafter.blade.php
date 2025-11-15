   @if ($beforeAfters->isNotEmpty())
       <section class="content-inner bg-light bg-bottom-half-white">
           <div class="container">
               <div class="section-head style-3 text-center m-b30 wow fadeInUp" data-wow-delay="0.2s"
                   data-wow-duration="0.8s">
                   <h2 class="title m-b0">{{ trans('home.beforeAfters') }}</h2>
               </div>
               <div class="row m-b30">
                   @foreach ($beforeAfters as $item)
                       <div class="col-md-6 m-b15 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.8s">
                           <div class="aurel_widget_pm_before_after_link">
                               <div class="aurel_widget_container">
                                   <div class="aurel_before_after_wrapper aurel_no_select">
                                       <div class="aurel_before_after">
                                           <img src="{{ url('uploads/beforeAfters/source/' . $item->before_img) }}"
                                               width="1170" height="780" class="aurel_before_image"
                                               alt="Before" />

                                           <div class="aurel_after_image">
                                               <img src="{{ url('uploads/beforeAfters/source/' . $item->after_img) }}"
                                                   width="1170" height="780" class="aurel_after_img"
                                                   alt="After" />
                                           </div>

                                           <div class="aurel_before_after_divider">
                                               <span class="aurel_before_after_left"></span>
                                               <span class="aurel_before_after_right"></span>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   @endforeach
               </div>
           </div>
       </section>
   @endif

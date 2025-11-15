   @if ($teams->isNotEmpty())
       <!--==================================== Team =============================================== -->
       <div class="page-team">
           <div class="container">
               <div class="row section-row align-items-center">
                   @foreach ($teamsTitle as $teamTitle)
                       <div class="col-lg-12">
                           <div class="section-title section-title-center">
                               <h3 class="wow fadeInUp">
                                   {{ $teamTitle->title }}
                               </h3>
                               <h2 data-cursor="-opaque">
                                   {{ $teamTitle->title1 }}
                               </h2>
                           </div>
                       </div>
                   @endforeach
               </div>
               <div class="row">
                   @foreach ($teams as $team)
                       <div class="col-lg-3 col-md-6">
                           <div class="team-item wow fadeInUp">
                               <div class="team-image">
                                   <a href="#" data-cursor-text="View">
                                       <figure class="image-anime">
                                           <img src="{{ $team->img }}" alt="img">
                                       </figure>
                                   </a>
                               </div>
                               <!-- Team Image End -->
                               <!-- Team Body Start -->
                               <div class="team-body">
                                   <!-- Team Content Start -->
                                   <div class="team-content">
                                       <h3><a href="#">{{ $team->name }}</a></h3>
                                   </div>
                                   <!-- Team Content End -->
                                   {{-- <div class="team-social-icons">
                                <ul>
                                    <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                                </ul>
                            </div> --}}
                                   <!-- Team Social Icons End -->
                               </div>
                               <!-- Team Body End -->
                           </div>
                       </div>
                   @endforeach
               </div>
           </div>
       </div>
       <!--==================================== Team =============================================== -->
   @endif

           <section class="custom-testimonials-section">
               <div class="auto-container" style="max-width:1200px; margin:auto;">
                   <div class="sec-title text-center light">
                       <h2 style="color: #4b92fe;">{{ __('website.testimonials') }}</h2>
                   </div>

                   <div
                       style="display:flex; flex-wrap:wrap; gap:40px; align-items:center; justify-content:space-between;">
                       <!-- يسار: التبويبات والفيديو -->
                       <div style="flex:1; min-width:350px; max-width:600px;">
                           <div style="display:flex; gap:10px; margin-bottom:30px;">
                               @foreach ($testimonials as $testimonial)
                                   <button class="testimonial-tab active" data-video="{{ $testimonial->video_link }}">
                                       {{ $loop->iteration }}
                                   </button>
                               @endforeach
                           </div>

                           <div class="testimonial-video-box"
                               style="background:#222; border-radius:12px; padding:20px; text-align:center;">
                               <div id="yt-lazy-container"
                                   style="position:relative;width:100%;max-width:100%;height:315px;cursor:pointer;overflow:hidden;border-radius:8px;">
                                   <!-- الصورة ستظهر من جافاسكربت -->
                               </div>
                           </div>

                           <div class="btn-box wow fadeInUp animated text-center pt-5"
                               style="visibility: visible; animation-name: fadeInUp;">
                               <a href="{{ Path::AppUrl('testimonials') }}" class="theme-btn btn-style-one">
                                   <span class="btn-title">{{ __('website.read_more') }}
                                       <i class="icon fa fa-arrow-right"></i></span>
                               </a>
                           </div>
                       </div>
                       @foreach($sections as $section)
                       @if($section->key == 'testimonial')
                       <!-- يمين: صورة الطبيب -->
                       <div style="flex:1; min-width:300px; text-align:center;">
                           <img src="{{ $section->image_path }}" alt="{{ $section->name }}"
                               style="max-width:100%; border-radius:16px; box-shadow:0 4px 24px #0005;">
                       </div>
                       @endif
                       @endforeach
                   </div>
               </div>
           </section>

           <!-- Testimonials -->
           <!-- Scripts -->
           <script>
               function getYoutubeId(val) {
                   try {
                       if (!val) {
                           console.error('getYoutubeId: Video URL is empty or null');
                           return '';
                       }

                       // Remove whitespace and normalize URL
                       val = val.trim();

                       // Handle video ID with extra parameters (e.g., NR_ftmgGAy0?si=LEU84u5j-oH7pAkN)
                       const cleanVal = val.split('?')[0]; // Remove everything after '?'
                       if (/^[a-zA-Z0-9_-]{11}$/.test(cleanVal)) {
                           console.log('getYoutubeId: Direct video ID detected', cleanVal);
                           return cleanVal;
                       }

                       // Expanded patterns to handle more YouTube URL formats
                       const patterns = [
                           /(?:youtube\.com.*(?:\?|&)v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/v\/|youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/,
                           /(?:youtube\.com.*watch.*v=)([a-zA-Z0-9_-]{11})/,
                           /(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/
                       ];

                       for (let pattern of patterns) {
                           const match = val.match(pattern);
                           if (match && match[1]) {
                               console.log('getYoutubeId: Extracted video ID', match[1], 'from URL', val);
                               return match[1];
                           }
                       }

                       // Try parsing as URL
                       const url = new URL(val.includes('://') ? val : `https://${val}`);
                       const videoId = url.searchParams.get('v') || '';
                       if (videoId) {
                           console.log('getYoutubeId: Extracted video ID from URL params', videoId, 'from URL', val);
                           return videoId;
                       }

                       console.error('getYoutubeId: Could not extract video ID from URL', val);
                       return '';
                   } catch (e) {
                       console.error('getYoutubeId: Error parsing URL', val, e);
                       return '';
                   }
               }

               function loadYT(videoUrl) {
                   const videoId = getYoutubeId(videoUrl);
                   if (!videoId) {
                       console.error('loadYT: Invalid or empty video ID', videoUrl);
                       return;
                   }
                   const iframe = document.createElement('iframe');
                   iframe.width = '100%';
                   iframe.height = '315';
                   iframe.src =
                       `https://www.youtube.com/embed/${videoId}?rel=0&showinfo=0`; // Added showinfo=0 to hide video title
                   iframe.title = 'YouTube video player';
                   iframe.frameBorder = '0';
                   iframe.allow =
                       "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share";
                   iframe.allowFullscreen = true;
                   iframe.style.borderRadius = '8px';
                   const container = document.getElementById('yt-lazy-container');
                   if (!container) {
                       console.error('loadYT: Container #yt-lazy-container not found');
                       return;
                   }
                   container.innerHTML = '';
                   container.appendChild(iframe);
                   console.log('loadYT: Attempting to load iframe with src', iframe.src);
               }

               function getThumbnailHTML(videoId) {
                   if (!videoId) {
                       console.error('getThumbnailHTML: Video ID is empty');
                       return '<div style="width:100%;height:315px;background:#222;color:#fff;text-align:center;line-height:315px;">No video available</div>';
                   }
                   const thumbnailUrls = [
                       `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`,
                       `https://img.youtube.com/vi/${videoId}/mqdefault.jpg`,
                       `https://img.youtube.com/vi/${videoId}/default.jpg`
                   ];
                   return `
        <img src="${thumbnailUrls[0]}"
            alt="YouTube Thumbnail"
            style="width:100%;height:100%;object-fit:cover;display:block;"
            onerror="this.src='${thumbnailUrls[1]}'; this.onerror=function(){this.src='${thumbnailUrls[2]}'; this.onerror=function(){this.parentNode.innerHTML='<div style=\\'width:100%;height:315px;background:#222;color:#fff;text-align:center;line-height:315px;\\'>Failed to load thumbnail</div>';}">
        <span style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:rgba(0,0,0,0.5);border-radius:50%;padding:18px;">
            <svg width="36" height="36" viewBox="0 0 36 36" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                <circle cx="18" cy="18" r="18" fill="#4b92fe" />
                <polygon points="14,11 26,18 14,25" fill="#fff" />
            </svg>
        </span>
    `;
               }

               document.addEventListener('DOMContentLoaded', function() {
                   const tabs = document.querySelectorAll('.testimonial-tab');
                   const container = document.getElementById('yt-lazy-container');

                   if (!tabs.length || !container) {
                       console.error('DOMContentLoaded: No tabs or container found', {
                           tabs: tabs.length,
                           container: !!container
                       });
                       return;
                   }

                   // Activate first tab and set thumbnail
                   tabs.forEach(t => {
                       t.classList.remove('active');
                       t.style.background = '#fff';
                       t.style.color = '#111';
                   });
                   tabs[0].classList.add('active');
                   tabs[0].style.background = '#4b92fe';
                   tabs[0].style.color = '#fff';

                   const videoUrl = tabs[0].getAttribute('data-video');
                   console.log('DOMContentLoaded: Initial video URL', videoUrl);
                   const videoId = getYoutubeId(videoUrl);
                   console.log('DOMContentLoaded: Initial video ID', videoId);
                   container.setAttribute('data-video', videoUrl);
                   container.innerHTML = getThumbnailHTML(videoId);

                   // Load video on container click
                   container.addEventListener('click', function() {
                       const videoUrl = container.getAttribute('data-video');
                       console.log('Container clicked: Loading video', videoUrl);
                       loadYT(videoUrl);
                   });

                   // Handle tab clicks
                   tabs.forEach(function(tab) {
                       tab.addEventListener('click', function() {
                           tabs.forEach(t => {
                               t.classList.remove('active');
                               t.style.background = '#fff';
                               t.style.color = '#111';
                           });
                           tab.classList.add('active');
                           tab.style.background = '#4b92fe';
                           tab.style.color = '#fff';

                           const videoUrl = tab.getAttribute('data-video');
                           const videoId = getYoutubeId(videoUrl);
                           console.log('Tab clicked: Video URL', videoUrl, 'Video ID', videoId);
                           container.setAttribute('data-video', videoUrl);
                           container.innerHTML = getThumbnailHTML(videoId);
                       });
                   });
               });
           </script>
           {{-- <section class="content-inner pt-0">
        <div class="container">
            @foreach ($testimonialTitle as $title)
                <div class="section-head style-1 text-center wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.8s">
                    <h2 class="title m-b10">{{ $title->title }}</h2>
                    <p>{{ $title->title1 }}</p>
                </div>
            @endforeach
            <div class="swiper testimonial-swiper3 testimonial-wrapper3 wow fadeInUp" data-wow-delay="0.4s"
                data-wow-duration="0.8s">
                <div class="swiper-wrapper">
                    @foreach ($testimonials as $testimonial)
                        <div class="swiper-slide">
                            <div class="testimonial-3">
                                <div class="testimonial-media">
                                    <img src="{{ $testimonial->img }}" alt="">
                                    <div class="item1">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="testimonial-pagination-swiper3 swiper-pagination style-1"></div>
            </div>
        </div>
    </section> --}}
           <!-- Testimonials -->

@php use Illuminate\Support\Facades\Request; @endphp
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <!-- === MAIN === -->
                <li class="menu-title" data-key="t-menu">{{ __('dashboard.menus') }}</li>

                <!-- Website -->
                <li>
                    <a href="{{ Path::AppUrl('/') }}" target="_blank">
                        <i class="fas fa-globe"></i>
                        <span>{{ __('dashboard.website') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.home') }}">
                        <i class="fas fa-globe"></i>
                        <span>{{ __('dashboard.dashboard') }}</span>
                    </a>
                </li>
                {{-- <li class="@if (Request::segment(3) == '') mm-active @endif">
                    <a href="{{ route('dashboard.scan.scan') }}" target="_blank">
                        <i class="fas fa-shield-alt"></i>
                        <span data-key="t-dashboard">{{ trans('dashboard.scan') }}</span>
                    </a>
                </li> --}}
                @can('statistics.view')
                    <li>
                        <a href="{{ route('dashboard.statistics.index') }}">
                            <i class="fas fa-chart-bar"></i>
                            <span>{{ __('dashboard.statistics') }}</span>
                        </a>
                    </li>
                @endcan

                @can('contact_messages.view')
                    <li>
                        <a href="{{ route('dashboard.contact_messages.index') }}">
                            <i class="fas fa-envelope"></i>
                            <span>{{ __('dashboard.contact_messages') }}</span>
                        </a>
                    </li>
                @endcan


                @can('subscribers.view')
                    <li>
                        <a href="{{ route('dashboard.subscribers.index') }}">
                            <i class="fas fa-users"></i>
                            <span>{{ __('dashboard.subscribers') }}</span>
                        </a>
                    </li>
                @endcan

                <!-- === CONTENT MANAGEMENT === -->
                @can('menus.view')
                    <li>
                        <a href="{{ route('dashboard.menus.index') }}">
                            <i class="fas fa-list-alt"></i>
                            <span>{{ __('dashboard.menus') }}</span>
                        </a>
                    </li>
                @endcan

                @can('sliders.view')
                    <li>
                        <a href="{{ route('dashboard.sliders.index') }}">
                            <i class="fas fa-images"></i>
                            <span>{{ __('dashboard.sliders') }}</span>
                        </a>
                    </li>
                @endcan

                @can('sections.view')
                    <li>
                        <a href="{{ route('dashboard.sections.index') }}">
                            <i class="fas fa-th-large"></i>
                            <span>{{ __('dashboard.sections') }}</span>
                        </a>
                    </li>
                @endcan
                <!-- === SERVICES & PRODUCTS === -->
                @can('categories.view')
                    <li>
                        <a href="{{ route('dashboard.categories.index') }}">
                            <i class="bx bx-git-branch "></i>
                            <span>{{ __('dashboard.categories') }}</span>
                        </a>
                    </li>
                @endcan
                @can('services.view')
                    <li>
                        <a href="{{ route('dashboard.services.index') }}">
                            <i class="fas fa-concierge-bell"></i>
                            <span>{{ __('dashboard.services') }}</span>
                        </a>
                    </li>
                @endcan

                @can('products.view')
                    <li>
                        <a href="{{ route('dashboard.products.index') }}">
                            <i class="fas fa-box"></i>
                            <span>{{ __('dashboard.products') }}</span>
                        </a>
                    </li>
                @endcan

                @can('projects.view')
                    <li>
                        <a href="{{ route('dashboard.projects.index') }}">
                            <i class="fas fa-box"></i>
                            <span>{{ __('dashboard.projects') }}</span>
                        </a>
                    </li>
                @endcan

                <!-- === ALBUMS === -->
                @can('albums.view')
                    <li>
                        <a href="{{ route('dashboard.albums.index') }}">
                            <i class="fas fa-box"></i>
                            <span>{{ __('dashboard.albums') }}</span>
                        </a>
                    </li>
                @endcan
                @can('faqs.view')
                    <li>
                        <a href="{{ route('dashboard.faqs.index') }}">
                            <i class="fas fa-question-circle"></i>
                            <span>{{ __('dashboard.faqs') }}</span>
                        </a>
                    </li>
                @endcan

                @can('testimonials.view')
                    <li>
                        <a href="{{ route('dashboard.testimonials.index') }}">
                            <i class="fas fa-comment-dots"></i>
                            <span>{{ __('dashboard.testimonials') }}</span>
                        </a>
                    </li>
                @endcan

                @can('gallery_videos.view')
                    <li>
                        <a href="{{ route('dashboard.gallery_videos.index') }}">
                            <i class="fas fa-video"></i>
                            <span>{{ __('dashboard.gallery_videos') }}</span>
                        </a>
                    </li>
                @endcan

                @can('pages.view')
                    <li>
                        <a href="{{ route('dashboard.pages.index') }}">
                            <i class="fas fa-file-alt"></i>
                            <span data-key="t-dashboard">{{ __('dashboard.pages') }}</span>
                        </a>
                    </li>
                @endcan

                <!-- === ABOUT === -->
                @can('about.edit')
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i class="fas fa-info-circle"></i>
                            <span>{{ __('dashboard.about_us') }}</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('about.edit')
                                <li><a href="{{ route('dashboard.about.edit') }}">{{ __('dashboard.about_us') }}</a></li>
                            @endcan
                            @can('about_structs.view')
                                <li><a
                                        href="{{ route('dashboard.about-structs.index') }}">{{ __('dashboard.about_structs') }}</a>
                                </li>
                            @endcan
                            @can('benefits.view')
                                <li><a href="{{ route('dashboard.benefits.index') }}">{{ __('dashboard.benefits') }}</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan


                @can('plans.view')
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i class="fas fa-boxes"></i>
                            <span>{{ __('dashboard.plans') }}</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('attributes.view')
                                <li><a href="{{ route('dashboard.attributes.index') }}">{{ __('dashboard.attributes') }}</a>
                                </li>
                            @endcan
                            @can('plans.view')
                                <li><a href="{{ route('dashboard.plans.index') }}">{{ __('dashboard.plans') }}</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                <!-- === HOSTING & DOMAINS === -->
                @can('hostings.view')
                    <li>
                        <a href="{{ route('dashboard.hostings.index') }}">
                            <i class="fas fa-server"></i>
                            <span>{{ __('dashboard.hostings') }}</span>
                        </a>
                    </li>
                @endcan

                @can('domains.view')
                    <li>
                        <a href="{{ route('dashboard.domains.index') }}">
                            <i class="fas fa-globe-americas"></i>
                            <span>{{ __('dashboard.domains') }}</span>
                        </a>
                    </li>
                @endcan

                <!-- === BLOG === -->
                @can('blogs.view')
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i class="fas fa-blog"></i>
                            <span>{{ __('dashboard.blogs') }}</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('blog_categories.view')
                                <li><a
                                        href="{{ route('dashboard.blog_categories.index') }}">{{ __('dashboard.blog_categories') }}</a>
                                </li>
                            @endcan
                            @can('authors.view')
                                <li><a href="{{ route('dashboard.authors.index') }}">{{ __('dashboard.authors') }}</a></li>
                            @endcan
                            @can('blogs.view')
                                <li><a href="{{ route('dashboard.blogs.index') }}">{{ __('dashboard.blogs') }}</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                <!-- === JOBS & CAREERS === -->
                @can('job_positions.view')
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i class="fas fa-user-tie"></i>
                            <span>{{ __('dashboard.job_positions') }}</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('job_positions.view')
                                <li><a
                                        href="{{ route('dashboard.job_positions.index') }}">{{ __('dashboard.job_positions') }}</a>
                                </li>
                            @endcan
                            @can('career_applications.view')
                                <li><a
                                        href="{{ route('dashboard.career_applications.index') }}">{{ __('dashboard.career_applications') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                <!-- === CLIENTS & PARTENERS === -->
                @can('clients.view')
                    <li>
                        <a href="{{ route('dashboard.clients.index') }}">
                            <i class="fas fa-user-friends"></i>
                            <span>{{ __('dashboard.clients') }}</span>
                        </a>
                    </li>
                @endcan

                @can('parteners.view')
                    <li>
                        <a href="{{ route('dashboard.parteners.index') }}">
                            <i class="fas fa-user-friends"></i>
                            <span>{{ __('dashboard.parteners') }}</span>
                        </a>
                    </li>
                @endcan

                <!-- === SITE ADDRESSES === -->
                @can('site_addresses.view')
                    <li>
                        <a href="{{ route('dashboard.site-addresses.index') }}">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ __('dashboard.site_addresses') }}</span>
                        </a>
                    </li>
                @endcan

                {{-- @can('phones.view') --}}
                <li>
                    <a href="{{ route('dashboard.phones.index') }}">
                        <i class="fas fa-phone"></i>
                        <span>{{ __('dashboard.phones') }}</span>
                    </a>
                </li>
                {{-- @endcan --}}
                <li>
                    <a href="javascript:void(0);" class="has-arrow">
                        <i class="fas fa-cogs"></i>
                        <span>{{ __('dashboard.seo') }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('dashboard.generate-sitemap') }}" target="_blank">
                                <i class="fas fa-globe"></i>
                                <span> Generate Sitemap</span>
                            </a>
                        </li>
                        @can('seo_assistants.view')
                            <li><a
                                    href="{{ route('dashboard.seo-assistants.index') }}">{{ __('dashboard.seo_assistant') }}</a>
                            </li>
                        @endcan
                        <li><a href="{{ route('dashboard.ai-content.index') }}"><i class="fas fa-robot"></i>
                                {{ __('dashboard.ai_content_generation') }}</a></li>
                        <li><a href="{{ route('dashboard.seo.testing') }}"><i class="fas fa-search-plus"></i>
                                {{ __('dashboard.seo_testing') }}</a></li>
                        <li>
                            <a href="{{ route('dashboard.redirects.index') }}">
                                <i class="fas fa-random"></i>
                                <span>Redirects</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.performance.index') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>{{ __('dashboard.performance_monitoring') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.redirects.import-form') }}">
                                <i class="fas fa-file-import"></i>
                                <span>Import Redirects</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- === SETTINGS === -->
                @can('settings.edit')
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i class="fas fa-cogs"></i>
                            <span>{{ __('dashboard.management_settings') }}</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('settings.edit')
                                <li><a href="{{ route('dashboard.settings.show') }}">{{ __('dashboard.settings') }}</a></li>
                            @endcan
                            @can('configrations_ar.view')
                                <li><a
                                        href="{{ route('dashboard.configrations.edit', 'ar') }}">{{ __('dashboard.configration_ar') }}</a>
                                </li>
                            @endcan
                            @can('configrations_en.view')
                                <li><a
                                        href="{{ route('dashboard.configrations.edit', 'en') }}">{{ __('dashboard.configration_en') }}</a>
                                </li>
                            @endcan
                            <li><a
                                    href="{{ route('dashboard.pwa-settings.index') }}">{{ __('dashboard.pwa_settings') }}</a>
                            </li>

                        </ul>
                    </li>
                @endcan
                <!-- === ADMINISTRATION === -->
                @can('admins.view')
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <i class="fas fa-users-cog"></i>
                            <span>{{ __('dashboard.management_users') }}</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('admins.view')
                                <li><a href="{{ route('dashboard.admins.index') }}">{{ __('dashboard.admins') }}</a></li>
                            @endcan
                            @can('roles.view')
                                <li><a href="{{ route('dashboard.roles.index') }}">{{ __('dashboard.roles') }}</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>

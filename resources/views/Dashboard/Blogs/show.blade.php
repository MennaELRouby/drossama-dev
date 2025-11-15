<x-dashboard.layout :title="__('dashboard.show') . ' - ' . $blog->name">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.show') . ' - ' . $blog->name" :label_url="route('dashboard.blogs.index')" :label="__('dashboard.blogs')" />
    <!-- End Page Header -->

    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="enhanced-page-header">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title pt-3">{{ __('dashboard.show') . ' - ' . $blog->name }}</h4>
                    <div>
                        <a href="{{ route('dashboard.blogs.edit', $blog->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> {{ __('dashboard.edit') }}
                        </a>
                        <a href="{{ route('dashboard.blogs.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> {{ __('dashboard.back') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-12">
                            <h5 class="mb-3">{{ __('dashboard.basic_information') }}</h5>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.name_en') }}</label>
                            <p class="form-control-static">{{ $blog->name_en }}</p>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.name_ar') }}</label>
                            <p class="form-control-static">{{ $blog->name_ar }}</p>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="font-weight-bold">{{ __('dashboard.order') }}</label>
                            <p class="form-control-static">{{ $blog->order }}</p>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="font-weight-bold">{{ __('dashboard.category') }}</label>
                            <p class="form-control-static">{{ $blog->category->name ?? __('dashboard.no_category') }}
                            </p>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="font-weight-bold">{{ __('dashboard.author') }}</label>
                            <p class="form-control-static">{{ $blog->author->name ?? __('dashboard.no_author') }}</p>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="font-weight-bold">{{ __('dashboard.date') }}</label>
                            <p class="form-control-static">{{ $blog->date }}</p>
                        </div>

                        <!-- Images -->
                        <div class="col-md-12">
                            <h5 class="mb-3 mt-4">{{ __('dashboard.images') }}</h5>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.image') }}</label>
                            @if ($blog->image_path)
                                <div class="mt-2">
                                    <img src="{{ $blog->image_path }}" alt="{{ $blog->alt_image }}" class="img-fluid"
                                        style="max-width: 300px;">
                                </div>
                                <p class="mt-2"><strong>{{ __('dashboard.alt_image') }}:</strong>
                                    {{ $blog->alt_image }}</p>
                            @else
                                <p class="text-muted">{{ __('dashboard.no_image') }}</p>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.icon') }}</label>
                            @if ($blog->icon_path)
                                <div class="mt-2">
                                    <img src="{{ $blog->icon_path }}" alt="{{ $blog->alt_icon }}" class="img-fluid"
                                        style="max-width: 100px;">
                                </div>
                                <p class="mt-2"><strong>{{ __('dashboard.alt_icon') }}:</strong>
                                    {{ $blog->alt_icon }}</p>
                            @else
                                <p class="text-muted">{{ __('dashboard.no_icon') }}</p>
                            @endif
                        </div>

                        <!-- Descriptions -->
                        <div class="col-md-12">
                            <h5 class="mb-3 mt-4">{{ __('dashboard.descriptions') }}</h5>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.short_desc_en') }}</label>
                            <div class="form-control-static">
                                {!! $blog->short_desc_en !!}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.short_desc_ar') }}</label>
                            <div class="form-control-static">
                                {!! $blog->short_desc_ar !!}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.long_desc_en') }}</label>
                            <div class="form-control-static ai-generated-content">
                                {!! $blog->long_desc_en !!}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.long_desc_ar') }}</label>
                            <div class="form-control-static ai-generated-content">
                                {!! $blog->long_desc_ar !!}
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-12">
                            <h5 class="mb-3 mt-4">{{ __('dashboard.status') }}</h5>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="font-weight-bold">{{ __('dashboard.publish/unpublish') }}</label>
                            <p class="form-control-static">
                                <span class="badge badge-{{ $blog->status ? 'success' : 'danger' }}">
                                    {{ $blog->status ? __('dashboard.yes') : __('dashboard.no') }}
                                </span>
                            </p>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="font-weight-bold">{{ __('dashboard.show_in_home') }}</label>
                            <p class="form-control-static">
                                <span class="badge badge-{{ $blog->show_in_home ? 'success' : 'danger' }}">
                                    {{ $blog->show_in_home ? __('dashboard.yes') : __('dashboard.no') }}
                                </span>
                            </p>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="font-weight-bold">{{ __('dashboard.show_in_header') }}</label>
                            <p class="form-control-static">
                                <span class="badge badge-{{ $blog->show_in_header ? 'success' : 'danger' }}">
                                    {{ $blog->show_in_header ? __('dashboard.yes') : __('dashboard.no') }}
                                </span>
                            </p>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="font-weight-bold">{{ __('dashboard.show_in_footer') }}</label>
                            <p class="form-control-static">
                                <span class="badge badge-{{ $blog->show_in_footer ? 'success' : 'danger' }}">
                                    {{ $blog->show_in_footer ? __('dashboard.yes') : __('dashboard.no') }}
                                </span>
                            </p>
                        </div>

                        <!-- SEO Information -->
                        <div class="col-md-12">
                            <h5 class="mb-3 mt-4">{{ __('dashboard.seo') }}</h5>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.slug_en') }}</label>
                            <p class="form-control-static">{{ $blog->slug_en }}</p>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.slug_ar') }}</label>
                            <p class="form-control-static">{{ $blog->slug_ar }}</p>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.meta_title_en') }}</label>
                            <p class="form-control-static">{{ $blog->meta_title_en }}</p>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.meta_title_ar') }}</label>
                            <p class="form-control-static">{{ $blog->meta_title_ar }}</p>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.meta_desc_en') }}</label>
                            <p class="form-control-static">{{ $blog->meta_desc_en }}</p>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.meta_desc_ar') }}</label>
                            <p class="form-control-static">{{ $blog->meta_desc_ar }}</p>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.meta_robots') }}</label>
                            <p class="form-control-static">
                                <span class="badge badge-{{ $blog->index ? 'success' : 'danger' }}">
                                    {{ $blog->index ? 'index' : 'noindex' }}
                                </span>
                            </p>
                        </div>

                        <!-- Timestamps -->
                        <div class="col-md-12">
                            <h5 class="mb-3 mt-4">{{ __('dashboard.timestamps') }}</h5>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.created_at') }}</label>
                            <p class="form-control-static">{{ $blog->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">{{ __('dashboard.updated_at') }}</label>
                            <p class="form-control-static">{{ $blog->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .ai-generated-content {
            line-height: 1.6;
            max-height: 400px;
            overflow-y: auto;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #e9ecef;
        }

        .ai-generated-content h2 {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-top: 20px;
            margin-bottom: 15px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }

        .ai-generated-content h3 {
            color: #34495e;
            font-size: 1.3rem;
            margin-top: 18px;
            margin-bottom: 12px;
        }

        .ai-generated-content p {
            margin-bottom: 12px;
            text-align: justify;
        }

        .ai-generated-content ul,
        .ai-generated-content ol {
            margin: 15px 0;
            padding-left: 25px;
        }

        .ai-generated-content li {
            margin-bottom: 8px;
        }

        .ai-generated-content strong {
            color: #2c3e50;
            font-weight: 600;
        }

        .ai-generated-content .highlight {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 10px;
            margin: 15px 0;
        }

        .ai-generated-content em {
            font-style: italic;
            color: #6c757d;
        }
    </style>

</x-dashboard.layout>

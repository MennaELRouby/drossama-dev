<x-dashboard.layout :title="__('dashboard.edit') . $faq->name">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.edit') . $faq->name" :label_url="route('dashboard.faqs.index')" :label="__('dashboard.faqs')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.edit') . $faq->name }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.faqs.update', [$faq->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.question_en') }}</label>
                                <textarea class="form-control" name="question_en" type="text">{!! $faq->question_en !!}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.question_ar') }}</label>
                                <textarea class="form-control" name="question_ar" type="text">{!! $faq->question_ar !!}</textarea>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="">{{ __('dashboard.order') }}</label>
                                <input class="form-control" name="order" type="number" value="{{ $faq->order }}">
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="type">{{ __('dashboard.type') }}</label>
                                <select name="faqable_type" class="form-control">
                                    <option value="">{{ __('dashboard.choose_type') }}</option>
                                    @foreach (App\Models\Faq::getTypeSelect() as $key => $label)
                                        <option value="{{ $key }}" @selected(old('faqable_type', $faq->faqable_type ?? '') == $key)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.answer_en') }}</label>
                                <textarea class="form-control" name="answer_en" rows="5">{!! $faq->answer_en !!}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="">{{ __('dashboard.answer_ar') }}</label>
                                <textarea class="form-control" name="answer_ar" rows="5">{!! $faq->answer_ar !!}</textarea>
                            </div>



                            <div class="form-group col-md-4">
                                <div class="d-flex flex-wrap gap-2">
                                    <h5 class="font-size-14 mb-3">{{ __('dashboard.publish/unpublish') }} </h5>
                                    <input type="checkbox" id="switch1" switch="none" value="1" name="status"
                                        @checked(old('status', $faq->status)) />
                                    <label for="switch1" data-on-label="{{ __('dashboard.yes') }}"
                                        data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{ __('dashboard.save') }} </button>
                                <a href="{{ route('dashboard.faqs.index') }}"><button type="button"
                                        class="btn btn-danger mr-1"><i class="icon-close"></i>
                                        {{ __('dashboard.cancel') }}</button></a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->


</x-dashboard.layout>

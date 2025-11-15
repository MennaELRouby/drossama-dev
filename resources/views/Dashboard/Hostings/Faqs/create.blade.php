<x-dashboard.layout :title="$hosting->name . ' ' . __('dashboard.add_faq')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="$hosting->name . ' ' . __('dashboard.add_faq')" :label_url="route('dashboard.hostings.edit',$hosting->id)" :label="$hosting->name . ' ' .__('dashboard.faqs')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_faq') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.hostings.faqs.store',$hosting->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-5">
                                <label class="">{{__('dashboard.question_en')}}</label>
                                <textarea class="form-control"  name="question_en" type="text" placeholder="{{__('dashboard.question_en')}}">{!! old('question_en') !!}</textarea>
                            </div>
                            <div class="form-group col-md-5">
                                <label class="">{{__('dashboard.question_ar')}}</label>
                                <textarea class="form-control"  name="question_ar" type="text" placeholder="{{__('dashboard.question_ar')}}">{!! old('question_ar') !!}</textarea>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="">{{__('dashboard.order')}}</label>
                                <input class="form-control" name="order" type="number" value="{{old('order')}}" placeholder="{{__('dashboard.order')}}" >
                            </div>

                            
                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.answer_en')}}</label>
                                <textarea class="form-control" id="myeditorinstance" name="answer_en" type="text" placeholder="{{__('dashboard.answer_en')}}">{!! old('answer_en') !!}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.answer_ar')}}</label>
                                <textarea class="form-control" id="myeditorinstance" name="answer_ar" type="text" placeholder="{{__('dashboard.answer_ar')}}">{!! old('answer_ar') !!}</textarea>
                            </div>

                            
                           
                            <div class="form-group col-md-4 mt-3 mb-3">
                               
                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    <h5 class="font-size-14 mb-3">{{__('dashboard.publish/unpublish')}} </h5>
                                    <input type="checkbox" id="switch1" switch="none" value="1" name="status" checked />
                                    <label for="switch1" data-on-label="{{ __('dashboard.yes') }}" data-off-label="{{ __('dashboard.no') }}"></label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{__('dashboard.save')}} </button>
                                <a href="{{route('dashboard.hostings.faqs.index',$hosting->id)}}"><button type="button" class="btn btn-danger mr-1"><i class="icon-trash"></i>
                                        {{__('dashboard.cancel')}}</button></a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->




</x-dashboard.layout>

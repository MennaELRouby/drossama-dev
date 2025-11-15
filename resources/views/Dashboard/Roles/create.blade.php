<x-dashboard.layout :title="__('dashboard.add_role')">

    <!-- Page Header -->
    <x-dashboard.partials.page-header :header="__('dashboard.add_role')" :label_url="route('dashboard.roles.index')"
        :label="__('dashboard.roles')" />
    <!-- End Page Header -->


    <!-- Row-->
    <div class="row">
        <div class="col-sm-12 col-xl-12 col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.add_role') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('dashboard.roles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label class="">{{__('dashboard.name')}}</label>
                                <input class="form-control" name="name" type="text" value="{{old('name')}}"
                                    placeholder="{{__('dashboard.name')}}">
                            </div>

                            <div class="form-group col-md-12 mt-3">
                                <label for="helperText">Permissions</label>
                                <select class="form-control permissions select2" name="permissions[]" multiple>
                                    @foreach ($permissions as $permission )
                                    <option value="{{ $permission->id }}" >{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                                <br>
                                <div class="mt-3">
                                    <input type="checkbox" id="checkbox"> Select all
                                </div>
                                
                            </div>

                            <div class="form-group col-md-12 mt-3">
                                <button type="submit" class="btn btn-success"><i class="icon-note"></i>
                                    {{__('dashboard.save')}} </button>
                                <a href="{{route('dashboard.roles.index')}}"><button type="button"
                                        class="btn btn-danger mr-1"><i class="icon-trash"></i>
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
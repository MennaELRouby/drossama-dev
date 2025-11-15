<x-dashboard.layout title="إضافة هاتف جديد">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('dashboard.add_new_phone') }}</h4>
                    <div class="page-title-right">
                        <a href="{{ route('dashboard.phones.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> {{ __('dashboard.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="enhanced-page-header">
                    <div class="card-body">
                        <form action="{{ route('dashboard.phones.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-10">
                                    <x-dashboard.multilingual-input name="name" type="text" :required="true" />
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="order" class="form-label"> {{ __('dashboard.order') }} </label>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror"
                                            id="order" name="order" value="{{ old('order') }}">
                                        @error('order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="code" class="form-label"> {{ __('dashboard.code') }} </label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                                            id="code" name="code" value="{{ old('code') }}">
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label"> {{ __('dashboard.phone_number') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone') }}" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="email" class="form-label"> {{ __('dashboard.email') }}</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <x-dashboard.multilingual-input name="description" type="textarea"
                                        :required="false" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">
                                            {{ __('dashboard.phone_type') }}</label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="type"
                                            name="type">
                                            <option value="phone"
                                                {{ old('type', 'phone') == 'phone' ? 'selected' : '' }}>
                                                {{ __('dashboard.phone_call') }}</option>
                                            <option value="whatsapp" {{ old('type') == 'whatsapp' ? 'selected' : '' }}>
                                                {{ __('dashboard.whatsapp') }}</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">
                                            {{ __('dashboard.status') }}</label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            name="status">
                                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                                                {{ __('dashboard.active') }}</option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                {{ __('dashboard.inactive') }}</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ __('dashboard.save') }}
                                </button>
                                <a href="{{ route('dashboard.phones.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> {{ __('dashboard.cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.layout>

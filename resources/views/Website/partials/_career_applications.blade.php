<div class="col-12 mt-5 pt-5">
    <div class="comments-form-wrapper style3 mb-5 wow fadeInUp" data-wow-delay=".6s">
        <form action="{{ route('website.saveApplication')  }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="comments-form position-relative mt-0">
                <h4 class="title">{{ __('website.personal_information') }}</h4>
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="input-groups">
                            <input type="text" placeholder="{{ __('website.name') }}" name="name" required>

                        </div>
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>

                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <div class="input-groups">
                            <input type="email" placeholder="{{ __('website.email_address') }}" name="email" required>
                        </div>
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <div class="input-groups">
                            <input type="text" name="phone" placeholder="{{ __('website.phone') }}" name="phone" required>
                        </div>
                        @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <div class="input-groups">
                            <select name="job_position_id" required>
                                <option value="" disabled selected>{{ __('website.select_job_position') }}</option>
                                @foreach ($job_positions as $job_position)
                                <option value="{{ $job_position->id }}">{{ $job_position->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-lg-12">
                        <div class="cv-uploud">
                            <input type="file" name="cv" class="custom-file-input" id="customFile" placeholder="{{ __('webiste.upload_cv') }}" required>
                            <label class="custom-file-label" for="customFile">{{ __('website.upload_cv') }}</label>
                        </div>
                    </div>
                </div>
                <div class="btn-wrap text-center mt-4 wow fadeInUp" data-wow-delay=".6s">
                    <button type="submit" class="theme-btn style3">
                        {{ __('website.submit') }}

                    </button>

                </div>
            </div>
        </form>
    </div>
</div>

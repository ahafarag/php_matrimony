
<!--------------Introduction----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="introduction">
        <button
            class="accordion-button"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseIntroduction"
            aria-expanded="true"
            aria-controls="collapseIntroduction"
        >
            <i class="fas fa-user-tag"></i>
            @lang('Introduction')
        </button>
    </h5>

    <div
        id="collapseIntroduction"
        class="accordion-collapse collapse @if($errors->has('intro') || 0 == count($errors)) show @endif"
        aria-labelledby="introduction"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form method="post" action="{{ route('user.update.introduction') }}">
                @csrf
                <div class="row g-3 g-md-4">
                    <div class="col-md-12 form-group">
                        <label for="introduction">@lang('Introduction')</label> <span class="text-danger">*</span>
                        <textarea name="introduction" cols="30" rows="10" class="form-control" placeholder="@lang('Enter Introduction')">{{ old('introduction') ?? $user->introduction }}</textarea>
                        @error('introduction')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-12 text-end">
                        <button class="btn-flower2 btn-full">@lang('update')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

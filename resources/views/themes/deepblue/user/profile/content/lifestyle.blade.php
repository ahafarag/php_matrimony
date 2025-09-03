
<!--------------Lifestyle----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="lifestyle">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseLifestyle"
            aria-expanded="false"
            aria-controls="collapseLifestyle"
        >
            <i class="fas fa-glass-cheers"></i>
            @lang('Lifestyle')
        </button>
    </h5>

    <div
        id="collapseLifestyle"
        class="accordion-collapse collapse @if($errors->has('lifestyle') || session()->get('name') == 'lifestyle') show @endif"
        aria-labelledby="lifestyle"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.lifestyle')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="diet">@lang('diet')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="diet"
                            aria-label="diet"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="Yes" {{old('diet', $user->diet == 'Yes') ? 'selected' : ''}}>@lang('Yes')</option>
                            <option value="No" {{old('diet', $user->diet == 'No') ? 'selected' : ''}}>@lang('No')</option>
                        </select>
                        @error('diet')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="drink">@lang('drink')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="drink"
                            aria-label="drink"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="Yes" {{old('drink', $user->drink == 'Yes') ? 'selected' : ''}}>@lang('Yes')</option>
                            <option value="No" {{old('drink', $user->drink == 'No') ? 'selected' : ''}}>@lang('No')</option>
                        </select>
                        @error('drink')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="smoke">@lang('smoke')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="smoke"
                            aria-label="smoke"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="Yes" {{old('smoke', $user->smoke == 'Yes') ? 'selected' : ''}}>@lang('Yes')</option>
                            <option value="No" {{old('smoke', $user->smoke == 'No') ? 'selected' : ''}}>@lang('No')</option>
                        </select>
                        @error('smoke')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="living_with">@lang('Living With')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="living_with"
                            value="{{ old('living_with') ?? $user->living_with }}"
                            placeholder="@lang('Living With')"
                        />
                        @error('living_with')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn-flower2 btn-full mt-2">@lang('update')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

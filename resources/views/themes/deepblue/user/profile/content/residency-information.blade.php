
<!--------------Residency Information----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="residencyInformation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseResidencyInformation"
            aria-expanded="false"
            aria-controls="collapseResidencyInformation"
        >
            <i class="fas fa-house-signal"></i>
            @lang('Residency Information')
        </button>
    </h5>
    <div
        id="collapseResidencyInformation"
        class="accordion-collapse collapse @if($errors->has('residencyInformation') || session()->get('name') == 'residencyInformation') show @endif"
        aria-labelledby="residencyInformation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.residencyInformation')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">
                    <div class="col-md-6 form-group">
                        <label for="birth_country">@lang('Birth Country')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="birth_country"
                            aria-label="birth_country"
                        >
                            <option value="" selected disabled>@lang('Select Birth Country')</option>
                            @foreach ($countries as $data)
                                <option
                                    value="{{$data->id}}" {{$user->birth_country == $data->id ? 'selected' : ''}}>{{$data->name}}</option>
                            @endforeach
                        </select>
                        @error('birth_country')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="residency_country">@lang('Residency Country')</label>
                        <select
                            class="form-select"
                            name="residency_country"
                            aria-label="residency_country"
                        >
                            <option value="" selected>@lang('Select Residency Country')</option>
                            @foreach ($countries as $data)
                                <option
                                    value="{{$data->id}}" {{$user->residency_country == $data->id ? 'selected' : ''}}>{{$data->name}}</option>
                            @endforeach
                        </select>
                        @error('residency_country')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="growup_country">@lang('Growup Country')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="growup_country"
                            aria-label="growup_country"
                        >
                            <option value="" selected disabled>@lang('Select Growup Country')</option>
                            @foreach ($countries as $data)
                                <option
                                    value="{{$data->id}}" {{$user->growup_country == $data->id ? 'selected' : ''}}>{{$data->name}}</option>
                            @endforeach
                        </select>
                        @error('growup_country')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="immigration_status">@lang('Immigration Status')</label>
                        <input
                            type="text"
                            class="form-control"
                            name="immigration_status"
                            value="{{old('immigration_status') ?? $user->immigration_status }}"
                            placeholder="@lang('Enter Your Immigration Status')"
                        />
                        @error('immigration_status')
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


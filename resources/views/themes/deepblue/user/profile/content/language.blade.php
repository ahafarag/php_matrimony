
<!--------------Language----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="language">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseLanguage"
            aria-expanded="false"
            aria-controls="collapseLanguage"
        >
            <i class="fas fa-language"></i>
            @lang('Language')
        </button>
    </h5>
    <div
        id="collapseLanguage"
        class="accordion-collapse collapse @if($errors->has('language') || session()->get('name') == 'setlanguages') show @endif"
        aria-labelledby="language"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.setLanguage')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="mother_tongue">@lang('Mother Tongue')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="mother_tongue"
                            aria-label="mother_tongue"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            @foreach(config('languages')['langCodeWithoutFlag'] as $key => $item)
                                <option value="{{$item}}" @if($item == old('mother_tongue',$user->mother_tongue )) selected @endif>{{$item}}</option>
                            @endforeach
                        </select>
                        @error('mother_tongue')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="known_languages">@lang('Known Languages')</label> <span class="text-danger">*</span>
                        <select
                            class="form-control"
                            name="known_languages[]"
                            multiple
                            data-live-search="true"
                        >
                            @php
                                $array_of_knownLanguage = json_decode($user->known_languages);
                            @endphp

                            @foreach(config('languages')['langCodeWithoutFlag'] as $key => $item)
                                <option value="{{$item}}"
                                        @if(is_array($array_of_knownLanguage))
                                            @if((in_array($item,$array_of_knownLanguage)))
                                                selected
                                            @endif
                                        @endif
                                     >
                                    {{$item}}
                                </option>
                            @endforeach
                        </select>
                        @error('known_languages')
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



<!--------------Family Information----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="familyInformation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseFamilyInformation"
            aria-expanded="false"
            aria-controls="collapseFamilyInformation"
        >
            <i class="fas fa-house-day"></i>
            @lang('Family Information')
        </button>
    </h5>

    <div
        id="collapseFamilyInformation"
        class="accordion-collapse collapse @if($errors->has('familyInformation') || session()->get('name') == 'familyInformation') show @endif"
        aria-labelledby="familyInformation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.familyInformation')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="father">@lang('father')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="father"
                            aria-label="father"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="Yes" {{old('father', $user->father == 'Yes') ? 'selected' : ''}}>@lang('Yes')</option>
                            <option value="No" {{old('father', $user->father == 'No') ? 'selected' : ''}}>@lang('No')</option>
                        </select>
                        @error('father')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="mother">@lang('mother')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="mother"
                            aria-label="mother"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="Yes" {{old('mother', $user->mother == 'Yes') ? 'selected' : ''}}>@lang('Yes')</option>
                            <option value="No" {{old('mother', $user->mother == 'No') ? 'selected' : ''}}>@lang('No')</option>
                        </select>
                        @error('mother')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="brother_no">@lang('No. of brothers')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="brother_no"
                            aria-label="brother_no"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="1" {{old('brother_no', $user->brother_no == '1') ? 'selected' : ''}}>1</option>
                            <option value="2" {{old('brother_no', $user->brother_no == '2') ? 'selected' : ''}}>2</option>
                            <option value="3" {{old('brother_no', $user->brother_no == '3') ? 'selected' : ''}}>3</option>
                            <option value="4" {{old('brother_no', $user->brother_no == '4') ? 'selected' : ''}}>4</option>
                            <option value="5" {{old('brother_no', $user->brother_no == '5') ? 'selected' : ''}}>5</option>
                            <option value="6" {{old('brother_no', $user->brother_no == '6') ? 'selected' : ''}}>6</option>
                            <option value="7" {{old('brother_no', $user->brother_no == '7') ? 'selected' : ''}}>7</option>
                            <option value="8" {{old('brother_no', $user->brother_no == '8') ? 'selected' : ''}}>8</option>
                            <option value="None" {{old('brother_no', $user->brother_no == 'None') ? 'selected' : ''}}>@lang('None')</option>
                        </select>
                        @error('brother_no')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="sister_no">@lang('No. of sisters')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="sister_no"
                            aria-label="sister_no"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="1" {{old('sister_no', $user->sister_no == '1') ? 'selected' : ''}}>1</option>
                            <option value="2" {{old('sister_no', $user->sister_no == '2') ? 'selected' : ''}}>2</option>
                            <option value="3" {{old('sister_no', $user->sister_no == '3') ? 'selected' : ''}}>3</option>
                            <option value="4" {{old('sister_no', $user->sister_no == '4') ? 'selected' : ''}}>4</option>
                            <option value="5" {{old('sister_no', $user->sister_no == '5') ? 'selected' : ''}}>5</option>
                            <option value="6" {{old('sister_no', $user->sister_no == '6') ? 'selected' : ''}}>6</option>
                            <option value="7" {{old('sister_no', $user->sister_no == '7') ? 'selected' : ''}}>7</option>
                            <option value="8" {{old('sister_no', $user->sister_no == '8') ? 'selected' : ''}}>8</option>
                            <option value="None" {{old('sister_no', $user->sister_no == 'None') ? 'selected' : ''}}>@lang('None')</option>
                        </select>
                        @error('sister_no')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="sibling_position">@lang('No. Of Position In Siblings')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="sibling_position"
                            aria-label="sibling_position"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="1st" {{old('sibling_position', $user->sibling_position == '1st') ? 'selected' : ''}}>@lang('1st')</option>
                            <option value="2nd" {{old('sibling_position', $user->sibling_position == '2nd') ? 'selected' : ''}}>@lang('2nd')</option>
                            <option value="3rd" {{old('sibling_position', $user->sibling_position == '3rd') ? 'selected' : ''}}>@lang('3rd')</option>
                            <option value="4th" {{old('sibling_position', $user->sibling_position == '4th') ? 'selected' : ''}}>@lang('4th')</option>
                            <option value="5th" {{old('sibling_position', $user->sibling_position == '5th') ? 'selected' : ''}}>@lang('5th')</option>
                            <option value="6th" {{old('sibling_position', $user->sibling_position == '6th') ? 'selected' : ''}}>@lang('6th')</option>
                            <option value="7th" {{old('sibling_position', $user->sibling_position == '7th') ? 'selected' : ''}}>@lang('7th')</option>
                            <option value="8th" {{old('sibling_position', $user->sibling_position == '8th') ? 'selected' : ''}}>@lang('8th')</option>
                        </select>
                        @error('sibling_position')
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

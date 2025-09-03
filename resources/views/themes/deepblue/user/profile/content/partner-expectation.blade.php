<!--------------Partner Expectation----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="partnerExpectation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsePartnerExpectation"
            aria-expanded="false"
            aria-controls="collapsePartnerExpectation"
        >
            <i class="fas fa-handshake"></i>
            @lang('Partner Expectation')
        </button>
    </h5>

    <div
        id="collapsePartnerExpectation"
        class="accordion-collapse collapse @if($errors->has('partnerExpectation') || session()->get('name') == 'partnerExpectation') show @endif"
        aria-labelledby="partnerExpectation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.partnerExpectation')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="partner_general_requirement">@lang('General Requirement')</label> <span
                            class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="partner_general_requirement"
                            value="{{old('partner_general_requirement') ?? $user->partner_general_requirement }}"
                            placeholder="@lang('General Requirement')"
                        />
                        @if($errors->has('partner_general_requirement'))
                            <div class="error text-danger">@lang($errors->first('partner_general_requirement')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_residence_country">@lang('Residence Country')</label> <span
                            class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="partner_residence_country"
                            aria-label="partner_residence_country"
                        >
                            <option value="" selected disabled>@lang('Select Residence Country')</option>
                            @foreach ($countries as $data)
                                <option
                                    value="{{$data->id}}" {{$user->partner_residence_country == $data->id ? 'selected' : ''}}>{{$data->name}}</option>
                            @endforeach
                        </select>
                        @error('partner_residence_country')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_min_height">@lang('Min Height (In Feet)')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="partner_min_height"
                            value="{{old('partner_min_height') ?? $user->partner_min_height }}"
                            placeholder="@lang('Min Height (In Feet)')"
                        />
                        @if($errors->has('partner_min_height'))
                            <div class="error text-danger">@lang($errors->first('partner_min_height')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_max_weight">@lang('Max Weight (In Kg)')</label> <span
                            class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="partner_max_weight"
                            value="{{old('partner_max_weight') ?? $user->partner_max_weight }}"
                            placeholder="@lang('Max Weight (In Kg)')"
                        />
                        @if($errors->has('partner_max_weight'))
                            <div class="error text-danger">@lang($errors->first('partner_max_weight')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_gender">@lang('gender')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="partner_gender[]"
                            multiple
                            data-live-search="true"
                            aria-label="partner_gender"
                        >
                            @php
                                $array_of_partnerGender = json_decode($user->partner_gender);
                            @endphp

                            <option value="Male"
                                @if(is_array($array_of_partnerGender))
                                    @if((in_array('Male',$array_of_partnerGender)))
                                        selected
                                    @endif
                                @endif
                            >
                                @lang('Male')
                            </option>
                            <option value="Female"
                                @if(is_array($array_of_partnerGender))
                                    @if((in_array('Female',$array_of_partnerGender)))
                                        selected
                                    @endif
                                @endif
                            >
                                @lang('Female')
                            </option>
                        </select>
                        @error('partner_gender')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_marital_status">@lang('Marital Status')</label> <span
                            class="text-danger">*</span>
                        <select
                            name="partner_marital_status"
                            class="form-select"
                            aria-label="Maritial status"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($maritalStatus as $data)
                                <option
                                    value="{{$data->marital_status_id}}" {{$user->partner_marital_status == $data->marital_status_id ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('partner_marital_status')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_children_acceptancy">@lang('Children Acceptancy')</label> <span
                            class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="partner_children_acceptancy"
                            aria-label="partner_children_acceptancy"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option
                                value="Yes" {{old('partner_children_acceptancy', $user->partner_children_acceptancy == 'Yes') ? 'selected' : ''}}>@lang('Yes')</option>
                            <option
                                value="No" {{old('partner_children_acceptancy', $user->partner_children_acceptancy == 'No') ? 'selected' : ''}}>@lang('No')</option>
                            <option
                                value="Does Not Matter" {{old('partner_children_acceptancy', $user->partner_children_acceptancy == 'Does Not Matter') ? 'selected' : ''}}>@lang('Does Not Matter')</option>
                        </select>
                        @error('partner_children_acceptancy')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_religion">@lang('religion')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            id="partner-religion-dd"
                            name="partner_religion"
                            aria-label="partner_religion"
                        >
                            <option value="" selected disabled>@lang('Select Religion')</option>
                            @foreach ($religion as $data)
                                <option
                                    value="{{$data->id}}" {{$user->partner_religion == $data->id ? 'selected' : ''}}>{{$data->name}}</option>
                            @endforeach
                        </select>
                        @error('partner_religion')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_caste">@lang('Caste')</label> <span class="text-danger">*</span>
                        <select id="partner-caste-dd" class="form-control" name='partner_caste'></select>
                        @error('partner_caste')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_sub_caste">@lang('Sub Caste')</label>
                        <select id="partner-sub-caste-dd" class="form-control" name="partner_sub_caste"></select>
                        @error('partner_sub_caste')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_language">@lang('Language')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="partner_language"
                            aria-label="partner_language"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            @foreach(config('languages')['langCodeWithoutFlag'] as $key => $item)
                                <option value="{{$item}}"
                                        @if($item == old('partner_language',$user->partner_language )) selected @endif>{{$item}}</option>
                            @endforeach
                        </select>
                        @error('partner_language')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_education">@lang('Education')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="partner_education"
                            value="{{old('partner_education') ?? $user->partner_education }}"
                            placeholder="@lang('Education')"
                        />
                        @if($errors->has('partner_education'))
                            <div class="error text-danger">@lang($errors->first('partner_education')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group d-none">
                        <label for="partner_profession">@lang('Profession')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="partner_profession"
                            value="{{old('partner_profession') ?? $user->partner_profession }}"
                            placeholder="@lang('Profession')"
                        />
                        @if($errors->has('partner_profession'))
                            <div class="error text-danger">@lang($errors->first('partner_profession')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_smoking_acceptancy">@lang('Smoking Acceptancy')</label> <span
                            class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="partner_smoking_acceptancy"
                            aria-label="partner_smoking_acceptancy"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option
                                value="Yes" {{old('partner_smoking_acceptancy', $user->partner_smoking_acceptancy == 'Yes') ? 'selected' : ''}}>@lang('Yes')</option>
                            <option
                                value="No" {{old('partner_smoking_acceptancy', $user->partner_smoking_acceptancy == 'No') ? 'selected' : ''}}>@lang('No')</option>
                            <option
                                value="Does Not Matter" {{old('partner_smoking_acceptancy', $user->partner_smoking_acceptancy == 'Does Not Matter') ? 'selected' : ''}}>@lang('Does Not Matter')</option>
                        </select>
                        @error('partner_smoking_acceptancy')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_drinking_acceptancy">@lang('Drinking Acceptancy')</label> <span
                            class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="partner_drinking_acceptancy"
                            aria-label="partner_drinking_acceptancy"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option
                                value="Yes" {{old('partner_drinking_acceptancy', $user->partner_drinking_acceptancy == 'Yes') ? 'selected' : ''}}>@lang('Yes')</option>
                            <option
                                value="No" {{old('partner_drinking_acceptancy', $user->partner_drinking_acceptancy == 'No') ? 'selected' : ''}}>@lang('No')</option>
                            <option
                                value="Does Not Matter" {{old('partner_drinking_acceptancy', $user->partner_drinking_acceptancy == 'Does Not Matter') ? 'selected' : ''}}>@lang('Does Not Matter')</option>
                        </select>
                        @error('partner_drinking_acceptancy')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_dieting_acceptancy">@lang('Dieting Acceptancy')</label> <span
                            class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="partner_dieting_acceptancy"
                            aria-label="partner_dieting_acceptancy"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option
                                value="Yes" {{old('partner_dieting_acceptancy', $user->partner_dieting_acceptancy == 'Yes') ? 'selected' : ''}}>@lang('Yes')</option>
                            <option
                                value="No" {{old('partner_dieting_acceptancy', $user->partner_dieting_acceptancy == 'No') ? 'selected' : ''}}>@lang('No')</option>
                            <option
                                value="Does Not Matter" {{old('partner_dieting_acceptancy', $user->partner_dieting_acceptancy == 'Does Not Matter') ? 'selected' : ''}}>@lang('Does Not Matter')</option>
                        </select>
                        @error('partner_dieting_acceptancy')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_body_type">@lang('Body Type')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="partner_body_type"
                            value="{{old('partner_body_type') ?? $user->partner_body_type }}"
                            placeholder="@lang('Body Type')"
                        />
                        @if($errors->has('partner_body_type'))
                            <div class="error text-danger">@lang($errors->first('partner_body_type')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_personal_value">@lang('Personal Value')</label> <span
                            class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="partner_personal_value"
                            value="{{old('partner_personal_value') ?? $user->partner_personal_value }}"
                            placeholder="@lang('Personal Value')"
                        />
                        @if($errors->has('partner_personal_value'))
                            <div class="error text-danger">@lang($errors->first('partner_personal_value')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_manglik">@lang('Manglik')</label>
                        <select
                            class="form-select"
                            name="partner_manglik"
                            aria-label="partner_manglik"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option
                                value="Yes" {{old('partner_manglik', $user->partner_manglik == 'Yes') ? 'selected' : ''}}>@lang('Yes')</option>
                            <option
                                value="No" {{old('partner_manglik', $user->partner_manglik == 'No') ? 'selected' : ''}}>@lang('No')</option>
                            <option
                                value="Does Not Matter" {{old('partner_manglik', $user->partner_manglik == 'Does Not Matter') ? 'selected' : ''}}>@lang('Does Not Matter')</option>
                        </select>
                        @error('partner_manglik')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>


                    <div class="col-md-6 form-group">
                        <label for="partner_preferred_country">@lang('Permanent Country')</label> <span
                            class="text-danger">*</span>
                        <select
                            class="form-select"
                            id="partner-country"
                            name="partner_preferred_country"
                            aria-label="partner_preferred_country"
                        >
                            <option value="" selected disabled>@lang('Select Country')</option>
                            @foreach ($countries as $data)
                                <option
                                    value="{{$data->id}}" {{old('partner_preferred_country',$user->partner_preferred_country == $data->id) ? 'selected' : ''}}>{{$data->name}}</option>
                            @endforeach
                        </select>
                        @error('partner_preferred_country')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group d-none">
                        <label for="partner_preferred_state">@lang('state')</label> <span class="text-danger">*</span>
                        <select id="partner-state" class="form-control" name='partner_preferred_state'></select>
                        @error('partner_preferred_state')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group d-none">
                        <label for="partner_preferred_city">@lang('city')</label> <span class="text-danger">*</span>
                        <select id="partner-city" class="form-control" name="partner_preferred_city"></select>
                        @error('partner_preferred_city')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>


                    <div class="col-md-6 form-group">
                        <label for="partner_family_value">@lang('Family Value')</label> <span
                            class="text-danger">*</span>
                        <select
                            name="partner_family_value"
                            class="form-select"
                            aria-label="partner_family_value"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($familyValues as $data)
                                <option
                                    value="{{$data->family_values_id}}" {{($user->partner_family_value == $data->family_values_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('partner_family_value')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_complexion">@lang('Complexion')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="partner_complexion"
                            value="{{old('partner_complexion') ?? $user->partner_complexion }}"
                            placeholder="@lang('Ex: Fair skin, always burns, sometimes tans')"
                        />
                        @if($errors->has('partner_complexion'))
                            <div class="error text-danger">@lang($errors->first('partner_complexion')) </div>
                        @endif
                    </div>


                    <div class="col-12 text-end">
                        <button type="submit" class="btn-flower2 btn-full mt-2">@lang('update')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@push('script')
    <script defer>

        //---- for religion-caste-subcaste dependency dropdown -----
        var idGetReligion = $("#partner-religion-dd").val();
        var getSelectedCaste = "{{$user->partner_caste??null}}"
        var getSelectedSubCaste = "{{$user->partner_sub_caste??null}}"

        //---- for country-state-city dependency dropdown -----
        var idPartnerCountry = $("#partner-country").val();
        var selectedPartnerState = "{{$user->partner_preferred_state??null}}"
        var selectedPartnerCity = "{{$user->partner_preferred_city??null}}"

        getAllCaste(idGetReligion, getSelectedCaste);
        getAllSubCaste(getSelectedCaste, getSelectedSubCaste);


        getPartnerStates(idPartnerCountry, selectedPartnerState);
        getPartnerCities(selectedPartnerState, selectedPartnerCity);


        $(document).on('change', '#partner-religion-dd', function () {
            var idGetReligion = this.value;
            $("#partner-caste-dd").html('');
            getAllCaste(idGetReligion);
        });

        $(document).on('change', '#partner-caste-dd', function () {
            var idGetCaste = this.value;
            $("#partner-sub-caste-dd").html('');
            getAllSubCaste(idGetCaste)
        });


        $(document).on('change', '#partner-country', function () {
            var idPartnerCountry = this.value;
            $("#partner-state").html('');
            getPartnerStates(idPartnerCountry);
        });

        $(document).on('change', '#partner-state', function () {
            var idPartnerState = this.value;
            $("#partner-city").html('');
            getPartnerCities(idPartnerState)
        });


        function getAllCaste(idGetReligion = null, getSelectedCaste = null) {
            $.ajax({
                url: "{{route('user.getCaste')}}",
                type: "POST",
                data: {
                    religion_id: idGetReligion,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#partner-caste-dd').html('<option value="">@lang("Select Caste")</option>');
                    $.each(result.caste, function (key, value) {
                        $("#partner-caste-dd").append(`<option value="${value.id}" ${(value.id == getSelectedCaste) ? 'selected' : ''}>${value.name}</option>`);
                    });
                    $('#partner-sub-caste-dd').html(`<option value="">@lang("Select Sub-Caste")</option>`);
                }
            });
        }

        function getAllSubCaste(idGetCaste = null, getSelectedSubCaste = null) {
            $.ajax({
                url: "{{route('user.getSubCaste')}}",
                type: "POST",
                data: {
                    caste_id: idGetCaste,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#partner-sub-caste-dd').html(`<option value="">@lang("Select Sub-Caste")</option>`);
                    $.each(res.subCaste, function (key, value) {
                        $("#partner-sub-caste-dd").append(`<option value="${value.id}" ${(value.id == getSelectedSubCaste) ? 'selected' : ''}>${value.name}</option>`);
                    });
                }
            });
        }

        function getPartnerStates(idPartnerCountry = null, selectedPartnerState = null) {
            $.ajax({
                url: "{{route('user.states')}}",
                type: "POST",
                data: {
                    country_id: idPartnerCountry,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#partner-state').html('<option value="">@lang("Select State")</option>');
                    $.each(result.states, function (key, value) {
                        $("#partner-state").append(`<option value="${value.id}" ${(value.id == selectedPartnerState) ? 'selected' : ''}>${value.name}</option>`);
                    });
                    $('#partner-city').html(`<option value="">@lang("Select City")</option>`);
                }
            });
        }

        function getPartnerCities(idPartnerState = null, selectedPartnerCity = null) {
            $.ajax({
                url: "{{route('user.cities')}}",
                type: "POST",
                data: {
                    state_id: idPartnerState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#partner-city').html(`<option value="">@lang("Select City")</option>`);
                    $.each(res.cities, function (key, value) {
                        $("#partner-city").append(`<option value="${value.id}" ${(value.id == selectedPartnerCity) ? 'selected' : ''}>${value.name}</option>`);
                    });
                }
            });
        }

    </script>
@endpush


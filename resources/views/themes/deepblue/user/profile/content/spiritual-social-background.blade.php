
<!-------------- Spiritual & Social Background ----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="spiritualSocialBg">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseSpiritualSocialBg"
            aria-expanded="false"
            aria-controls="collapseSpiritualSocialBg"
        >
            <i class="fas fa-place-of-worship"></i>
            @lang('Spiritual & Social Background')
        </button>
    </h5>
    <div
        id="collapseSpiritualSocialBg"
        class="accordion-collapse collapse @if($errors->has('spiritualSocialBg') || session()->get('name') == 'spiritualSocialBg') show @endif"
        aria-labelledby="spiritualSocialBg"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.spiritualSocialBg')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="religion">@lang('religion')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            id="religion-dd"
                            name="religion"
                            aria-label="religion"
                        >
                            <option value="" selected disabled>@lang('Select Religion')</option>
                            @foreach ($religion as $data)
                                <option
                                    value="{{$data->id}}" {{$user->religion == $data->id ? 'selected' : ''}}>{{$data->name}}</option>
                            @endforeach
                        </select>
                        @error('religion')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="caste">@lang('Caste')</label> <span class="text-danger">*</span>
                        <select id="caste-dd" class="form-control" name='caste'></select>
                        @error('caste')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="sub_caste">@lang('Sub Caste')</label>
                        <select id="sub-caste-dd" class="form-control" name="sub_caste"></select>
                        @error('sub_caste')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="family_value">@lang('ethnicity')</label> <span class="text-danger">*</span>
                        <select
                            name="ethnicity"
                            class="form-select"
                            aria-label="family_value"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($ethnicity as $data)
                                <option value="{{$data->ethnicity_id}}" {{($user->ethnicity == $data->ethnicity_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('ethnicity')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="personal_value">@lang('Personal Value')</label> <span class="text-danger">*</span>
                        <select
                            name="personal_value"
                            class="form-select"
                            aria-label="personal_value"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($personalValue as $data)
                                <option value="{{$data->personal_value_id}}" {{($user->personal_value == $data->personal_value_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('personal_value')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="family_value">@lang('Family Value')</label> <span class="text-danger">*</span>
                        <select
                            name="family_value"
                            class="form-select"
                            aria-label="family_value"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($familyValues as $data)
                                <option value="{{$data->family_values_id}}" {{($user->family_value == $data->family_values_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('family_value')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="community_value">@lang('Community Value')</label> <span class="text-danger">*</span>
                        <select
                            name="community_value"
                            class="form-select"
                            aria-label="community_value"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($communityValue as $data)
                                <option value="{{$data->community_value_id}}" {{($user->community_value == $data->community_value_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('community_value')
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


@push('script')
    <script>

        var idReligion = $("#religion-dd").val();
        var selectedCaste = "{{$user->caste??null}}"
        var selectedSubCaste = "{{$user->sub_caste??null}}"


        getCaste(idReligion, selectedCaste);
        getSubCaste(selectedCaste, selectedSubCaste);

        $(document).on('change', '#religion-dd', function () {
            var idReligion = this.value;
            $("#caste-dd").html('');
            getCaste(idReligion);
        });

        $(document).on('change', '#caste-dd', function () {
            var idCaste = this.value;
            $("#sub-caste-dd").html('');
            getSubCaste(idCaste)
        });


        function getCaste(idReligion, selectedCaste = null) {
            $.ajax({
                url: "{{route('user.getCaste')}}",
                type: "POST",
                data: {
                    religion_id: idReligion,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#caste-dd').html('<option value="">@lang("Select Caste")</option>');
                    $.each(result.caste, function (key, value) {
                        $("#caste-dd").append(`<option value="${value.id}" ${(value.id == selectedCaste) ? 'selected' : ''}>${value.name}</option>`);
                    });
                    $('#sub-caste-dd').html(`<option value="">@lang("Select Sub-Caste")</option>`);
                }
            });
        }

        function getSubCaste(idCaste = null, selectedSubCaste = null) {
            $.ajax({
                url: "{{route('user.getSubCaste')}}",
                type: "POST",
                data: {
                    caste_id: idCaste,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#sub-caste-dd').html(`<option value="">@lang("Select Sub-Caste")</option>`);
                    $.each(res.subCaste, function (key, value) {
                        $("#sub-caste-dd").append(`<option value="${value.id}" ${(value.id == selectedSubCaste) ? 'selected' : ''}>${value.name}</option>`);
                    });
                }
            });
        }
    </script>
@endpush

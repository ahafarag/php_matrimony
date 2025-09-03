<!--------------Present Address----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="presentAddress">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsePresentAddress"
            aria-expanded="false"
            aria-controls="collapsePresentAddress"
        >
            <i class="fas fa-map-marker-alt"></i>
            @lang('Present Address')
        </button>
    </h5>
    <div
        id="collapsePresentAddress"
        class="accordion-collapse collapse @if($errors->has('presentAddress') || session()->get('name') == 'presentAddress') show @endif"
        aria-labelledby="presentAddress"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.presentAddress')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">
                    <div class="col-md-6 form-group">
                        <label for="present_country">@lang('Country')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            id="country-dd"
                            name="present_country"
                            aria-label="present_country"
                        >
                            <option value="" selected disabled>@lang('Select Country')</option>
                            @foreach ($countries as $data)
                                <option
                                    value="{{$data->id}}" {{$user->present_country == $data->id ? 'selected' : ''}}>{{$data->name}}</option>
                            @endforeach
                        </select>
                        @error('present_country')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="present_state">@lang('state')</label> <span class="text-danger">*</span>
                        <select id="state-dd" class="form-control" name='present_state'></select>
                        @error('present_state')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="present_city">@lang('city')</label> <span class="text-danger">*</span>
                        <select id="city-dd" class="form-control" name="present_city"></select>
                        @error('present_city')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="present_postcode">@lang('postal code')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            name="present_postcode"
                            value="{{old('present_postcode') ?? $user->present_postcode }}"
                            class="form-control"
                            placeholder="@lang('Enter Postal Code')"
                        />
                        @error('present_postcode')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="present_address">@lang('Address')</label> <span class="text-danger">*</span>
                        <textarea name="present_address" cols="30" rows="10" class="form-control"
                                  placeholder="@lang('Enter Present Address')">{{ old('present_address') ?? $user->present_address }}</textarea>
                        @error('present_address')
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

        var idCountry = $("#country-dd").val();
        var selectedState = "{{$user->present_state??null}}"
        var selectedCity = "{{$user->present_city??null}}"


        getStates(idCountry, selectedState);
        getCities(selectedState, selectedCity);

        $(document).on('change', '#country-dd', function () {
            var idCountry = this.value;
            $("#state-dd").html('');
            getStates(idCountry);
        });

        $(document).on('change', '#state-dd', function () {
            var idState = this.value;
            $("#city-dd").html('');
            getCities(idState)
        });


        function getStates(idCountry, selectedState = null) {
            $.ajax({
                url: "{{route('user.states')}}",
                type: "POST",
                data: {
                    country_id: idCountry,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#state-dd').html('<option value="">@lang("Select State")</option>');
                    $.each(result.states, function (key, value) {
                        $("#state-dd").append(`<option value="${value.id}" ${(value.id == selectedState) ? 'selected' : ''}>${value.name}</option>`);
                    });
                    $('#city-dd').html(`<option value="">@lang("Select City")</option>`);
                }
            });
        }

        function getCities(idState = null, selectedCity = null) {
            $.ajax({
                url: "{{route('user.cities')}}",
                type: "POST",
                data: {
                    state_id: idState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#city-dd').html(`<option value="">@lang("Select City")</option>`);
                    $.each(res.cities, function (key, value) {
                        $("#city-dd").append(`<option value="${value.id}" ${(value.id == selectedCity) ? 'selected' : ''}>${value.name}</option>`);
                    });
                }
            });
        }
    </script>
@endpush


<!--------------Permanent Address----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="permanentAddress">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsePermanentAddress"
            aria-expanded="false"
            aria-controls="collapsePermanentAddress"
        >
            <i class="fas fa-map-marker-alt"></i>
            @lang('Permanent Address')
        </button>
    </h5>
    <div
        id="collapsePermanentAddress"
        class="accordion-collapse collapse @if($errors->has('permanentAddress') || session()->get('name') == 'permanentAddress') show @endif"
        aria-labelledby="permanentAddress"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.permanentAddress')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">
                    <div class="col-md-6 form-group">
                        <label for="permanent_country">@lang('Country')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            id="country-permanent"
                            name="permanent_country"
                            aria-label="permanent_country"
                        >
                            <option value="" selected disabled>@lang('Select Country')</option>
                            @foreach ($countries as $data)
                                <option
                                    value="{{$data->id}}" {{$user->permanent_country == $data->id ? 'selected' : ''}}>{{$data->name}}</option>
                            @endforeach
                        </select>
                        @error('permanent_country')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="permanent_state">@lang('state')</label> <span class="text-danger">*</span>
                        <select id="state-permanent" class="form-control" name='permanent_state'></select>
                        @error('permanent_state')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="permanent_city">@lang('city')</label> <span class="text-danger">*</span>
                        <select id="city-permanent" class="form-control" name="permanent_city"></select>
                        @error('permanent_city')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="permanent_postcode">@lang('postal code')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            name="permanent_postcode"
                            value="{{old('permanent_postcode') ?? $user->permanent_postcode }}"
                            class="form-control"
                            placeholder="@lang('Enter Postal Code')"
                        />
                        @error('permanent_postcode')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="permanent_address">@lang('Address')</label> <span class="text-danger">*</span>
                        <textarea name="permanent_address" cols="30" rows="10" class="form-control"
                                  placeholder="@lang('Enter Permanent Address')">{{ old('permanent_address') ?? $user->permanent_address }}</textarea>
                        @error('permanent_address')
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

        var idPermanentCountry = $("#country-permanent").val();
        var selectedPermanentState = "{{$user->permanent_state??null}}"
        var selectedPermanentCity = "{{$user->permanent_city??null}}"


        getPermanentStates(idPermanentCountry, selectedPermanentState);
        getPermanentCities(selectedPermanentState, selectedPermanentCity);

        $(document).on('change', '#country-permanent', function () {
            var idPermanentCountry = this.value;
            $("#state-permanent").html('');
            getPermanentStates(idPermanentCountry);
        });

        $(document).on('change', '#state-permanent', function () {
            var idPermanentState = this.value;
            $("#city-permanent").html('');
            getPermanentCities(idPermanentState)
        });


        function getPermanentStates(idPermanentCountry, selectedPermanentState = null) {
            $.ajax({
                url: "{{route('user.states')}}",
                type: "POST",
                data: {
                    country_id: idPermanentCountry,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#state-permanent').html('<option value="">@lang("Select State")</option>');
                    $.each(result.states, function (key, value) {
                        $("#state-permanent").append(`<option value="${value.id}" ${(value.id == selectedPermanentState) ? 'selected' : ''}>${value.name}</option>`);
                    });
                    $('#city-permanent').html(`<option value="">@lang("Select City")</option>`);
                }
            });
        }

        function getPermanentCities(idPermanentState = null, selectedPermanentCity = null) {
            $.ajax({
                url: "{{route('user.cities')}}",
                type: "POST",
                data: {
                    state_id: idPermanentState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#city-permanent').html(`<option value="">@lang("Select City")</option>`);
                    $.each(res.cities, function (key, value) {
                        $("#city-permanent").append(`<option value="${value.id}" ${(value.id == selectedPermanentCity) ? 'selected' : ''}>${value.name}</option>`);
                    });
                }
            });
        }
    </script>
@endpush


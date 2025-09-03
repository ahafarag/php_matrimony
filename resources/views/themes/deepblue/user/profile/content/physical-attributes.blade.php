
<!--------------Physical Attributes----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="physicalAttributes">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsePhysicalAttributes"
            aria-expanded="false"
            aria-controls="collapsePhysicalAttributes"
        >
            <i class="fas fa-child"></i>
            @lang('Physical Attributes')
        </button>
    </h5>
    <div
        id="collapsePhysicalAttributes"
        class="accordion-collapse collapse @if($errors->has('physicalAttributes') || session()->get('name') == 'physicalAttributes') show @endif"
        aria-labelledby="physicalAttributes"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.physicalAttributes')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="height">@lang('Height (In Feet)')</label> <span class="text-danger">*</span>
                        <input
                            type="number"
                            class="form-control"
                            step=".1"
                            name="height"
                            value="{{old('height') ?? $user->height }}"
                            placeholder="@lang('Enter Height (In Feet)')"
                        />
                        @if($errors->has('height'))
                            <div class="error text-danger">@lang($errors->first('height')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="weight">@lang('Weight (In Kg)')</label> <span class="text-danger">*</span>
                        <input
                            type="number"
                            class="form-control"
                            step=".1"
                            name="weight"
                            value="{{old('weight') ?? $user->weight }}"
                            placeholder="@lang('Enter Weight (In Kg)')"
                        />
                        @if($errors->has('weight'))
                            <div class="error text-danger">@lang($errors->first('weight')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="eyeColor">@lang('Eye Color')</label>
                        <select
                            class="form-select"
                            name="eyeColor"
                            aria-label="eyeColor"
                        >
                            <option value="" selected disabled>@lang('Select Eye Color')</option>
                            <option value="Brown" {{$user->eyeColor == 'Brown' ? 'selected' : ''}}>@lang('Brown')</option>
                            <option value="Hazel" {{$user->eyeColor == 'Hazel' ? 'selected' : ''}}>@lang('Hazel')</option>
                            <option value="Blue" {{$user->eyeColor == 'Blue' ? 'selected' : ''}}>@lang('Blue')</option>
                            <option value="Green" {{$user->eyeColor == 'Green' ? 'selected' : ''}}>@lang('Green')</option>
                            <option value="Gray" {{$user->eyeColor == 'Gray' ? 'selected' : ''}}>@lang('Gray')</option>
                            <option value="Amber" {{$user->eyeColor == 'Amber' ? 'selected' : ''}}>@lang('Amber')</option>
                        </select>
                        @if($errors->has('eyeColor'))
                            <div class="error text-danger">@lang($errors->first('eyeColor')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="hairColor">@lang('Hair Color')</label> <span class="text-danger">*</span>
                        <select
                            name="hairColor"
                            class="form-select"
                            aria-label="hair Color"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($hairColor as $data)
                                <option value="{{$data->hair_color_id}}" {{($user->hairColor == $data->hair_color_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('hairColor')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="complexion">@lang('Complexion')</label> <span class="text-danger">*</span>
                        <select
                            name="complexion"
                            class="form-select"
                            aria-label="complexion"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($complexion as $data)
                                <option value="{{$data->complexion_id}}" {{($user->complexion == $data->complexion_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('complexion')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="bloodGroup">@lang('Blood Group')</label>
                        <select
                            class="form-select"
                            name="bloodGroup"
                            aria-label="bloodGroup"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            @foreach(config('bloodgroup') as $key => $item)
                                <option value="{{$key}}" @if($key == old('bloodGroup',$user->bloodGroup )) selected @endif>{{$item}}</option>
                            @endforeach
                        </select>
                        @error('bloodGroup')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>


                    <div class="col-md-6 form-group">
                        <label for="body_type">@lang('Body Type')</label> <span class="text-danger">*</span>
                        <select
                            name="body_type"
                            class="form-select"
                            aria-label="body_type"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($bodyType as $data)
                                <option value="{{$data->body_types_id}}" {{($user->body_type == $data->body_types_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('body_type')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="body_art">@lang('Body Art')</label> <span class="text-danger">*</span>
                        <select
                            name="body_art"
                            class="form-select"
                            aria-label="body_art"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($bodyArt as $data)
                                <option value="{{$data->body_art_id}}" {{($user->body_art == $data->body_art_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('body_art')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    
                    <div class="col-md-6 form-group">
                        <label for="disability">@lang('Disability')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="disability"
                            value="{{old('disability') ?? $user->disability }}"
                            placeholder="@lang('Enter Disability')"
                        />
                        @if($errors->has('disability'))
                            <div class="error text-danger">@lang($errors->first('disability')) </div>
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


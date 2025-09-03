
<!--------------Personal Attitude & Behavior----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="personalAttitudeBehavior">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsePersonalAttitudeBehavior"
            aria-expanded="false"
            aria-controls="collapsePersonalAttitudeBehavior"
        >
            <i class="fas fa-user-chart"></i>
            @lang('Personal Attitude & Behavior')
        </button>
    </h5>
    <div
        id="collapsePersonalAttitudeBehavior"
        class="accordion-collapse collapse @if($errors->has('personalAttitudeBehavior') || session()->get('name') == 'personalAttitudeBehavior') show @endif"
        aria-labelledby="personalAttitudeBehavior"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.personalAttitudeBehavior')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="affection">@lang('Affection For')</label> <span class="text-danger">*</span>
                        <select
                            name="affection[]"
                            class="form-select"
                            aria-label="affection"
                            multiple
                            data-live-search="true"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($affectionFor as $data)
                                @php
                                    $affectionForArray = json_decode($user->affection_id);
                                @endphp
                                <option value="{{$data->affection_for_id}}"
                                    @if(is_array($affectionForArray))
                                        @if((in_array($data->affection_for_id,$affectionForArray)))
                                            selected
                                        @endif
                                    @endif
                                >
                                    @lang($data->name)
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('affection'))
                            <div class="error text-danger">@lang($errors->first('affection')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="humor">@lang('Humor')</label> <span class="text-danger">*</span>
                        <select
                            name="humor[]"
                            class="form-select"
                            aria-label="humor"
                            multiple
                            data-live-search="true"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($humor as $data)
                                @php
                                    $humorArray = json_decode($user->humor_id);
                                @endphp
                                <option value="{{$data->humor_id}}"
                                    @if(is_array($humorArray))
                                        @if((in_array($data->humor_id,$humorArray)))
                                            selected
                                        @endif
                                    @endif
                                >
                                    @lang($data->name)
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('humor'))
                            <div class="error text-danger">@lang($errors->first('humor')) </div>
                        @endif
                    </div>


                    <div class="col-md-6 form-group">
                        <label for="political_views">@lang('Political Views')</label> <span class="text-danger">*</span>
                        <select
                            name="political_views"
                            class="form-select"
                            aria-label="political_views"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($politicalView as $data)
                                <option value="{{$data->political_view_id}}" {{($user->political_views == $data->political_view_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @if($errors->has('political_views'))
                            <div class="error text-danger">@lang($errors->first('political_views')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="religious_service">@lang('Religious Service')</label> <span class="text-danger">*</span>
                        <select
                            name="religious_service"
                            class="form-select"
                            aria-label="religious_service"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($religiousService as $data)
                                <option value="{{$data->religious_service_id}}" {{($user->religious_service == $data->religious_service_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @if($errors->has('religious_service'))
                            <div class="error text-danger">@lang($errors->first('religious_service')) </div>
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


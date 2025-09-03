
<!-------------- Hobbies & Interest ----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="hobbyInterest">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseHobbyInterest"
            aria-expanded="false"
            aria-controls="collapseHobbyInterest"
        >
            <i class="fal fa-gem"></i>
            @lang('Hobbies & Interest')
        </button>
    </h5>
    <div
        id="collapseHobbyInterest"
        class="accordion-collapse collapse @if($errors->has('hobbyInterest') || session()->get('name') == 'hobbyInterest') show @endif"
        aria-labelledby="hobbyInterest"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.hobbyInterest')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="hobbies">@lang('Hobbies')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="hobbies"
                            value="{{old('hobbies') ?? $user->hobbies }}"
                            data-role="tagsinput"
                        />
                        @if($errors->has('hobbies'))
                            <div class="error text-danger">@lang($errors->first('hobbies')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="interests">@lang('Interests')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="interests"
                            value="{{old('interests') ?? $user->interests }}"
                            data-role="tagsinput"
                        />
                        @if($errors->has('interests'))
                            <div class="error text-danger">@lang($errors->first('interests')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="music">@lang('Music')</label>
                        <input
                            type="text"
                            class="form-control"
                            name="music"
                            value="{{old('music') ?? $user->music }}"
                            data-role="tagsinput"
                        />
                        @if($errors->has('music'))
                            <div class="error text-danger">@lang($errors->first('music')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="books">@lang('Books')</label>
                        <input
                            type="text"
                            class="form-control"
                            name="books"
                            value="{{old('books') ?? $user->books }}"
                            data-role="tagsinput"
                        />
                        @if($errors->has('books'))
                            <div class="error text-danger">@lang($errors->first('books')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="movies">@lang('Movies')</label>
                        <input
                            type="text"
                            class="form-control"
                            name="movies"
                            value="{{old('movies') ?? $user->movies }}"
                            data-role="tagsinput"
                        />
                        @if($errors->has('movies'))
                            <div class="error text-danger">@lang($errors->first('movies')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="tv_shows">@lang('TV Shows')</label>
                        <input
                            type="text"
                            class="form-control"
                            name="tv_shows"
                            value="{{old('tv_shows') ?? $user->tv_shows }}"
                            data-role="tagsinput"
                        />
                        @if($errors->has('tv_shows'))
                            <div class="error text-danger">@lang($errors->first('tv_shows')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="sports">@lang('Sports')</label>
                        <input
                            type="text"
                            class="form-control"
                            name="sports"
                            value="{{old('sports') ?? $user->sports }}"
                            data-role="tagsinput"
                        />
                        @if($errors->has('sports'))
                            <div class="error text-danger">@lang($errors->first('sports')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="fitness_activities">@lang('Fitness Activities')</label>
                        <input
                            type="text"
                            class="form-control"
                            name="fitness_activities"
                            value="{{old('fitness_activities') ?? $user->fitness_activities }}"
                            data-role="tagsinput"
                        />
                        @if($errors->has('fitness_activities'))
                            <div class="error text-danger">@lang($errors->first('fitness_activities')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="cuisines">@lang('Cuisines')</label>
                        <input
                            type="text"
                            class="form-control"
                            name="cuisines"
                            value="{{old('cuisines') ?? $user->cuisines }}"
                            data-role="tagsinput"
                        />
                        @if($errors->has('cuisines'))
                            <div class="error text-danger">@lang($errors->first('cuisines')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="dress_styles">@lang('Dress Styles')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="dress_styles"
                            value="{{old('dress_styles') ?? $user->dress_styles }}"
                            data-role="tagsinput"
                        />
                        @if($errors->has('dress_styles'))
                            <div class="error text-danger">@lang($errors->first('dress_styles')) </div>
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


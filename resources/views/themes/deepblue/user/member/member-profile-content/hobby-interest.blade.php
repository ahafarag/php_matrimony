<!---------------- Physical Attributes ---------------->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingHobbyInterest">
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
    </h4>

    <div
        id="collapseHobbyInterest"
        class="accordion-collapse collapse"
        aria-labelledby="headingHobbyInterest"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row borderTableOutline">
                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Hobbies') :</span>
                            <span>@lang(commaSeparateData($userProfile->hobbies))</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Interests') :</span>
                            <span>@lang(commaSeparateData($userProfile->interests))</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Music') :</span>
                            <span>@lang(commaSeparateData($userProfile->music))</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Books') :</span>
                            <span>@lang(commaSeparateData($userProfile->books))</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel w-45">@lang('Movies') :</span>
                            <span>@lang(commaSeparateData($userProfile->movies))</span>
                        </li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('TV Shows') :</span>
                            <span>@lang(commaSeparateData($userProfile->tv_shows))</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Sports') :</span>
                            <span>@lang(commaSeparateData($userProfile->sports))</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Fitness Activities') :</span>
                            <span>@lang(commaSeparateData($userProfile->fitness_activities))</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Cuisines') :</span>
                            <span>@lang(commaSeparateData($userProfile->cuisines))</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Dress Styles') :</span>
                            <span>@lang(commaSeparateData($userProfile->dress_styles))</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

</div>

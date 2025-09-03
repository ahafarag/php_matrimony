<!---- Permanent Address ---->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingAstronomicInformation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseAstronomicInformation"
            aria-expanded="false"
            aria-controls="collapseAstronomicInformation"
        >
            <i class="fas fa-telescope"></i>
            @lang('Astronomic Information')
        </button>
    </h4>
    <div
        id="collapseAstronomicInformation"
        class="accordion-collapse collapse"
        aria-labelledby="headingAstronomicInformation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-6 borderTableOutline">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel w-45">@lang('Sun Sign') :</span>
                            <span>@lang($userProfile->sun_sign)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel w-45">@lang('Moon Sign') :</span>
                            <span>@lang($userProfile->moon_sign)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel w-45">@lang('Time Of Birth') :</span>
                            <span>@lang(dateTime($userProfile->time_of_birth,'d M, Y'))</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel w-45">@lang('City Of Birth') :</span>
                            <span>@lang(dateTime($userProfile->city_of_birth,'d M, Y'))</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!---- Permanent Address ---->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingResidencyInformation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseResidencyInformation"
            aria-expanded="false"
            aria-controls="collapseResidencyInformation"
        >
            <i class="fas fa-house-signal"></i>
            @lang('Residency Information')
        </button>
    </h4>
    <div
        id="collapseResidencyInformation"
        class="accordion-collapse collapse"
        aria-labelledby="headingResidencyInformation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-6 borderTableOutline">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Birth Country') :</span>
                            <span>@lang(optional($userProfile->getBirthCountry)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center ">
                            <span class="lebel">@lang('Residency Country') :</span>
                            <span>@lang(optional($userProfile->getResidencyCountry)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Growup Country') :</span>
                            <span>@lang(optional($userProfile->getGrowupCountry)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center ">
                            <span class="lebel">@lang('Immigration Status') :</span>
                            <span>@lang($userProfile->immigration_status)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

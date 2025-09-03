<!---- Present Address ---->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingThree">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseThree"
            aria-expanded="false"
            aria-controls="collapseThree"
        >
            <i class="fal fa-map-marker-alt"></i>
            @lang('Present Address')
        </button>
    </h4>
    <div
        id="collapseThree"
        class="accordion-collapse collapse"
        aria-labelledby="headingThree"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-6 borderTableOutline">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Country') :</span>
                            <span>@lang(optional($userProfile->getPresentCountry)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('State') :</span>
                            <span>@lang(optional($userProfile->getPresentState)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('City') :</span>
                            <span>@lang(optional($userProfile->getPresentCity)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Postal Code') :</span>
                            <span>@lang($userProfile->present_postcode)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel w-45">@lang('Address') :</span>
                            <span>@lang($userProfile->present_address)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

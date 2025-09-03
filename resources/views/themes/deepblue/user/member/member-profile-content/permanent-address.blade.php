<!---- Permanent Address ---->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingPermanentAddress">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsePermanentAddress"
            aria-expanded="false"
            aria-controls="collapsePermanentAddress"
        >
            <i class="fal fa-map-marker-alt"></i>
            @lang('Permanent Address')
        </button>
    </h4>
    <div
        id="collapsePermanentAddress"
        class="accordion-collapse collapse"
        aria-labelledby="headingPermanentAddress"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-6 borderTableOutline">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Country') :</span>
                            <span>@lang(optional($userProfile->getPermanentCountry)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('State') :</span>
                            <span>@lang(optional($userProfile->getPermanentState)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('City') :</span>
                            <span>@lang(optional($userProfile->getPermanentCity)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Postal Code') :</span>
                            <span>@lang($userProfile->permanent_postcode)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel w-45">@lang('Address') :</span>
                            <span>@lang($userProfile->permanent_address)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

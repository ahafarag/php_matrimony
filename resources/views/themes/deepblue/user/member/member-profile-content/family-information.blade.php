<!---- Permanent Address ---->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingFamilyInformation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseFamilyInformation"
            aria-expanded="false"
            aria-controls="collapseFamilyInformation"
        >
            <i class="fas fa-house-day"></i>
            @lang('Family Information')
        </button>
    </h4>
    <div
        id="collapseFamilyInformation"
        class="accordion-collapse collapse"
        aria-labelledby="headingFamilyInformation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-6 borderTableOutline">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel w-45">@lang('Father') :</span>
                            <span>@lang($userProfile->father)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel w-45">@lang('Mother') :</span>
                            <span>@lang($userProfile->mother)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel w-45">@lang('No. Of Brothers') :</span>
                            <span>@lang($userProfile->brother_no)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel w-45">@lang('No. Of Sisters') :</span>
                            <span>@lang($userProfile->sister_no)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel w-45">@lang('No. Of Position In Siblings') :</span>
                            <span>@lang($userProfile->sibling_position)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

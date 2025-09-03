<!---- Permanent Address ---->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingSpiritualSocialBg">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseSpiritualSocialBg"
            aria-expanded="false"
            aria-controls="collapseSpiritualSocialBg"
        >
            <i class="fas fa-place-of-worship"></i>
            @lang('Spiritual & Social Background')
        </button>
    </h4>
    <div
        id="collapseSpiritualSocialBg"
        class="accordion-collapse collapse"
        aria-labelledby="headingSpiritualSocialBg"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-7 borderTableOutline">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Religion') :</span>
                            <span>@lang(optional($userProfile->getReligion)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center ">
                            <span class="lebel">@lang('Caste') :</span>
                            <span>@lang(optional($userProfile->getCaste)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Sub Caste') :</span>
                            <span>@lang(optional($userProfile->getSubCaste)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Family Value') :</span>
                            <span>@lang(optional($userProfile->getFamilyValue)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Personal Value') :</span>
                            <span>@lang(optional($userProfile->personalValue)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Community Value') :</span>
                            <span>@lang(optional($userProfile->communityValue)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel w-45">@lang('Ethnicity') :</span>
                            <span>@lang(optional($userProfile->userEthnicity)->name ?? 'N/A')</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

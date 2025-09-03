<!---------------- Physical Attributes ---------------->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingPhysicalAttributes">
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
    </h4>
    <div
        id="collapsePhysicalAttributes"
        class="accordion-collapse collapse"
        aria-labelledby="headingPhysicalAttributes"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row borderTableOutline">
                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Height (In Feet)') :</span>
                            <span>@lang($userProfile->height)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Weight (In Kg)') :</span>
                            <span>@lang($userProfile->weight)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Eye Color') :</span>
                            <span>@lang($userProfile->eyeColor)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Hair Color') :</span>
                            <span>@lang(optional($userProfile->userHairColor)->name)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel w-45">@lang('Complexion') :</span>
                            <span>@lang(optional($userProfile->userComplexion)->name)</span>
                        </li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Blood Group') :</span>
                            @if($userProfile->bloodGroup == 'a_positive')
                                <span>@lang('(A+) Positive')</span>
                            @elseif($userProfile->bloodGroup == 'a_negative')
                                <span>@lang('(A-) Negative')</span>
                            @elseif($userProfile->bloodGroup == 'b_positive')
                                <span>@lang('(B+) Positive')</span>
                            @elseif($userProfile->bloodGroup == 'b_negative')
                                <span>@lang('(B-) Negative')</span>
                            @elseif($userProfile->bloodGroup == 'o_positive')
                                <span>@lang('(O+) Positive')</span>
                            @elseif($userProfile->bloodGroup == 'o_negative')
                                <span>@lang('(O-) Negative')</span>
                            @elseif($userProfile->bloodGroup == 'ab_positive')
                                <span>@lang('(AB+) Positive')</span>
                            @elseif($userProfile->bloodGroup == 'ab_negative')
                                <span>@lang('(AB-) Negative')</span>
                            @endif
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Body Type') :</span>
                            <span>@lang(optional($userProfile->bodyType)->name)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Body Art') :</span>
                            <span>@lang(optional($userProfile->bodyArt)->name)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Disability') :</span>
                            <span>@lang($userProfile->disability)</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

</div>

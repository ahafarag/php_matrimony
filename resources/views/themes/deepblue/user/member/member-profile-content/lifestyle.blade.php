<!---- Permanent Address ---->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingLifestyle">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseLifestyle"
            aria-expanded="false"
            aria-controls="collapseLifestyle"
        >
            <i class="fas fa-glass-cheers"></i>
            @lang('Lifestyle')
        </button>
    </h4>
    <div
        id="collapseLifestyle"
        class="accordion-collapse collapse"
        aria-labelledby="headingLifestyle"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-6 borderTableOutline">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel w-45">@lang('Diet') :</span>
                            <span>@lang($userProfile->diet)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel w-45">@lang('Drink') :</span>
                            <span>@lang($userProfile->drink)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel w-45">@lang('Smoke') :</span>
                            <span>@lang($userProfile->smoke)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel w-45">@lang('Living With') :</span>
                            <span>@lang($userProfile->living_with)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

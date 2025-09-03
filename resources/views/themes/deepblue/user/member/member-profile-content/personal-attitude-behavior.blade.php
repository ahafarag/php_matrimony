<!---- Permanent Address ---->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingPersonalAttitudeBehavior">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsePersonalAttitudeBehavior"
            aria-expanded="false"
            aria-controls="collapsePersonalAttitudeBehavior"
        >
            <i class="fas fa-user-chart"></i>
            @lang('Personal Attitude & Behavior')
        </button>
    </h4>
    <div
        id="collapsePersonalAttitudeBehavior"
        class="accordion-collapse collapse"
        aria-labelledby="headingPersonalAttitudeBehavior"
        data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-6 borderTableOutline">
                    <ul class="list-group list-group-flush">

                        @if($userProfile->affection)
                            <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                                <span class="lebel">@lang('Affection For') :</span>
                                <div class="justify-contend-end">
                                        <span>{{@implode(',',$userProfile->affection) }}</span>
                                </div>
                            </li>

                        @endif

                        @if($userProfile->humor)
                            <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center ">
                                <span class="lebel">@lang('Humor') :</span>
                                <div class="justify-contend-end">
                                        <span>{{@implode(',',$userProfile->humor) }}</span>
                                </div>
                            </li>
                        @endif

                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Political Views') :</span>
                            <span>@lang(optional($userProfile->politicalView)->name ?? 'N/A')</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center ">
                            <span class="lebel">@lang('Religious Service') :</span>
                            <span>@lang(optional($userProfile->religiousService)->name ?? 'N/A')</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

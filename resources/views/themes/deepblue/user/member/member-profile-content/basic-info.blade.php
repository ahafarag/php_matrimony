<!---- Basic Information ---->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingTwo">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseTwo"
            aria-expanded="false"
            aria-controls="collapseTwo"
        >
            <i class="fal fa-user"></i>
            @lang('Basic Information')
        </button>
    </h4>
    <div
        id="collapseTwo"
        class="accordion-collapse collapse"
        aria-labelledby="headingTwo"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row borderTableOutline">
                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('First Name') :</span>
                            <span>@lang($userProfile->firstname)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Last Name') :</span>
                            <span>@lang($userProfile->lastname)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Username') :</span>
                            <span>@lang($userProfile->username)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Email') :</span>
                            <span>@lang($userProfile->email)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Phone') :</span>
                            <span>@lang($userProfile->phone)</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('Gender') :</span>
                            <span>@lang($userProfile->gender)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Date Of Birth') :</span>
                            <span>@lang(dateTime($userProfile->date_of_birth,'d M, Y'))</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('On Behalf') :</span>
                            <span>@lang(optional($userProfile->onBehalf)->name)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Marital Status') :</span>
                            <span>@lang(optional($userProfile->maritalStatus)->name)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center listStriped">
                            <span class="lebel">@lang('No Of Children') :</span>
                            <span>@lang($userProfile->no_of_children)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

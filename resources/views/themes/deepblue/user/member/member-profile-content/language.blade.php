<!---- Permanent Address ---->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingLanguage">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseLanguage"
            aria-expanded="false"
            aria-controls="collapseLanguage"
        >
            <i class="fas fa-language"></i>
            @lang('Language')
        </button>
    </h4>
    <div
        id="collapseLanguage"
        class="accordion-collapse collapse"
        aria-labelledby="headingLanguage"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-6 borderTableOutline">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Mother Tongue') :</span>
                            <span>@lang($userProfile->mother_tongue)</span>
                        </li>
                        <li class="list-group-item list-group-item-action list d-flex justify-content-between align-items-center">
                            <span class="lebel">@lang('Known Languages') :</span>
                            @if($userProfile->known_languages)
                                <span>@lang(implode(', ',json_decode($userProfile->known_languages)))</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

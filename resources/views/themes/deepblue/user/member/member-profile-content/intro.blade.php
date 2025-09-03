<!---- About / Intro ---->
<div class="accordion-item">
    <h4 class="accordion-header" id="headingOne">
        <button
            class="accordion-button"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseOne"
            aria-expanded="true"
            aria-controls="collapseOne"
        >
            <i class="fal fa-quote-left"></i>
            @lang('About') @lang($userProfile->username)
        </button>
    </h4>
    <div
        id="collapseOne"
        class="accordion-collapse collapse show"
        aria-labelledby="headingOne"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            @lang($userProfile->introduction)
        </div>
    </div>
</div>

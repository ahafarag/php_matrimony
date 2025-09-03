<h4>@lang('Partner Expectation')</h4>
<div class="row">

    <div class="col-md-6">
        <p>
            @lang('General Requirement') :
            <span class="w-65">@lang($userProfile->partner_general_requirement)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Residence Country') :
            <span>@lang(optional($userProfile->partnerResidenceCountry)->name ?? 'N/A')</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Min Height (In Feet)') :
            <span>@lang($userProfile->partner_min_height)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Max Weight (In Kg)') :
            <span>@lang($userProfile->partner_max_weight)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Marital Status') :
            <span>@lang(optional($userProfile->partnerMaritalStatus)->name ?? 'N/A')</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Children Acceptancy') :
            <span>@lang($userProfile->partner_children_acceptancy)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Religion') :
            <span>@lang(optional($userProfile->partnerReligion)->name ?? 'N/A')</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Caste') :
            <span>@lang(optional($userProfile->partnerCaste)->name ?? 'N/A')</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Sub Caste') :
            <span>@lang(optional($userProfile->partnerSubCaste)->name ?? 'N/A')</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Language') :
            <span>@lang($userProfile->partner_language)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Education') :
            <span>@lang($userProfile->partner_education)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Profession') :
            <span>@lang($userProfile->partner_profession)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Smoking Acceptancy') :
            <span>@lang($userProfile->partner_smoking_acceptancy)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Drinking Acceptancy') :
            <span>@lang($userProfile->partner_drinking_acceptancy)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Dieting Acceptancy') :
            <span>@lang($userProfile->partner_dieting_acceptancy)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Body Type') :
            <span>@lang($userProfile->partner_body_type)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Personal Value') :
            <span>@lang($userProfile->partner_personal_value)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Manglik') :
            <span>@lang($userProfile->partner_manglik)</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Country') :
            <span>@lang(optional($userProfile->partnerPreferredCountry)->name ?? 'N/A')</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('State') :
            <span>@lang(optional($userProfile->partnerPreferredState)->name ?? 'N/A')</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('City') :
            <span>@lang(optional($userProfile->partnerPreferredtCity)->name ?? 'N/A')</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Family Value') :
            <span>@lang(optional($userProfile->partnerFamilyValue)->name ?? 'N/A')</span>
        </p>
    </div>

    <div class="col-md-6">
        <p>
            @lang('Complexion') :
            <span class="w-65">@lang($userProfile->partner_complexion)</span>
        </p>
    </div>


</div>

<!---- About / Intro ---->
<div class="accordion-item memberProfile">
    <h4 class="accordion-header" id="headingCareerInfo">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseCareerInfo"
            aria-expanded="true"
            aria-controls="collapseCareerInfo"
        >
            <i class="far fa-user-graduate"></i>
            @lang('Career Info')
        </button>
    </h4>
    <div
        id="collapseCareerInfo"
        class="accordion-collapse collapse"
        aria-labelledby="headingCareerInfo"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <table class="table table-hover table-bordered">
                <thead>
                <tr class="tableHeaderColorGray">
                    <th scope="col">@lang('SL')</th>
                    <th scope="col">@lang('Designation')</th>
                    <th scope="col">@lang('Company')</th>
                    <th scope="col">@lang('Start Date')</th>
                    <th scope="col">@lang('End Date')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($userProfile->careerInfo as $key => $data)
                    <tr>
                        <th scope="row">{{++$key}}</th>
                        <td>@lang($data->designation)</td>
                        <td>@lang($data->company)</td>
                        <td>{{dateTime(@$data->start,'d M, Y')}}</td>
                        <td>{{dateTime(@$data->end,'d M, Y')}}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="100%">@lang('No User Data')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

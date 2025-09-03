<!---- About / Intro ---->
<div class="accordion-item memberProfile">
    <h4 class="accordion-header" id="headingEducationInfo">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseEducationInfo"
            aria-expanded="true"
            aria-controls="collapseEducationInfo"
        >
            <i class="fal fa-graduation-cap"></i>
            @lang('Education Info')
        </button>
    </h4>
    <div
        id="collapseEducationInfo"
        class="accordion-collapse collapse"
        aria-labelledby="headingEducationInfo"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="tableHeaderColorGray">
                        <th scope="col">@lang('SL')</th>
                        <th scope="col">@lang('Degree')</th>
                        <th scope="col">@lang('Institution')</th>
                        <th scope="col">@lang('Start Date')</th>
                        <th scope="col">@lang('End Date')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($userProfile->educationInfo as $key => $data)
                        <tr>
                            <th scope="row">{{++$key}}</th>
                            <td>@lang($data->degree)</td>
                            <td>@lang($data->institution)</td>
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

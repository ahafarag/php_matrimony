@extends($theme.'layouts.user')
@section('title',trans('Manage Profile'))

@section('content')

    <section class="dashboard-section faq-section faq-page noBoxShadowInForm">
        <div class="container">
            <div class="row gy-5 g-lg-4">
                @include($theme.'user.sidebar')

                <div class="col-lg-9">
                    <div class="dashboard-content profile-setting">
                        <div class="row">
                            <div class="col-12">
                                <div class="dashboard-title">
                                    <h5>@lang('Manage Profile')</h5>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="accordion" id="accordionExample">

                                            <div class="mb-4 mt-2">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: {{$profileComplete}}%;" aria-valuenow="{{$profileComplete}}" aria-valuemin="0" aria-valuemax="100">{{$profileComplete}}%</div>
                                                </div>
                                                @if(isset($approvedProfile->status) && $approvedProfile->status == 1)
                                                    <span class="text-danger">*@lang('Congratulations! Your profile is live now.')</span>
                                                @else
                                                    @if($profileComplete == 100)
                                                        <span class="text-danger">*@lang('Welldone! Your profile is ready to be approved soon.')</span>
                                                    @else
                                                        <span class="text-danger">*@lang('Please update your profile 100% to get approved.')</span>
                                                    @endif
                                                @endif
                                            </div>

                                            @include($theme.'user.profile.content.intro')
                                            @include($theme.'user.profile.content.basic-info')
                                            @include($theme.'user.profile.content.present-address')
                                            @include($theme.'user.profile.content.permanent-address')
                                            @include($theme.'user.profile.content.physical-attributes')
                                            @include($theme.'user.profile.content.education-info')
                                            @include($theme.'user.profile.content.career-info')
                                            @include($theme.'user.profile.content.language')
                                            @include($theme.'user.profile.content.hobby-interest')
                                            @include($theme.'user.profile.content.personal-attitude-behavior')
                                            @include($theme.'user.profile.content.residency-information')
                                            @include($theme.'user.profile.content.spiritual-social-background')
                                            @include($theme.'user.profile.content.lifestyle')
                                            @include($theme.'user.profile.content.astronomic-information')
                                            @include($theme.'user.profile.content.family-information')
                                            @include($theme.'user.profile.content.partner-expectation')

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    @stack('modal-here')

@endsection


@push('css-lib')
    <link rel="stylesheet" href="{{asset($themeTrue.'css/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset($themeTrue.'css/bootstrap-select.min.css')}}" />
    <link rel="stylesheet" href="{{asset($themeTrue.'css/tagsinput.css')}}" />
@endpush
@push('extra-js')
    <script src="{{asset($themeTrue.'js/select2.min.js')}}"></script>
    <script src="{{asset($themeTrue.'js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset($themeTrue.'js/tagsinput.js')}}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        $(document).ready(function () {
            $('select').select2({
                width:'100%',
            });
            $('select[name=known_languages]').selectpicker();
        });

    </script>
@endpush

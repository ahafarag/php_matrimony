@extends($theme.'layouts.user')
@section('title',trans('Dashboard'))

@section('content')

    <section class="dashboard-section">
        <div class="container">
            <div class="row gy-5 g-lg-4">

                @include($theme.'user.sidebar')

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-heart" aria-hidden="true"></i>
                                    </div>
                                    <h4>@lang($purchasedPlanItems->express_interest ?? 0)</h4>
                                    <span class="d-block">@lang('Remaining')</span>
                                    <span>@lang('Interest')</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-users"></i>
                                    </div>
                                    <h4>@lang($purchasedPlanItems->contact_view_info ?? 0)</h4>
                                    <span class="d-block">@lang('Remaining')</span>
                                    <span>@lang('Profile View')</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-image" aria-hidden="true"></i>
                                    </div>
                                    <h4>@lang($purchasedPlanItems->gallery_photo_upload ?? 0)</h4>
                                    <span class="d-block">@lang('Remaining')</span>
                                    <span>@lang('Gallery Image Upload')</span>
                                </div>
                            </div>
                        </div>


                        <div class="row g-md-4 gy-3 my-3">

                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-list-ul"></i>
                                    </div>
                                    <h4>@lang($shortlistCount)</h4>
                                    <span class="d-block">@lang('Shortlisted')</span>
                                    <span>@lang('Member')</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-heart" aria-hidden="true"></i>
                                    </div>
                                    <h4>@lang($interestlistCount)</h4>
                                    <span class="d-block">@lang('Interested')</span>
                                    <span>@lang('Member')</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-ban" aria-hidden="true"></i>
                                    </div>
                                    <h4>@lang($ignorelistCount)</h4>
                                    <span class="d-block">@lang('Ignored')</span>
                                    <span>@lang('Member')</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-image" aria-hidden="true"></i>
                                    </div>
                                    <h4>@lang($uploadedStoryCount)</h4>
                                    <span class="d-block">@lang('Uploaded')</span>
                                    <span>@lang('Story')</span>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="progress-wrapper">
                                    <div
                                        id="container"
                                        class="apexcharts-canvas theme-color"
                                    ></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@push('script')
    <script src="{{asset($themeTrue.'js/apexcharts.js')}}"></script>

    <script>
        "use strict";

        var options = {
            theme: {
                mode: 'light',
            },

            series: [
                {
                    name: "{{trans('Payment')}}",
                    color: '#fb846f',
                    data: {!! $monthly['payment']->flatten() !!}
                }
            ],
            chart: {
                type: 'bar',
                // height: ini,
                background: '#fff',
                toolbar: {
                    show: false
                }

            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: {!! $monthly['payment']->keys() !!},

            },
            yaxis: {
                title: {
                    text: ""
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                colors: ['#000'],
                y: {
                    formatter: function (val) {
                        return "{{trans($basic->currency_symbol)}}" + val + ""
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#container"), options);
        chart.render();
    </script>
@endpush

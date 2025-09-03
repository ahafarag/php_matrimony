@extends('admin.layouts.app')
@section('title')
    @lang('Dashboard')
@endsection
@section('content')


    <div class="container-fluid">
        <div class="row admin-fa_icon">

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{number_format($userRecord['totalUser'])}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Total Members')
                                </h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{number_format($userRecord['activeUser'])}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Total Active Members')
                                </h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{$userRecord['todayJoin']}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Today Joined Members')</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{$totalPlan}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang("Total Active Packages")</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fas fa-2x fa-cubes"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{trans($basic->currency_symbol)}}{{getAmount($funding['todayPayment'],config('basic.fraction_number'))}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang("Today's Payment")</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-hand-holding-usd"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{trans($basic->currency_symbol)}}{{getAmount($funding['thisMonthPayment'],config('basic.fraction_number'))}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang("This Month's Payment")</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-hand-holding-usd"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{trans($basic->currency_symbol)}}{{getAmount($funding['totalAmountReceived'],config('basic.fraction_number'))}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang("Total Payment")</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-hand-holding-usd"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{trans($basic->currency_symbol)}}{{getAmount($funding['totalChargeReceived'],config('basic.fraction_number'))}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang("Payment Charge")</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-hand-holding-usd"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title">@lang("This Month's Summary")</h4>
                                <div>
                                    <canvas id="line-chart" height="150"></canvas>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <h4 class="card-title">@lang('Package Sale Statistics')</h4>
                                <div>
                                    <canvas id="pie-chart" height="280"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>



        <div class="row admin-fa_icon">
            <div class="col-md-12">
                <h4 class="card-title">@lang('Tickets')</h4>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{number_format($tickets['closed'])}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Closed Ticket')</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-times-circle"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{number_format($tickets['replied'])}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Replied Ticket')</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-inbox"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{number_format($tickets['answered'])}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Answered Ticket')</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-check"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{number_format($tickets['pending'])}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Pending Ticket')</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-spinner"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(adminAccessRoute(config('role.user_management.access.view')))
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="card-title">@lang('Latest User')</h4>
                            <div class="table-responsive">
                                <table class="categories-show-table table table-hover table-striped table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">@lang('User')</th>
                                        <th scope="col">@lang('Email')</th>
                                        <th scope="col">@lang('Profile Complete')</th>
                                        <th scope="col">@lang('Profile Status')</th>
                                        <th scope="col">@lang('Status')</th>
                                        @if(adminAccessRoute(config('role.user_management.access.edit')))
                                            <th scope="col">@lang('Action')</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($latestUser as $user)
                                        <tr>
                                            <td data-label="@lang('User')">
                                                <a href="{{route('admin.user-edit',[$user->id])}}" target="_blank">
                                                    <div class="d-flex no-block align-items-center">
                                                        <div class="mr-3"><img src="{{getFile(config('location.user.path').$user->image)}}" alt="@lang('user image')" class="rounded-circle" width="45" height="45"></div>
                                                        <div class="">
                                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">@lang($user->firstname) @lang($user->lastname)</h5>
                                                            <span class="text-muted font-14"><span>@</span>@lang($user->username)</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td data-label="@lang('Email')">@lang($user->email)</td>
                                            @php
                                                $sss = \App\Models\ProfileInfo::where('user_id',$user->id)->first();
                                                $getStep = collect($sss)->except(['id','user_id','created_at','updated_at','status','astronomic_info']);
                                                $totalStep = count($getStep);
                                                $filtered = $getStep->values()->filter(function ($value, $key){
                                                    return $value > 0;
                                                });
                                                $complete = count($filtered->all());
                                                $profileComplete = $totalStep == 0 ? 0 : round(($complete*100/$totalStep), 2);
                                            @endphp

                                            <td data-label="@lang('Profile Complete')">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="{{$profileComplete}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$profileComplete}}%">{{$profileComplete}}%</div>
                                                </div>
                                            </td>
                                            <td data-label="@lang('Profile Status')">
                                                <span
                                                    class="badge badge-pill {{ optional($user->profileInfo)->status == 0 ? 'badge-danger' : 'badge-success' }}">{{ optional($user->profileInfo)->status == 0 ? 'Pending' : 'Approved' }}</span>
                                            </td>
                                            <td data-label="@lang('Status')">
                                            <span
                                                class="badge badge-pill {{ $user->status == 0 ? 'badge-danger' : 'badge-success' }}">{{ $user->status == 0 ? 'Inactive' : 'Active' }}</span>
                                            </td>
                                            @if(adminAccessRoute(config('role.user_management.access.edit')))
                                                <td data-label="@lang('Action')">
                                                    <div class="dropdown show">
                                                        <a class="dropdown-toggle p-3" href="#" id="dropdownMenuLink"
                                                           data-toggle="dropdown"
                                                           aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item"
                                                               href="{{ route('admin.user-edit',$user->id) }}">
                                                                <i class="fa fa-edit text-warning pr-2"
                                                                   aria-hidden="true"></i> @lang('Edit')
                                                            </a>

                                                            <a class="dropdown-item"
                                                               href="{{ route('admin.send-email',$user->id) }}">
                                                                <i class="fa fa-envelope text-success pr-2"
                                                                   aria-hidden="true"></i> @lang('Send Email')
                                                            </a>

                                                            @if(optional($user->profileInfo)->status == 0)
                                                                <a href="javascript:void(0)"
                                                                data-route="{{ route('admin.profile-approve',$user->id) }}"
                                                                data-toggle="modal"
                                                                data-target="#approve-modal"
                                                                class="dropdown-item btn btn-danger btn-sm approve-confirm">
                                                                    <i class="fa fa-user text-primary pr-2" aria-hidden="true"></i> @lang('Approve Profile')
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0)"
                                                                data-route="{{ route('admin.profile-pending',$user->id) }}"
                                                                data-toggle="modal"
                                                                data-target="#pending-modal"
                                                                class="dropdown-item btn btn-danger btn-sm pending-confirm">
                                                                    <i class="fa fa-user text-danger pr-2" aria-hidden="true"></i> @lang('Make Profile Pending')
                                                                </a>
                                                            @endif

                                                            <a class="dropdown-item loginAccount" href="javascript:void(0)"
                                                                data-toggle="modal"
                                                                data-target="#signIn"
                                                                data-route="{{route('admin.login-as-user',$user->id)}}">
                                                                <i class="fas fa-sign-in-alt text-success pr-2"
                                                                aria-hidden="true"></i> @lang('Login as User')
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center text-danger" colspan="7">@lang('No User Data')</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>


    @if($basic->is_active_cron_notification)
        <div class="modal fade" id="cron-info" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-primary">
                        <h5 class="modal-title">
                            <i class="fas fa-info-circle"></i>
                            @lang('Cron Job Set Up Instruction')
                        </h5>
                        <button type="button" class="close cron-notification-close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="bg-orange text-white p-2">
                                    <i>@lang('**To sending emails and sms  automatically you need to setup cron job in your server. Make sure your job is running properly. We insist to set the cron job time as minimum as possible.**')</i>
                                </p>
                            </div>
                            <div class="col-md-12 form-group">
                                <label><strong>@lang('Command for Email & SMS')</strong></label>
                                <div class="input-group ">
                                    <input type="text" class="form-control copyText"
                                           value="curl -s {{ route('queue.work') }}" disabled>
                                    <div class="input-group-append">
                                        <button class="input-group-text bg-primary btn btn-primary text-white copy-btn">
                                            <i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center">
                                <p class="bg-dark text-white p-2">
                                    @lang('*To turn off this pop up go to ')
                                    <a href="{{ route('admin.basic-controls') }}"
                                       class="text-orange">@lang('Basic control')</a>
                                    @lang(' and disable `Cron Set Up Pop Up`.*')
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif



    <!-- User Profile Approve Modal -->
    <div id="approve-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Approve User\'s Profile Confirmation')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to approve this profile?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="approveRoute">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- User Profile Pending Modal -->
    <div id="pending-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Pending User\'s Profile Confirmation')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to make this profile pending?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="pendingRoute">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- Admin Login as a User Modal -->
    <div class="modal fade" id="signIn">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="" class="loginAccountAction" enctype="multipart/form-data">
                @csrf
                <!-- Modal Header -->
                    <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title">@lang('Sing In Confirmation')</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p>@lang('Are you sure to sign in this account?')</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('Close')</span>
                        </button>
                        <button type="submit" class=" btn btn-primary "><span>@lang('Yes')</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/Chart.min.js') }}"></script>

    <script>
        "use strict";
        new Chart(document.getElementById("line-chart"), {
            type: 'line',
            data: {
                labels: @json($statistics['schedule']->keys()),
                datasets: [{
                    data: @json($statistics['monthlyPayments']->values()),
                    label: "Payments",
                    borderColor: "#6fbbff",
                    fill: false
                }
                ]
            }
        });


        new Chart(document.getElementById("pie-chart"), {
            type: 'pie',
            data: {
                labels: @json($pieLog->pluck('level')),
                datasets: [{
                    backgroundColor: ["#6fbbff", "#ff6f62", "#05ffe4", "#98df8a", "#8b6ef3", "#f9dd7e", "#f34da3"],
                    data:  @json($pieLog->pluck('value')),
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function (tooltipItems, data) {
                            return data.labels[tooltipItems.index] + ': ' + data.datasets[0].data[tooltipItems.index] + '%';
                        }
                    }

                }
            }
        });


        $(document).on('click', '#details', function () {
            var title = $(this).data('servicetitle');
            var description = $(this).data('description');
            $('#title').text(title);
            $('#servicedescription').text(description);
        });

        $(document).ready(function () {
            let isActiveCronNotification = '{{ $basic->is_active_cron_notification }}';
            if (isActiveCronNotification == 1)
                $('#cron-info').modal('show');
            $(document).on('click', '.copy-btn', function () {
                var _this = $(this)[0];
                var copyText = $(this).parents('.input-group-append').siblings('input');
                $(copyText).prop('disabled', false);
                copyText.select();
                document.execCommand("copy");
                $(copyText).prop('disabled', true);
                $(this).text('Coppied');
                setTimeout(function () {
                    $(_this).text('');
                    $(_this).html('<i class="fas fa-copy"></i>');
                }, 500)
            });
        })


        // for user profile active/pending
        $(document).ready(function () {
            $('.approve-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.approveRoute').attr('action', route)
            })
            $('.pending-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.pendingRoute').attr('action', route)
            })
        });

        // for login as user
        $(document).on('click', '.loginAccount', function () {
            var route = $(this).data('route');
            $('.loginAccountAction').attr('action', route)
        });
    </script>
@endpush

@extends('admin.layouts.app')
@section('title')
    @lang("User List")
@endsection


@section('content')
    <style>
        .fa-ellipsis-v:before {
            content: "\f142";
        }
    </style>
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{ route('admin.users.search') }}" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="search" value="{{@request()->search}}" class="form-control"
                                       placeholder="@lang('Type Here')">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="date" class="form-control" name="date_time" id="datepicker"/>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="">@lang('All User')</option>
                                    <option value="1"
                                            @if(@request()->status == '1') selected @endif>@lang('Active User')</option>
                                    <option value="0"
                                            @if(@request()->status == '0') selected @endif>@lang('Inactive User')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn w-100 w-md-auto btn-primary"><i
                                        class="fas fa-search"></i> @lang('Search')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">

            <div class="dropdown mb-2 text-right">
                <button class="btn btn-sm  btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span><i class="fas fa-bars pr-2"></i> @lang('Action')</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <button class="dropdown-item" type="button" data-toggle="modal"
                            data-target="#all_active">@lang('Active')</button>
                    <button class="dropdown-item" type="button" data-toggle="modal"
                            data-target="#all_inactive">@lang('Inactive')</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="text-center">
                            <input type="checkbox" class="form-check-input check-all tic-check" name="check-all"
                                   id="check-all">
                            <label for="check-all"></label>
                        </th>
                        <th scope="col">@lang('No.')</th>
                        <th scope="col">@lang('User\'s Name')</th>
                        <th scope="col">@lang('Email')</th>
                        <th scope="col">@lang('Profile Complete')</th>
                        <th scope="col">@lang('Profile Status')</th>
                        <th scope="col">@lang('Last Login')</th>
                        <th scope="col">@lang('User Status')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" id="chk-{{ $user->id }}"
                                       class="form-check-input row-tic tic-check" name="check" value="{{$user->id}}"
                                       data-id="{{ $user->id }}">
                                <label for="chk-{{ $user->id }}"></label>
                            </td>
                            <td data-label="@lang('No.')">{{loopIndex($users) + $loop->index}}</td>
                            <td data-label="@lang('Name')">
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
                                    class="badge badge-pill {{ optional($user->profileInfo)->status == 0 ? 'badge-danger' : 'badge-success' }}">{{ optional($user->profileInfo)->status == 0 ? 'Pending' : 'Approved' }}
                                </span>
                            </td>

                            <td data-label="@lang('Last Login')">{{diffForHumans($user->last_login)}}</td>
                            <td data-label="@lang('User Status')">
                                <span
                                    class="badge badge-pill {{ $user->status == 0 ? 'badge-danger' : 'badge-success' }}">{{ $user->status == 0 ? 'Inactive' : 'Active' }}
                                </span>
                            </td>
                            <td data-label="@lang('Action')">
                                <div class="dropdown show ">
                                    <a class="dropdown-toggle p-3" href="#" id="dropdownMenuLink" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="{{ route('admin.user-edit',$user->id) }}">
                                            <i class="fa fa-edit text-warning pr-2"
                                               aria-hidden="true"></i> @lang('Edit')
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.send-email',$user->id) }}">
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
                                        <a class="dropdown-item loginAccount"
                                           href="javascript:void(0)"
                                            data-toggle="modal"
                                            data-target="#signIn"
                                            data-route="{{route('admin.login-as-user',$user->id)}}">
                                            <i class="fas fa-sign-in-alt text-success pr-2"
                                               aria-hidden="true"></i> @lang('Login as User')
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-danger" colspan="9">@lang('No User Data')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                {{$users->appends(@$search)->links('partials.pagination')}}

            </div>
        </div>
    </div>




    <div class="modal fade" id="all_active" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Active User Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p>@lang("Are you really want to active the User's")</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></button>
                    <form action="" method="post">
                        @csrf
                        <a href="" class="btn btn-primary active-yes"><span>@lang('Yes')</span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="all_inactive" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('DeActive User Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p>@lang("Are you really want to Inactive the User's")</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></button>
                    <form action="" method="post">
                        @csrf
                        <a href="" class="btn btn-primary inactive-yes"><span>@lang('Yes')</span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
    <script>
        "use strict";

            $(document).on('click', '#check-all', function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $(document).on('change', ".row-tic", function () {
                let length = $(".row-tic").length;
                let checkedLength = $(".row-tic:checked").length;
                if (length == checkedLength) {
                    $('#check-all').prop('checked', true);
                } else {
                    $('#check-all').prop('checked', false);
                }
            });

            //dropdown menu is not working
            $(document).on('click', '.dropdown-menu', function (e) {
                e.stopPropagation();
            });

            //multiple active
            $(document).on('click', '.active-yes', function (e) {
                e.preventDefault();
                var allVals = [];
                $(".row-tic:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });

                var strIds = allVals;

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.user-multiple-active') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        location.reload();

                    },
                });
            });

            //multiple deactive
            $(document).on('click', '.inactive-yes', function (e) {
                e.preventDefault();
                var allVals = [];
                $(".row-tic:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });

                var strIds = allVals;
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.user-multiple-inactive') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        location.reload();

                    }
                });
            });

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


            $(document).ready(function () {
                $('select').select2({
                    selectOnClose: true
                });
            });

    </script>
@endpush

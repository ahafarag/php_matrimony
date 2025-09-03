@extends('admin.layouts.app')
@section('title')
    @lang("Reported Members List")
@endsection
@section('content')

    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{route('admin.reportList.search')}}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="user_name" value="{{old('user_name',@request()->user_name)}}"
                                       class="form-control get-username" placeholder="@lang('Search By Name')">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="date" class="form-control" name="date"
                                       value="{{old('date',@request()->date)}}" id="datepicker"/>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn waves-effect waves-light btn-primary"><i
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
            <table class="categories-show-table table table-hover table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">@lang('No.')</th>
                    <th scope="col">@lang('Report To')</th>
                    <th scope="col">@lang('Reported By')</th>
                    <th scope="col">@lang('Date')</th>
                    <th scope="col">@lang('Action')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($report as $k => $row)
                    <tr>
                        <td data-label="@lang('No.')">{{loopIndex($report) + $k}}</td>
                        <td data-label="@lang('Member Name')">
                            <a href="{{route('admin.user-edit',[$row->member_id])}}" target="_blank">
                                <div class="d-flex no-block align-items-center">
                                    <div class="mr-3"><img
                                            src="{{getFile(config('location.user.path').optional($row->userReportedTo)->image) }}"
                                            alt="@lang('user image')" class="rounded-circle" width="45" height="45">
                                    </div>
                                    <div>
                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($row->userReportedTo)->firstname) @lang(optional($row->userReportedTo)->lastname)</h5>
                                        <span class="text-muted font-14"><span>@</span>@lang(optional($row->userReportedTo)->username)</span>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td data-label="@lang('Reported By')">
                            <a href="{{route('admin.user-edit',[$row->user_id])}}" target="_blank">
                                <div class="d-flex no-block align-items-center">
                                    <div class="mr-3"><img
                                            src="{{getFile(config('location.user.path').optional($row->userReportedBy)->image) }}"
                                            alt="@lang('user image')" class="rounded-circle" width="45" height="45">
                                    </div>
                                    <div>
                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($row->userReportedBy)->firstname) @lang(optional($row->userReportedBy)->lastname)</h5>
                                        <span class="text-muted font-14"><span>@</span>@lang(optional($row->userReportedBy)->username)</span>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td data-label="@lang('Date')">{{dateTime($row->created_at, 'd M, Y')}}</td>
                        <td data-label="@lang('Action')" class="cursorPointer">
                            <div class="dropdown show">
                                <a class="dropdown-toggle p-3" href="#" id="dropdownMenuLink" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                                    @if(adminAccessRoute(config('role.report_list.access.edit')))
                                        <a
                                            class="dropdown-item edit_button cursor-pointer"
                                            data-toggle="modal"
                                            data-target="#detailsModal"
                                            data-id="{{ $row->id }}"
                                            data-reason="{{ $row->reason }}"
                                        >
                                            <i class="fas fa-eye text-primary pr-2"></i> @lang('Report Reason')
                                        </a>
                                    @endif
                                    @if(adminAccessRoute(config('role.report_list.access.delete')))
                                        <a class="dropdown-item delete-confirm cursor-pointer"
                                           data-route="{{ route('admin.report.delete',$row->id) }}"
                                           data-toggle="modal"
                                           data-target="#delete-modal">
                                            <i class="fas fa-trash-alt text-danger pr-2"
                                               aria-hidden="true"></i> @lang('Delete')
                                        </a>

                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center">@lang('No Data Found')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $report->links('partials.pagination') }}
        </div>
    </div>



    <!-- Modal for View Report Reason -->
    <div class="modal fade" id="detailsModal" tabindex="-1" data-backdrop="static" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="detailsModalLabel">@lang('Report Reason Details')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <label class="font-weight-bold">{{trans('Report Reason')}}</label>
                    <textarea class="form-control" id="reason" row="3" readonly></textarea>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Modal -->
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Delete Confirmation')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="deleteRoute">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection

@push('js')
    <script>
        'use strict'
        $(document).ready(function () {

            $('.delete-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })

            $(document).on('click', '.dropdown-menu', function (e) {
                e.stopPropagation();
            });

            $(document).on("click", '.edit_button', function (e) {
                var id = $(this).data('id');
                $("#reason").val($(this).data('reason'));
            });

        });
    </script>


    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.Failure("{{trans($error)}}");
            @endforeach
        </script>
    @endif

@endpush

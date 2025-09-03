@extends('admin.layouts.app')
@section('title')
    @lang('Manage Story')
@endsection

@section('content')

    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{route('admin.story.search')}}" method="get">
                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="user_name" value="{{old('user_name',@request()->user_name)}}"
                                       class="form-control get-username" placeholder="@lang('User\'s name')">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="name" value="{{old('name',@request()->name)}}"
                                       class="form-control get-trx-id" placeholder="@lang('Story name')">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="">@lang('All Stories')</option>
                                    <option value="1"
                                            @if(@request()->status == '1') selected @endif>@lang('Approved Stories')</option>
                                    <option value="0"
                                            @if(@request()->status == '0') selected @endif>@lang('Pending Stories')</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="date" class="form-control" name="datetrx"
                                       value="{{old('datetrx',@request()->datetrx)}}" id="datepicker"/>
                            </div>
                        </div>

                        <div class="col-md-2">
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
            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('SL No.')</th>
                        <th scope="col">@lang('User')</th>
                        <th scope="col">@lang('Name')</th>
                        <th scope="col">@lang('Image')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@lang('Post Time')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($storyList as $item)
                        <tr>
                            <td data-label="@lang('SL No.')">{{$loop->index+1}}</td>
                            <td>
                                <a href="{{route('admin.user-edit',$item->user_id)}}" target="_blank">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="mr-3"><img
                                                src="{{getFile(config('location.user.path').optional($item->user)->image)}}"
                                                alt="@lang('user image')" class="rounded-circle" width="45" height="45">
                                        </div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($item->user)->firstname) @lang(optional($item->user)->lastname)</h5>
                                            <span class="text-muted font-14"><span>@</span>@lang(optional($item->user)->username)</span>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td data-label="@lang('Name')">@lang(\Illuminate\Support\Str::limit($item->name,40))</td>
                            <td data-label="@lang('Image')">
                                <img src="{{ getFile(config('location.story.path').'thumb_'.$item->image)}}"
                                     class="imgTableShow" alt="@lang('story img')"/>
                            </td>
                            <td>
                                <span class="badge badge-pill badge-{{ $item->status == 0 ? 'danger' : 'primary' }}">
                                    {{ $item->status == 0 ? 'Pending' : 'Approved' }}
                                </span>
                            </td>
                            <td data-label="@lang('Post Time')">
                                {{ dateTime($item->created_at, 'd M Y h:i A') }}
                            </td>

                            <td data-label="@lang('Action')" class="cursorPointer">
                                <div class="dropdown show">
                                    <a class="dropdown-toggle p-3" href="#" id="dropdownMenuLink" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                                        <a href="{{route('admin.storyShow',['id'=>$item->id])}}"
                                           class="dropdown-item cursor-pointer">
                                            <i class="fas fa-eye text-primary pr-2"></i> @lang('View Story')
                                        </a>

                                        @if(adminAccessRoute(config('role.story.access.edit')))

                                            @if($item->status == 0)
                                                <a class="dropdown-item cursor-pointer approveStory"
                                                   data-toggle="modal"
                                                   data-target="#approveModal"
                                                   data-route="{{route('admin.storyApprove',['id'=>$item->id])}}"
                                                >
                                                    <i class="fas fa-check text-primary pr-2"></i> @lang('Approve Story')
                                                </a>
                                            @else
                                                <a class="dropdown-item cursor-pointer makePendingStory"
                                                   data-toggle="modal"
                                                   data-target="#makePendingModal"
                                                   data-route="{{route('admin.storyPending',['id'=>$item->id])}}"
                                                >
                                                    <i class="far fa-window-close text-danger pr-2"></i> @lang('Mark as pending')
                                                </a>
                                            @endif
                                        @endif


                                        @if(adminAccessRoute(config('role.story.access.delete')))
                                        <a class="dropdown-item delete-confirm cursor-pointer"
                                           data-route="{{ route('admin.storyDelete',$item->id) }}"
                                           data-toggle="modal"
                                           data-target="#delete-modal">
                                            <i class="fas fa-trash text-danger pr-2"
                                               aria-hidden="true"></i> @lang('Delete')
                                        </a>
                                            @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">
                                <p class="text-dark text-center">@lang('No Data Found')</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
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


    <!-- Approve Modal -->
    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Approve Confirmation')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to approve this story?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="approveRoute">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- Pending Modal -->
    <div id="makePendingModal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Make Pending Confirmation')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to make this story pending?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="pendingRoute">
                        @csrf
                        @method('put')
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
            $('select').select2({
                selectOnClose: true
            });
        });
        $(document).on('click','.delete-confirm', function () {
            var route = $(this).data('route');
            $('.deleteRoute').attr('action', route)
        })

        $(document).on('click','.approveStory', function () {
            var route = $(this).data('route');
            $('.approveRoute').attr('action', route)
        })

        $(document).on('click','.makePendingStory', function () {
            var route = $(this).data('route');
            $('.pendingRoute').attr('action', route)
        });
        $(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation();
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

@extends('admin.layouts.app')
@section('title')
    @lang('State List')
@endsection

@section('content')

    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{route('admin.state.search')}}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="state_name" value="{{old('state_name',@request()->state_name)}}"
                                    class="form-control get-username" placeholder="@lang('Search State Name')">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="country_name" value="{{old('country_name',@request()->country_name)}}"
                                    class="form-control get-trx-id" placeholder="@lang('Search Country Name')">
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
            @if(adminAccessRoute(config('role.user_management.access.add')))
                <div class="media mb-4 float-right">
                    <a href="{{route('admin.stateCreate')}}" class="btn btn-sm btn-primary mr-2">
                        <span><i class="fa fa-plus-circle"></i> @lang('Add New')</span>
                    </a>
                </div>
            @endif

            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('SL No.')</th>
                        <th scope="col">@lang('State Name')</th>
                        <th scope="col">@lang('Country Name')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($stateList as $item)
                            <tr>
                                <td data-label="@lang('SL No.')">{{$loop->index+1}}</td>
                                <td data-label="@lang('State Name')">
                                    @lang($item->name)
                                </td>
                                <td data-label="@lang('Country Name')">
                                    @lang(optional($item->country)->name)
                                </td>

                                <td data-label="@lang('Action')">
                                    @if(adminAccessRoute(config('role.user_management.access.edit')))
                                        <a href="{{ route('admin.stateEdit',$item->id) }}"
                                        class="btn btn-sm btn-primary edit-button">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                    @if(adminAccessRoute(config('role.user_management.access.delete')))
                                        <a href="javascript:void(0)"
                                        data-route="{{ route('admin.stateDelete', $item->id) }}"
                                        data-toggle="modal"
                                        data-target="#delete-modal"
                                        class="btn btn-danger btn-sm delete-confirm"><i
                                                class="fas fa-trash-alt"></i>
                                        </a>
                                    @endif
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
                <div class="float-right">
                    {{ $stateList->links('partials.pagination') }}
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
            $('select').select2({
                selectOnClose: true
            });
        });

        $(document).on('click','.delete-confirm', function () {
            var route = $(this).data('route');
            $('.deleteRoute').attr('action', route)
        })
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

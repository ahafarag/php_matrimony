@extends($theme.'layouts.user')
@section('title',__('Ignored Members'))

@section('content')

    <section class="dashboard-section">
        <div class="container">
            <div class="row gy-5 g-lg-4">
                @include($theme.'user.sidebar')

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="dashboard-title">
                                    <h5>@lang('Ignored Members')</h5>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="search-area table-search">
                                            <form action="{{ route('user.ignore.search') }}" method="get">
                                                @csrf
                                                <div class="row g-3">
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <input type="text" name="user_name" value="{{old('user_name',@request()->user_name)}}" class="form-control" placeholder="@lang('Search Member\'s Name')">
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <input type="text" name="age" value="{{old('name',@request()->age)}}" class="form-control" placeholder="@lang('Search By Age')">
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <select name="religion" class="form-select">
                                                            <option value="">@lang('All Religion')</option>
                                                            @foreach ($religion as $data)
                                                                <option value="{{$data->id}}" @if(@request()->religion == $data->id) selected @endif>
                                                                    {{$data->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <button class="btn-flower2 w-100" type="submit">@lang('Search')</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="table-wrapper table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">@lang('SL.')</th>
                                                    <th scope="col">@lang('Member\'s Name')</th>
                                                    <th scope="col">@lang('Age')</th>
                                                    <th scope="col">@lang('Religion')</th>
                                                    <th scope="col">@lang('Country')</th>
                                                    <th scope="col">@lang('Action')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($ignoreList as $key => $value)
                                                    @php
                                                        $currentUserPlanItems = \App\Models\PurchasedPlanItem::where('user_id',auth()->user()->id)->first();
                                                        $countProfileView = \App\Models\ProfileView::where(['user_id' => auth()->user()->id,'member_id' => $value->member_id])->count();
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>
                                                            @if(isset($currentUserPlanItems) && $currentUserPlanItems->contact_view_info > 0 && $countProfileView == 0 || isset($currentUserPlanItems) && $currentUserPlanItems->contact_view_info >= 0 && $countProfileView != 0 || auth()->user()->id == $value->member_id)
                                                                <a href="{{route('user.member.profile.show', $value->member_id)}}" target="_blank">
                                                                    <div class="d-flex no-block align-items-center">
                                                                        <div class="me-2"><img src="{{ getFile(config('location.user.path').optional($value->user)->image)}}" alt="@lang('interestList user img')" class="rounded-circle" width="45" height="45"></div>
                                                                        <div class="">
                                                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($value->user)->firstname) @lang(optional($value->user)->lastname)</h5>
                                                                            <span class="text-muted font-14"><span>@</span>@lang(optional($value->user)->username)</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0)"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#gotoPlanModal"
                                                                >
                                                                    <div class="d-flex no-block align-items-center">
                                                                        <div class="me-2"><img src="{{ getFile(config('location.user.path').optional($value->user)->image)}}" alt="@lang('ignoreList user img')" class="rounded-circle" width="45" height="45"></div>
                                                                        <div class="">
                                                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($value->user)->firstname) @lang(optional($value->user)->lastname)</h5>
                                                                            <span class="text-muted font-14"><span>@</span>@lang(optional($value->user)->username)</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>@lang(optional($value->user)->age)</td>
                                                        <td>@lang(optional(optional($value->user)->getReligion)->name)</td>
                                                        <td>@lang(optional(optional($value->user)->getPresentCountry)->name)</td>
                                                        <td>
                                                            <a href="javascript:void(0)"
                                                               data-route="{{ route('user.ignore.delete',$value->id) }}"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#delete-modal"
                                                               class="action-btn danger notiflix-confirm"
                                                            >
                                                                <button
                                                                    class="action-btn danger"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-placement="top"
                                                                    title="@lang('Delete')"
                                                                >
                                                                    <i class="fas fa-trash fw-900"></i>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="100%" class="text-center">@lang('No Data Found')</td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
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



    <!-- Delete Modal -->
    <div id="delete-modal" class="modal fade modal-with-form" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content form-block">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Remove From Ignore Confirmation')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are Your Sure To Remove This Member From Your Ignore List?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-flower2 btn1" data-bs-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="deleteRoute">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn-flower2 btn2">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection


@push('script')
    <script>
        'use strict'
        $(document).ready(function () {
            $('.notiflix-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })
        });
    </script>
@endpush

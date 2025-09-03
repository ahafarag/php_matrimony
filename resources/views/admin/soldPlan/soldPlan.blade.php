@extends('admin.layouts.app')
@section('title')
    @lang('Sold Packages')
@endsection

@section('content')

    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{route('admin.soldPlan.search')}}" method="get">
                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="user_name" value="{{old('user_name',@request()->user_name)}}" class="form-control get-username" placeholder="@lang('User\'s name')">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="name" value="{{old('name',@request()->name)}}" class="form-control get-trx-id" placeholder="@lang('Package name')">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="price" value="{{old('price',@request()->price)}}" class="form-control get-service" placeholder="@lang('Package Price')">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="date" class="form-control" name="datetrx" value="{{old('datetrx',@request()->datetrx)}}" id="datepicker"/>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn waves-effect waves-light btn-primary"><i class="fas fa-search"></i> @lang('Search')</button>
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
                    <th scope="col">@lang('SL No.')</th>
                    <th scope="col">@lang('User')</th>
                    <th scope="col">@lang('Package Name')</th>
                    <th scope="col">@lang('Package Price')</th>
                    <th scope="col">@lang('Purchased At')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($soldPlans as $item)
                    <tr>
                        <td data-label="@lang('SL No.')">{{$loop->index+1}}</td>
                        <td>
                            <a href="{{route('admin.user-edit',$item->user_id)}}" target="_blank">
                                <div class="d-flex no-block align-items-center">
                                    <div class="mr-3"><img src="{{getFile(config('location.user.path').optional($item->user)->image)}}" alt="@lang('user image')" class="rounded-circle" width="45" height="45"></div>
                                    <div class="">
                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($item->user)->firstname) @lang(optional($item->user)->lastname)</h5>
                                        <span class="text-muted font-14"><span>@</span>@lang(optional($item->user)->username)</span>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td data-label="@lang('Package Name')">
                            <a href="{{ route('admin.planEdit',$item->plan_id) }}" target="_blank">
                                @lang(optional(optional($item->allPlan)->details)->name)
                            </a>
                        </td>
                        <td data-label="@lang('Package Price')">
                            {{ $basic->currency_symbol ?? '$' }}{{getAmount($item->amount)}}
                        </td>
                        <td data-label="@lang('Purchased At')">
                            {{ dateTime($item->created_at, 'd M Y h:i A') }}
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
            {{ $soldPlans->links('partials.pagination') }}
        </div>
    </div>

@endsection


@push('js')
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

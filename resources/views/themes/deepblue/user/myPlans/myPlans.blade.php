@extends($theme.'layouts.user')
@section('title',trans('My Packages'))

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
                                    <h5>@lang('My Packages')</h5>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="search-area table-search">
                                            <form action="{{ route('user.purchased.plan.search') }}" method="get">
                                                @csrf
                                                <div class="row g-3">
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <input type="text" name="name" value="{{old('name',@request()->name)}}" class="form-control" placeholder="@lang('Search by Name')">
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <input type="text" name="price" value="{{old('name',@request()->price)}}" class="form-control" placeholder="@lang('Search by Price')">
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <input type="date" class="form-control" name="date_time" value="{{old('date_time',@request()->date_time)}}"/>
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
                                                    <th scope="col">@lang('SL')</th>
                                                    <th scope="col">@lang('Name')</th>
                                                    <th scope="col">@lang('Price')</th>
                                                    <th scope="col">@lang('Purchased At')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($myPlans as $data)
                                                    <tr>
                                                        <td>{{loopIndex($myPlans) + $loop->index}}</td>
                                                        <td>@lang(optional($data->planDetails)->name)</td>
                                                        <td>{{getAmount($data->amount)}} @lang($basic->currency)</td>
                                                        <td>{{ dateTime($data->created_at, 'd M Y, h:i A') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="100%" class="text-center">@lang('No Data Found!')</td>
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

@endsection


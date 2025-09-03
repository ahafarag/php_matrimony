@extends($theme.'layouts.user')
@section('title',trans('Payment History'))

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
                                    <h5>@lang('Payment History')</h5>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="search-area table-search">
                                            <form action="{{ route('user.fund-history.search') }}" method="get">
                                                @csrf
                                                <div class="row g-3">
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <input type="text" name="name" value="{{old('name',@request()->name)}}" class="form-control" placeholder="@lang('Search by Transaction ID')">
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <select name="status" class="form-select">
                                                            <option value="">@lang('All Payment')</option>
                                                            <option value="1"
                                                                    @if(@request()->status == '1') selected @endif>@lang('Complete Payment')</option>
                                                            <option value="2"
                                                                    @if(@request()->status == '2') selected @endif>@lang('Pending Payment')</option>
                                                            <option value="3"
                                                                    @if(@request()->status == '3') selected @endif>@lang('Cancel Payment')</option>
                                                        </select>
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

                                    <div class="col-12">
                                        <div class="table-wrapper table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">@lang('Transaction ID')</th>
                                                        <th scope="col">@lang('Gateway')</th>
                                                        <th scope="col">@lang('Amount')</th>
                                                        <th scope="col">@lang('Charge')</th>
                                                        <th scope="col">@lang('Status')</th>
                                                        <th scope="col">@lang('Time')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($funds as $data)
                                                        <tr>
                                                            <td>{{$data->transaction}}</td>
                                                            <td>@lang(optional($data->gateway)->name)</td>
                                                            <td><strong>{{getAmount($data->amount)}} @lang($basic->currency)</strong></td>
                                                            <td><strong>{{getAmount($data->charge)}} @lang($basic->currency)</strong></td>
                                                            <td>
                                                                @if($data->status == 1)
                                                                    <span class="status">@lang('Complete')</span>
                                                                @elseif($data->status == 2)
                                                                    <span class="status danger">@lang('Pending')</span>
                                                                @elseif($data->status == 3)
                                                                    <span class="status dark">@lang('Cancel')</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ dateTime($data->created_at, 'd M Y, h:i A') }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr class="text-center">
                                                            <td colspan="100%" class="text-danger">{{__('No Data Found!')}}</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        {{ $funds->appends($_GET)->links() }}

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


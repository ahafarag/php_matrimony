@extends($theme.'layouts.user')
@section('title',__($page_title))

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
                                    <h5>@lang($page_title)</h5>
                                    <a href="{{route('user.ticket.create')}}" class="add-new btn-flower2 text-center">@lang('Create Ticket')</a>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="table-wrapper table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">@lang('Subject')</th>
                                                    <th scope="col">@lang('Status')</th>
                                                    <th scope="col">@lang('Last Reply')</th>
                                                    <th scope="col">@lang('Action')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($tickets as $key => $ticket)
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold"> [{{ trans('Ticket#').$ticket->ticket }}] {{ $ticket->subject }} </span>
                                                        </td>
                                                        <td>
                                                            @if($ticket->status == 0)
                                                                <span class="status">@lang('Open')</span>
                                                            @elseif($ticket->status == 1)
                                                                <span class="status primary">@lang('Answered')</span>
                                                            @elseif($ticket->status == 2)
                                                                <span class="status danger">@lang('Replied')</span>
                                                            @elseif($ticket->status == 3)
                                                                <span class="status dark">@lang('Closed')</span>
                                                            @endif
                                                        </td>
                                                        <td>{{diffForHumans($ticket->last_reply) }}</td>
                                                        <td>
                                                            <a href="{{ route('user.ticket.view', $ticket->ticket) }}">
                                                                <button class="action-btn"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-placement="top"
                                                                    title="@lang('View Details')"
                                                                >
                                                                    <i class="fa fa-eye fw-900"></i>
                                                                </button>
                                                             </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="100%" class="text-center">{{__('No Data Found!')}}</td>
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

@extends($theme.'layouts.user')
@section('title',__('Matched Profile'))

@section('content')

    <section class="dashboard-section members-section">
        <div class="container">
            <div class="row gy-5 g-lg-4">
                @include($theme.'user.sidebar')

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="dashboard-title">
                                    <h5>@lang('Matched Profile')</h5>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    @forelse($allUser as $key => $data)
                                        @php
                                            $premium = $data->purchasedPlanItems;
                                            $currentUserPlanItems = \App\Models\PurchasedPlanItem::where('user_id',auth()->user()->id)->first();
                                            $countProfileView = \App\Models\ProfileView::where(['user_id' => auth()->user()->id,'member_id' => $data->id])->count();
                                        @endphp

                                        <div class="member-box d-md-flex">
                                            <div class="img-box">
                                                <img src="{{getFile(config('location.user.path').$data->image)}}" class=""
                                                     alt="@lang('member post image')"/>
                                            </div>

                                            <div>
                                                <h5 class="name">@lang($data->firstname) @lang($data->lastname)</h5>
                                                <span class="member-id"
                                                >@lang('Member ID') : <span>@lang($data->member_id)</span></span>
                                                <div class="row g-2 mt-3 member-info">
                                                    <div class="col-6">
                                                        <span>@lang('age') : @lang($data->age) @lang('years')</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span>@lang('height') : @lang($data->height) @lang('Feet')</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span>@lang('religion') : @lang(optional($data->getReligion)->name)</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span>@lang('caste') : @lang(optional($data->getCaste)->name)</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span>@lang('location') : @lang(optional($data->getPresentCountry)->name)</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span>@lang('maritial status') : @lang(optional($data->maritalStatus)->name)</span>
                                                    </div>
                                                </div>


                                                <div class="button-group">
                                                    @if(isset($currentUserPlanItems) && $currentUserPlanItems->contact_view_info > 0 && $countProfileView == 0 || isset($currentUserPlanItems) && $currentUserPlanItems->contact_view_info >= 0 && $countProfileView != 0 || auth()->user()->id == $data->id)
                                                        <a href="{{route('user.member.profile.show', $data->id)}}">
                                                            <i class="fal fa-user"></i>
                                                            <span>@lang('Show Profile')</span>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0)"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#gotoPlanModal"
                                                        >
                                                            <i class="fal fa-user"></i>
                                                            <span>@lang('Show Profile')</span>
                                                        </a>
                                                    @endif


                                                    <a href="javascript:void(0)"
                                                       id="{{$key}}"
                                                       class="update_interest"
                                                       data-memberid="{{$data->id}}"
                                                    >
                                                        <i class="fal fa-heart"></i>
                                                        @if($data->interest)
                                                            <span class="{{$key}}interest">@lang('Interest Expressed')</span>
                                                        @else
                                                            <span class="{{$key}}interest">@lang('Make Interest')</span>
                                                        @endif
                                                    </a>


                                                    <a href="javascript:void(0)"
                                                       id="{{$key}}"
                                                       class="update_shortlist"
                                                       data-memberid="{{$data->id}}"
                                                    >
                                                        <i class="fal fa-list"></i>
                                                        @if($data->shortlist)
                                                            <span class="{{$key}}">@lang('Shortlisted')</span>
                                                        @else
                                                            <span class="{{$key}}">@lang('Shortlist')</span>
                                                        @endif
                                                    </a>

                                                    <a href="javascript:void(0)"
                                                       id="{{$key}}"
                                                       class="ignore"
                                                       data-memberid="{{$data->id}}"
                                                    >
                                                        <span class="{{$key}}ignore"><i class="fal fa-ban"></i> @lang('Ignore')</span>
                                                    </a>


                                                    @if(auth()->user()->id != $data->id)
                                                        <a href="javascript:void(0)"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#reportModal"
                                                           data-route="{{ route('user.report.submit',$data->id) }}"
                                                           class="reportButton"
                                                        >
                                                            <i class="fal fa-exclamation-circle"></i>
                                                            <span>@lang('Report')</span>
                                                        </a>
                                                    @endif


                                                </div>
                                            </div>

                                            @if($premium)
                                                @if($premium->express_interest > 0 || $premium->gallery_photo_upload > 0 || $premium->contact_view_info > 0)
                                                    <span class="tag">@lang('Premium')</span>
                                                @endif
                                            @endif

                                        </div>
                                    @empty
                                        <div class="d-flex flex-column justify-content-center py-5">
                                            <h3 class="text-center mt-5 mb-5">@lang('No Member Available.')</h3>
                                        </div>
                                    @endforelse

                                    <div class="row">
                                        {{ $allUser->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Goto Purchase Plan Modal -->
    <div id="gotoPlanModal" class="modal fade modal-with-form" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content form-block">
                <div class="modal-body">
                    <div class="form-group">
                        <h4 class="text-green text-center py-3">@lang('Please Upgrade Your Package')</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-flower2 btn1" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{route('plan')}}">
                        <button type="submit" class="btn-flower2 btn2 planPurchaseButton">@lang('Purchase Package')</button>
                    </a>
                </div>
            </div>

        </div>
    </div>


    <!-- Report modal -->
    <div class="modal fade modal-with-form" id="reportModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">@lang('Report Member!')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="reportSubmit">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reportReason">@lang('Report Reason')</label>
                            <textarea name="reason" id="reportReason" cols="30" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-flower btn1" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn-flower btn2">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('script')
    <script>
        "use strict";

        var user_id = "{{auth()->id()}}"

        // for update shortlist
        $(document).on('click', '.update_shortlist', function () {
            var member_id = $(this).data('memberid');
            var _this = this;

            if (member_id == user_id) {
                Notiflix.Notify.Failure("@lang('You can\'t shortlist yourself')");
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: "{{ url('/add/shortlist/') }}/" + member_id,
                    dataType: "json",
                    data: {
                        member_id: member_id
                    },
                    success: function (response) {
                        if (response.action == 'add') {
                            $(`.${_this.id}`).text('Shortlisted')
                            Notiflix.Notify.Success(response.message);
                        } else if (response.action == 'remove') {
                            $(`.${_this.id}`).text('Shortlist');
                            Notiflix.Notify.Success(response.message);
                        }
                    }
                })
            }

        });


        // for make interest
        $(document).on('click', '.update_interest', function () {
            var member_id = $(this).data('memberid');
            var _this = this;

            if (member_id == user_id) {
                Notiflix.Notify.Failure("@lang('You can\'t express interest yourself')");
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: "{{ url('/add/interest/') }}/" + member_id,
                    dataType: "json",
                    data: {
                        member_id: member_id
                    },
                    success: function (response) {
                        if (response.action == 'add') {
                            $(`.${_this.id}interest`).text('Interest Expressed')
                            Notiflix.Notify.Success(response.message);
                        } else if (response.action == 'alreadyExist') {
                            // $(`.${_this.id}`).text('interest');
                            Notiflix.Notify.Failure(response.message);
                        } else if (response.action == 'purchasePackage') {
                            $('#gotoPlanModal').modal('show');
                            {{--window.location.href = "{{route('plan')}}"--}}
                            // Notiflix.Notify.Failure(response.message);
                        }
                    }
                })
            }

        });


        // for ignore member
        $(document).on('click', '.ignore', function () {
            var member_id = $(this).data('memberid');
            var _this = this;

            if (member_id == user_id) {
                Notiflix.Notify.Failure("@lang('You can\'t ignore yourself')");
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: "{{ url('/add/ignore/') }}/" + member_id,
                    dataType: "json",
                    data: {
                        member_id: member_id
                    },
                    success: function (response) {
                        if (response.action == 'add') {
                            $(`.${_this.id}ignore`).text('')
                            Notiflix.Notify.Success(response.message);
                        }
                    }
                })
            }

        });


        // report member
        $(document).on('click', '.reportButton', function (){
            var route = $(this).data('route');
            $('.reportSubmit').attr('action', route)
        })
    </script>

@endpush

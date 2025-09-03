@extends($theme.'layouts.user')
@section('title', trans($title))

@section('content')
    @php
        $premium = $userProfile->purchasedPlanItems;
        $currentUserPlanItems = \App\Models\PurchasedPlanItem::where('user_id',auth()->user()->id)->first();
    @endphp
    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="member-box d-md-flex">
                        <div class="img-box">
                            <img src="{{getFile(config('location.user.path').$userProfile->image)}}" class="img-fluid" alt="@lang('member\'s image')" />
                        </div>
                        <div>
                            <h4 class="name">@lang($userProfile->firstname) @lang($userProfile->lastname)</h4>
                            <span class="member-id">@lang('Member ID'): <span>@lang($userProfile->member_id)</span></span>
                            <div class="row g-2 mt-3 member-info">
                                <div class="col-6">
                                    <span>@lang('age') : @lang($userProfile->age) @lang('years')</span>
                                </div>
                                <div class="col-6">
                                    <span>@lang('height') : @lang($userProfile->height) @lang('Feet')</span>
                                </div>
                                <div class="col-6">
                                    <span>@lang('religion') : @lang(optional($userProfile->getReligion)->name ?? 'N/A')</span>
                                </div>
                                <div class="col-6">
                                    <span>@lang('caste') : @lang(optional($userProfile->getCaste)->name ?? 'N/A')</span>
                                </div>
                                <div class="col-6">
                                    <span>@lang('location') : @lang(optional($userProfile->getPresentCountry)->name ?? 'N/A')</span>
                                </div>
                                <div class="col-6">
                                    <span>@lang('maritial status') : @lang(optional($userProfile->maritalStatus)->name ?? 'N/A')</span>
                                </div>
                            </div>
                            <div class="button-group">
                                @if(auth()->user()->id != $userProfile->id)
                                    <a href="javascript:void(0)"
                                       id="{{$userProfile->id}}"
                                       class="update_interest"
                                       data-memberid="{{$userProfile->id}}">
                                        <i class="fal fa-heart"></i>
                                        @if($userProfile->interest)
                                            <span class="{{$userProfile->id}}interest">@lang('Interest Expressed')</span>
                                        @else
                                            <span class="{{$userProfile->id}}interest">@lang('Make Interest')</span>
                                        @endif
                                    </a>
                                @endif

                                @if(auth()->user()->id != $userProfile->id)
                                    <a href="javascript:void(0)"
                                       id="{{$userProfile->id}}"
                                       class="update_shortlist"
                                       data-memberid="{{$userProfile->id}}"
                                    >
                                        <i class="fal fa-list"></i>

                                        @if($userProfile->shortlist)
                                            <span class="{{$userProfile->id}}">@lang('Shortlisted')</span>
                                        @else
                                            <span class="{{$userProfile->id}}">@lang('Shortlist')</span>
                                        @endif
                                    </a>
                                @endif

                                @if(auth()->user()->id != $userProfile->id)
                                    <a href="javascript:void(0)"
                                       id="{{$userProfile->id}}"
                                       class="ignore"
                                       data-memberid="{{$userProfile->id}}"
                                    >
                                        <span class="{{$userProfile->id}}ignore"><i class="fal fa-ban"></i> @lang('Ignore')</span>
                                    </a>
                                @endif

                                @if(auth()->user()->id != $userProfile->id)
                                    <a href="javascript:void(0)"
                                       data-bs-toggle="modal"
                                       data-bs-target="#reportModal"
                                       data-route="{{ route('user.report.submit',$userProfile->id) }}"
                                       class="reportButton"
                                    >
                                        <i class="fal fa-exclamation-circle"></i>
                                        <span>@lang('Report')</span>
                                    </a>
                                @endif

                                @if(auth()->user()->id != $userProfile->id)
                                    <a href="javascript:void(0)"
                                       data-bs-toggle="modal"
                                       data-bs-target="#messageModal"
                                       data-route="{{ route('user.send.message',$userProfile->id) }}"
                                       class="sendMessageButton"
                                    >
                                        <i class="fas fa-comments-alt"></i>
                                        <span>@lang('Message')</span>
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
                </div>
            </div>
        </div>
    </section>


    <div class="profile-details">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <div class="navigator">
                        <button tab-id="tab1" class="tab active">@lang('Detailed Profile')</button>
                        <button tab-id="tab2" class="tab">@lang('Partner Preference')</button>
                        <button tab-id="tab3" class="tab">@lang('Photo Gallery')</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <!----------------- Detailed Profile ----------------->
                    <div id="tab1" class="content active">
                        <div class="accordion" id="accordionExample">
                            @include($theme.'user.member.member-profile-content.intro')
                            @include($theme.'user.member.member-profile-content.basic-info')
                            @include($theme.'user.member.member-profile-content.present-address')
                            @include($theme.'user.member.member-profile-content.permanent-address')
                            @include($theme.'user.member.member-profile-content.physical-attributes')
                            @include($theme.'user.member.member-profile-content.education-info')
                            @include($theme.'user.member.member-profile-content.career-info')
                            @include($theme.'user.member.member-profile-content.language')
                            @include($theme.'user.member.member-profile-content.hobby-interest')
                            @include($theme.'user.member.member-profile-content.personal-attitude-behavior')
                            @include($theme.'user.member.member-profile-content.residency-information')
                            @include($theme.'user.member.member-profile-content.spiritual-social-background')
                            @include($theme.'user.member.member-profile-content.lifestyle')
                            @include($theme.'user.member.member-profile-content.astronomic-information')
                            @include($theme.'user.member.member-profile-content.family-information')
                        </div>
                    </div>

                    <!----------- Partner Expectation ------------>
                    <div id="tab2" class="content partner-exceptation">
                        @include($theme.'user.member.member-profile-content.partner-expectation')
                    </div>


                    <!------------- Photo Gallery --------------->
                    <div id="tab3" class="content profile-photo-gallery">
                        @include($theme.'user.member.member-profile-content.photo-gallery')
                    </div>


                </div>
            </div>
        </div>
    </div>


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
                            <label for="">@lang('Report Reason')</label>
                            <textarea name="reason" id="" cols="30" rows="4" class="form-control" required></textarea>
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


    <!-- Message Modal -->
    <div class="modal fade modal-with-form" id="messageModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">@lang('Send Message')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="messageSend">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="message">@lang('Message')</label>
                            <textarea name="message" id="message" cols="30" rows="4" class="form-control" required placeholder="@lang('type here...')"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-flower btn1" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn-flower btn2">@lang('Send')</button>
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
                        // console.log(response);
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
                            setTimeout(function(){
                                window.location.href = '{{route('members')}}';
                            }, 3000);
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

        // message
        $(document).on('click', '.sendMessageButton', function (){
            var route = $(this).data('route');
            $('.messageSend').attr('action', route)
        })


    </script>
@endpush


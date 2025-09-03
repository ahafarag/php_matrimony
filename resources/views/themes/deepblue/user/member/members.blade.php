@extends($theme.'layouts.user')
@section('title', trans($title))

@section('content')
    <!-- Member -->
        <section class="members-section">
            <div class="container">
                <div class="row gy-5 g-md-4">

                    <!------------------ Search sidebar ------------->
                    <div class="col-lg-3">
                        <div class="side-search-area">
                            <form action="{{ route('user.search.member') }}" method="GET">
                                <div class="row g-3">

                                    <div class="col-md-12 form-group">
                                        <label for="age_from">@lang('Age from')</label>
                                        <input type="number" name="age_from" id="age_from" value="{{old('age_from',request()->age_from)}}" class="form-control" min="1" step="1" placeholder="@lang('age from')"/>
                                        @error('age_from')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="age_to">@lang('To')</label>
                                        <input type="number" name="age_to" id="age_to" value="{{old('age_to',request()->age_to)}}" class="form-control" min="1" step="1" placeholder="@lang('age to')"/>
                                        @error('age_to')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="member_id">@lang('Member ID')</label>
                                        <input type="text" name="member_id" id="member_id" value="{{old('member_id',request()->member_id)}}" class="form-control" placeholder="@lang('Member ID')"/>
                                        @error('member_id')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="gender">@lang('Gender')</label>
                                        <select class="form-select" name="gender" id="gender" aria-label="gender">
                                            <option value="" selected>@lang('Select Gender')</option>
                                            <option value="Male" {{ old('gender', request()->gender) == 'Male' ? 'selected' : ''}}>@lang('Male')</option>
                                            <option value="Female" {{ old('gender', request()->gender) == 'Female' ? 'selected' : ''}}>@lang('Female')</option>
                                        </select>
                                        @error('gender')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="marital_status">@lang('Maritial Status')</label>
                                        <select name="marital_status" id="marital_status" class="form-select" aria-label="Maritial status">
                                            <option value="" selected>@lang('Select Maritial Status')</option>
                                            @foreach($maritalStatus as $data)
                                                <option value="{{$data->marital_status_id}}" {{ old('marital_status', request()->marital_status) == $data->marital_status_id ? 'selected' : ''  }}>@lang($data->name)</option>
                                            @endforeach
                                        </select>
                                        @error('marital_status')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="religion-dds">@lang('Select Religion')</label>
                                        <select name="religion" id="religion-dds" class="form-select" aria-label="religion">
                                            <option value="" selected>@lang('Select Religion')</option>
                                            @foreach ($religion as $data)
                                                <option value="{{$data->id}}" {{old('religion',request()->religion) == $data->id ? 'selected' : ''}}>{{$data->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('religion')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="caste-dds">@lang('Select Caste')</label>
                                        <select name="caste" id="caste-dds" class="form-select"></select>
                                        @error('caste')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="mother_tongue">@lang('Mother Tongue')</label>
                                        <select name="mother_tongue" id="mother_tongue" class="form-select" aria-label="Mother Tongue">
                                            <option value="" selected>@lang('Select Mother Tongue')</option>
                                            @foreach(config('languages')['langCodeWithoutFlag'] as $key => $item)
                                                <option value="{{$item}}" @if($item == old('mother_tongue',request()->mother_tongue )) selected @endif>{{$item}}</option>
                                            @endforeach
                                        </select>
                                        @error('mother_tongue')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="country-dds">@lang('Select Country')</label>
                                        <select name="country" id="country-dds" class="form-select" aria-label="Select Country">
                                            <option value="" selected>@lang('Select Country')</option>
                                            @foreach ($countries as $data)
                                                <option value="{{$data->id}}" {{old('country',request()->country) == $data->id ? 'selected' : ''}}>{{$data->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="state-dds">@lang('Select State')</label>
                                        <select name='state' id="state-dds" class="form-control"></select>
                                        @error('state')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="city-dds">@lang('Select City')</label>
                                        <select name="city" id="city-dds" class="form-control"></select>
                                        @error('city')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="max_height">@lang('Max Height (In Feet)')</label>
                                        <input type="number" name="max_height" id="max_height" value="{{old('max_height',request()->max_height)}}" class="form-control" min="1" placeholder="@lang('Max Height')"/>
                                        @error('max_height')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="min_height">@lang('Min Height (In Feet)')</label>
                                        <input type="number" name="min_height" id="min_height" value="{{old('min_height',request()->min_height)}}" class="form-control" min="1" placeholder="@lang('Min Height')"/>
                                        @error('min_height')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn-flower">@lang('Search')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <!------------------ Members Profile ------------->
                    <div class="col-lg-9">

                        @forelse($allUser as $key => $data)

                            @php
                                $premium = $data->purchasedPlanItems;
                                $currentUserPlanItems = \App\Models\PurchasedPlanItem::where('user_id',@auth()->user()->id)->first();
                                $countProfileView = \App\Models\ProfileView::where(['user_id' => @auth()->user()->id,'member_id' => $data->id])->count();
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
                                            <span>@lang('religion') : @lang(optional($data->getReligion)->name ?? 'N/A')</span>
                                        </div>
                                        <div class="col-6">
                                            <span>@lang('caste') : @lang(optional($data->getCaste)->name ?? 'N/A')</span>
                                        </div>
                                        <div class="col-6">
                                            <span>@lang('location') : @lang(optional($data->getPresentCountry)->name ?? 'N/A')</span>
                                        </div>
                                        <div class="col-6">
                                            <span>@lang('maritial status') : @lang(optional($data->maritalStatus)->name ?? 'N/A')</span>
                                        </div>
                                    </div>


                                    <div class="button-group">
                                        @guest
                                            <a href="javascript:void(0)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#gotoPlanModal"
                                            >
                                                <i class="fal fa-user"></i>
                                                <span>@lang('Profile')</span>
                                            </a>
                                        @else
                                            @if(isset($currentUserPlanItems) && $currentUserPlanItems->contact_view_info > 0 && $countProfileView == 0 || isset($currentUserPlanItems) && $currentUserPlanItems->contact_view_info >= 0 && $countProfileView != 0 || @auth()->user()->id == $data->id)
                                                <a href="{{route('user.member.profile.show', $data->id)}}">
                                                    <i class="fal fa-user"></i>
                                                    <span>@lang('Profile')</span>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#gotoPlanModal"
                                                >
                                                    <i class="fal fa-user"></i>
                                                    <span>@lang('Profile')</span>
                                                </a>
                                            @endif
                                        @endguest


                                        @guest
                                            <a href="javascript:void(0)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#gotoPlanModal"
                                            >
                                                <i class="fal fa-heart"></i>
                                                <span>@lang('Make Interest')</span>
                                            </a>
                                        @else
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
                                        @endguest



                                        @guest
                                            <a href="javascript:void(0)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#gotoPlanModal"
                                            >
                                                <i class="fal fa-list"></i>
                                                <span>@lang('Shortlist')</span>
                                            </a>
                                        @else
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
                                        @endguest


                                        @guest
                                            <a href="javascript:void(0)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#gotoPlanModal"
                                            >
                                                <i class="fal fa-ban"></i>
                                                <span>@lang('Ignore')</span>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)"
                                                id="{{$key}}"
                                                class="ignore"
                                                data-memberid="{{$data->id}}"
                                            >
                                                <span class="{{$key}}ignore"><i class="fal fa-ban"></i> @lang('Ignore')</span>
                                            </a>
                                        @endguest



                                        @guest
                                            <a href="javascript:void(0)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#gotoPlanModal"
                                            >
                                                <i class="fal fa-user"></i>
                                                <span>@lang('Report')</span>
                                            </a>
                                        @else
                                            @if(@auth()->user()->id != $data->id)
                                                <a href="javascript:void(0)"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#reportModal"
                                                    data-route="{{ route('user.report.submit',$data->id) }}"
                                                    class="reportButton"
                                                >
                                                    <i class="fal fa-exclamation-circle"></i>
                                                    <span>@lang('Report')</span>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#gotoPlanModal"
                                                >
                                                    <i class="fal fa-user"></i>
                                                    <span>@lang('Report')</span>
                                                </a>
                                            @endif
                                        @endguest


                                        @guest
                                            <a href="javascript:void(0)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#gotoPlanModal"
                                            >
                                                <i class="fas fa-comments-alt"></i>
                                                <span>@lang('Message')</span>
                                            </a>
                                        @else
                                            @if(@auth()->user()->id != $data->id)
                                                <a href="javascript:void(0)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#messageModal"
                                                data-route="{{ route('user.send.message',$data->id) }}"
                                                class="sendMessageButton"
                                                >
                                                    <i class="fas fa-comments-alt"></i>
                                                    <span>@lang('Message')</span>
                                                </a>
                                            @endif
                                        @endguest



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

                        <div class="row py-5">
                            {{ $allUser->links() }}
                        </div>

                    </div>

                </div>
            </div>
        </section>
    <!-- /Member -->


    <!-- Goto Purchase Plan Modal -->
    <div id="gotoPlanModal" class="modal fade modal-with-form" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content form-block">
                <div class="modal-body">
                    <div class="form-group">
                        @auth
                            <h4 class="text-green text-center py-4 mb-0">@lang('Please Upgrade Your Package')</h4>
                        @else
                            <h4 class="text-green text-center py-4 mb-0">@lang('Please At First Login To Your Account')</h4>
                        @endauth
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-flower2 btn1" data-bs-dismiss="modal">@lang('Close')</button>
                    @auth
                        <a href="{{route('plan')}}">
                            <button type="submit" class="btn-flower2 btn2 planPurchaseButton">@lang('Purchase Package')</button>
                        </a>
                    @else
                        <a href="{{route('login')}}">
                            <button type="submit" class="btn-flower2 btn2 planPurchaseButton">@lang('Login Account')</button>
                        </a>
                    @endauth
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
                            <label for="reason">@lang('Report Reason')</label>
                            <textarea name="reason" id="reason" cols="30" rows="4" class="form-control" required placeholder="@lang('type here...')"></textarea>
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


@push('css-lib')
    <link rel="stylesheet" href="{{asset($themeTrue.'css/select2.min.css')}}" />
@endpush
@push('extra-js')
    <script src="{{asset($themeTrue.'js/select2.min.js')}}"></script>
@endpush


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
                            // {{--window.location.href = "{{route('plan')}}"--}}
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

        // message
        $(document).on('click', '.sendMessageButton', function (){
            var route = $(this).data('route');
            $('.messageSend').attr('action', route)
        })


        // for Religion & Caste select in search
        var idReligionSelect = $("#religion-dds").val();
        var selectedCasteSearch = "{{request()->caste??null}}"

        getCasteSearch(idReligionSelect, selectedCasteSearch);

        $(document).on('change', '#religion-dds', function () {
            var idReligionSelect = this.value;
            $("#caste-dds").html('');
            getCasteSearch(idReligionSelect);
        });

        function getCasteSearch(idReligionSelect, selectedCasteSearch = null) {
            $.ajax({
                url: "{{route('user.getCaste')}}",
                type: "POST",
                data: {
                    religion_id: idReligionSelect,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#caste-dds').html('<option value="">@lang("Select Caste")</option>');
                    $.each(result.caste, function (key, value) {
                        $("#caste-dds").append(`<option value="${value.id}" ${(value.id == selectedCasteSearch) ? 'selected' : ''}>${value.name}</option>`);
                    });
                }
            });
        }



        // for Country, State & City select in search
        var idCountrySearch = $("#country-dds").val();
        var selectedStateSearch = "{{request()->state??null}}"
        var selectedCitySearch = "{{request()->city??null}}"


        getStatesSearch(idCountrySearch, selectedStateSearch);
        getCitiesSearch(selectedStateSearch, selectedCitySearch);

        $(document).on('change', '#country-dds', function () {
            var idCountrySearch = this.value;
            $("#state-dds").html('');
            getStatesSearch(idCountrySearch);
        });

        $(document).on('change', '#state-dds', function () {
            var idStateSearch = this.value;
            $("#city-dds").html('');
            getCitiesSearch(idStateSearch)
        });


        function getStatesSearch(idCountrySearch, selectedStateSearch = null) {
            $.ajax({
                url: "{{route('user.states')}}",
                type: "POST",
                data: {
                    country_id: idCountrySearch,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#state-dds').html('<option value="">@lang("Select State")</option>');
                    $.each(result.states, function (key, value) {
                        $("#state-dds").append(`<option value="${value.id}" ${(value.id == selectedStateSearch) ? 'selected' : ''}>${value.name}</option>`);
                    });
                    $('#city-dds').html(`<option value="">@lang("Select City")</option>`);
                }
            });
        }

        function getCitiesSearch(idStateSearch = null, selectedCitySearch = null) {
            $.ajax({
                url: "{{route('user.cities')}}",
                type: "POST",
                data: {
                    state_id: idStateSearch,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#city-dds').html(`<option value="">@lang("Select City")</option>`);
                    $.each(res.cities, function (key, value) {
                        $("#city-dds").append(`<option value="${value.id}" ${(value.id == selectedCitySearch) ? 'selected' : ''}>${value.name}</option>`);
                    });
                }
            });
        }


        // for select2
        $(document).ready(function () {
            $('select').select2({
                width:'100%',
                selectOnClose: true
            });
        });
    </script>

@endpush

<!-- Plan -->
@if(0 < count($plans))
    @if(isset($templates['package'][0]) && $package = $templates['package'][0])
        <section class="pricing-section">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="header-text">
                            <h2>@lang(@$package->description->title)</h2>
                            <p>@lang(@$package->description->sub_title)</p>
                        </div>
                    </div>
                </div>

                <div class="row gy-3 g-md-5">
                    @foreach ($plans as $data)
                        <div class="col-lg-4 col-md-6">
                            <div class="box">
                                <div class="icon-box"><i class="{{$data->icon}}"></i></div>
                                <div class="text-box">
                                <h4>@lang($data->details->name)</h4>
                                @if($data->price == 0)
                                    <h2>@lang('Free')</h2>
                                @else
                                    <h2><span>@lang($basic->currency_symbol ?? '$')</span>{{$data->price}}</h2>
                                @endif
                                <ul>
                                    <li>
                                        @if($data->express_interest_status == 1)
                                            <i class="fal fa-check"></i>
                                        @else
                                            <i class="far fa-times"></i>
                                        @endif
                                        <span>@lang($data->express_interest) @lang('Express Interests')</span>
                                    </li>
                                    <li>
                                        @if($data->gallery_photo_upload_status == 1)
                                            <i class="fal fa-check"></i>
                                        @else
                                            <i class="far fa-times"></i>
                                        @endif
                                        <span>@lang($data->gallery_photo_upload) @lang('Gallery Photo Upload')</span>
                                    </li>
                                    <li>
                                        @if($data->contact_view_info_status == 1)
                                            <i class="fal fa-check"></i>
                                        @else
                                            <i class="far fa-times"></i>
                                        @endif
                                        <span>@lang($data->contact_view_info) @lang('Profile Info View')</span>
                                    </li>
                                    <li>
                                        @if($data->show_auto_profile_match == 1)
                                            <i class="fal fa-check"></i>
                                        @else
                                            <i class="far fa-times"></i>
                                        @endif
                                        <span>@lang('Show Auto Profile Match')</span>
                                    </li>

                                </ul>

                                @if(isset($freePlan->free_plan_purchased) && $freePlan->free_plan_purchased == 1 && $data->price == 0)
                                    <button class="btn-flower disabled planPurchaseButton"
                                    >
                                        <del>@lang('Purchase Package')</del>
                                    </button>
                                @else
                                    <button class="btn-flower purchaseNow planPurchaseButton"
                                            data-bs-toggle="modal"
                                            data-bs-target="#planModal"
                                            data-price="{{$data->price}}"
                                            data-resource="{{$data->details}}"
                                    >
                                        @lang('Purchase Package')
                                    </button>
                                @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <img
            src="{{getFile(config('location.content.path').@$package->templateMedia()->right_image)}}"
            alt="@lang('package image')"
            class="flower"
            data-aos="fade-up"
            data-aos-duration="800"
            data-aos-anchor-placement="center-bottom"
            />
        </section>


        <!--Plan Modal -->
        <div id="planModal" class="modal fade modal-with-form" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">

                <!-- Modal content-->
                <div class="modal-content form-block">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Purchase Package')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="login-form" id="invest-form" action="{{route('user.purchase-plan')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <h3 class="text-green text-center plan-name"></h3>

                                <h4 class="text-center plan-price"></h4>

                                <input type="hidden" name="checkout" value="checkout">

                                <input type="hidden" name="plan_id" class="plan-id">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-flower2 btn1" data-bs-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn-flower2 btn2">@lang('Purchase Now')</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>

    @endif

@endif

@if(request()->routeIs('plan') && 0 >= count($plans))
    <div class="d-flex flex-column justify-content-center py-5">
        <h3 class="text-center mt-5 mb-5">@lang('No Plan Available.')</h3>
        <a href="{{ route('home') }}" class="text-center">
            <button class="btn-flower">
                @lang('Back to Home')
            </button>
        </a>
    </div>
@endif


@push('script')
    <script>
        "use strict";
        (function ($) {
            $(document).on('click', '.purchaseNow', function () {
                let data = $(this).data('resource');
                let price = $(this).data('price');

                let symbol = "{{trans($basic->currency_symbol)}}";

                $('.plan-price').text(`@lang('Price'): ${symbol}${price}`);

                $('.plan-name').text(data.name);
                $('.plan-id').val(data.plan_id);
            });
        })(jQuery);

        $(document).on('click', '.disabled', function (){
            Notiflix.Notify.Failure("@lang('You can use this package only once. Please purchase new one.')");
        })

    </script>


    @if(count($errors) > 0 )
        <script>
            @foreach($errors->all() as $key => $error)
            Notiflix.Notify.Failure("@lang($error)");
            @endforeach
        </script>
    @endif

@endpush



<!-- /Plan -->

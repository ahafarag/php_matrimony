@if(isset($templates['premium-member'][0]) && $premiumMember = $templates['premium-member'][0])
    <section class="premium-members">
        <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text">
                    <h2>@lang(@$premiumMember->description->title)</h2>
                    <p>@lang(@$premiumMember->description->sub_title)</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="members owl-carousel">
                    @foreach($premiumMembers as $data)
                        <div class="box">
                            <div class="img-box">
                                <img src="{{getFile(config('location.user.path').optional($data->user)->image) }}" alt="@lang('premium member image')" />
                            </div>
                            <div class="text-box">
                                <h4>@lang(optional($data->user)->firstname) @lang(optional($data->user)->lastname)</h4>
                                <h5><span>@</span>@lang(optional($data->user)->username)</h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
        <img
        src="{{getFile(config('location.content.path').@$premiumMember->templateMedia()->left_image)}}"
        alt="@lang('premium-member image')"
        class="flower"
        data-aos="fade-up"
        data-aos-duration="800"
        data-aos-anchor-placement="center-bottom"
        />
    </section>
@endif

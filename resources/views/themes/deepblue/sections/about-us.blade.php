@if(isset($templates['about-us'][0]) && $aboutUs = $templates['about-us'][0])

    <!-- ABOUT-US -->
    <section class="about-section">
        <div class="container">
            <div
                class="row align-items-center justify-content-between gy-5 g-lg-5"
            >
                <div class="col-lg-6">
                    <div class="img-box">
                    <img class="about-img" src="{{getFile(config('location.content.path').@$aboutUs->templateMedia()->left_image)}}" alt="@lang('about img')" />
                    <img class="" src="{{getFile(config('location.content.path').@$aboutUs->templateMedia()->right_image)}}" alt="@lang('about frame img')" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-box">
                    <h2>@lang(@$aboutUs->description->title)</h2>
                    <p>{!! trans($aboutUs->description->short_description) !!}</p>

                    <a href="{{route('about')}}">
                        <button class="btn-flower">@lang('know more')</button>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /ABOUT-US -->
@endif



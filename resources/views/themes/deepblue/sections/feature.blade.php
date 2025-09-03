
@if(isset($contentDetails['feature']))
    @if(0 < count($contentDetails['feature']))
    <!-- FEATURE -->
    <section class="feature-section">
        <div class="container">
            <div class="row gy-5 g-md-5">
                @foreach($contentDetails['feature'] as $feature)
                    <div class="col-lg-4 col-md-6">
                        <div class="box">
                            <div class="icon-box">
                                <i class="{{@$feature->content->contentMedia->description->icon}}"></i>
                            </div>
                            <div class="text-box">
                                <h4>@lang(@$feature->description->title)</h4>
                                <p>@lang(@$feature->description->information)</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if(isset($templates['feature'][0]) && $feature = $templates['feature'][0])
            <img
            src="{{getFile(config('location.content.path').@$feature->templateMedia()->left_image)}}"
            alt="@lang('feature image')"
            class="flower"
            data-aos="fade-right"
            data-aos-duration="800"
            data-aos-anchor-placement="center-bottom"
            />
        @endif
    </section>
    <!-- /FEATURE -->
    @endif
@endif

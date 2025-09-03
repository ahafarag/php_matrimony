@if(isset($templates['counter'][0]) && $counter = $templates['counter'][0])
    @if(isset($contentDetails['testimonial']))
    @if(0 < count($contentDetails['testimonial']))
        <section class="counter-section">
            <div class="container">
                <div class="row gy-5 g-md-5">
                    @foreach($contentDetails['counter'] as $key=>$data)
                        <div class="col-lg-3 col-md-6">
                            <div class="box">
                                <h2><span class="counter">@lang(@$data->description->number)</span></h2>
                                <h4>@lang(@$data->description->title)</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <img
            src="{{getFile(config('location.content.path').@$counter->templateMedia()->right_image)}}"
            alt="@lang('Counter image')"
            class="flower"
            class="flower"
            data-aos="fade-left"
            data-aos-duration="800"
            data-aos-anchor-placement="center-bottom"
            />
        </section>
    @endif
    @endif
@endif

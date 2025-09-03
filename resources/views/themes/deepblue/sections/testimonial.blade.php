@if(isset($templates['testimonial'][0]) && $testimonial = $templates['testimonial'][0])

    <!-- TESTIMONIAL -->
    <section class="testimonial-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-text">
                        <h2>@lang($testimonial->description->title)</h2>
                        <p>@lang($testimonial->description->sub_title)</p>
                    </div>
                </div>
            </div>
            @if(isset($contentDetails['testimonial']))
            @if(0 < count($contentDetails['testimonial']))
                <div class="row">
                    <div class="col">
                        <div class="testimonials owl-carousel">
                                @foreach($contentDetails['testimonial'] as $key=>$data)
                                <div class="box">
                                    <div class="img-box">
                                        <img src="{{getFile(config('location.content.path').@$data->content->contentMedia->description->image)}}" alt="@lang('testimonial img')" />
                                        <i class="fal fa-quote-right"></i>
                                    </div>
                                    <div class="text-box">
                                        <h4>@lang(@$data->description->name)</h4>
                                        <h5>@lang(@$data->description->relation)</h5>
                                        <p>@lang(@$data->description->description)</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                    </div>
                </div>
            @endif
            @endif
        </div>

        <img
           src="{{getFile(config('location.content.path').@$testimonial->templateMedia()->left_image)}}"
           alt="@lang('Testimonial image')"
           class="flower"
           data-aos="fade-up"
           data-aos-duration="800"
           data-aos-anchor-placement="center-bottom"
        />
     </section>
    <!-- /TESTIMONIAL -->

@endif

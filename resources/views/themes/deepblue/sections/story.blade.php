@if(isset($templates['story'][0]) && $story = $templates['story'][0])
    @if(0<count($stories))

        <!-- happy stories -->
        <section class="happy-stories">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="header-text">
                            <h2>@lang(@$story->description->title)</h2>
                            <p>@lang(@$story->description->sub_title)</p>
                        </div>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3"
                    data-masonry='{"percentPosition": true }'>

                    @if(request()->routeIs('home'))
                        @foreach ($stories->take(9)->shuffle() as $data)
                            <div class="col">
                                <div class="img-box">
                                <img src="{{getFile(config('location.story.path').'thumb_'.@$data->image)}}" alt="" class="img-fluid" />
                                <a href="{{ route('storyDetails',[slug($data->title), $data->id]) }}" class="hover-content">
                                    <div class="text-box">
                                        <h4>@lang($data->name)</h4>
                                        <h5>@lang($data->place) - {{dateTime(@$data->date,'d M, Y')}}</h5>
                                    </div>
                                </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach ($stories->shuffle() as $data)
                            <div class="col">
                                <div class="img-box">
                                    <img src="{{getFile(config('location.story.path').'thumb_'.@$data->image)}}" alt="@lang('story img')" class="img-fluid" />
                                    <a href="{{ route('storyDetails',[slug($data->title), $data->id]) }}" class="hover-content">
                                        <div class="text-box">
                                            <h4>@lang($data->name)</h4>
                                            <h5>@lang($data->place) - {{dateTime(@$data->date,'d M, Y')}}</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

                @if(!request()->routeIs('home'))
                    <div class="row py-5 mt-5">
                        {{ $stories->links() }}
                    </div>
                @endif

                @if(request()->routeIs('home') && 9<count($stories))
                    <div class="mt-5 text-center">
                        <a href="{{route('story')}}">
                            <button class="btn-flower">@lang('show more')</button>
                        </a>
                    </div>
                @endif

            </div>

            <img
                src="{{getFile(config('location.content.path').@$story->templateMedia()->right_image)}}"
                alt="@lang('story image')"
                class="flower"
                data-aos="fade-up"
                data-aos-duration="800"
                data-aos-anchor-placement="center-bottom"
            />
        </section>

    @else
        @if(!request()->routeIs('home'))
            <div class="row py-5 mt-5">
                <h2 class="py-5 text-center">@lang('No Story Available.')</h2>
            </div>
        @endif
    @endif
@endif

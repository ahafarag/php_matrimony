@extends($theme.'layouts.app')
@section('title',trans('Story Details'))

@section('content')
    <!-- story section -->
    <section class="story-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <h4>@lang($story->title)</h4>
                        <p class="date-author">
                            @lang('Posted By') <a href="{{route('user.profile')}}">@lang(optional($story->user)->username)</a> @lang('On')
                            <span>{{dateTime(@$data->date,'d M, Y')}}</span>
                        </p>
                    </div>
                    <div class="img-box">
                        <img class="img-fluid" src="{{getFile(config('location.story.path').$story->image)}}" alt="@lang('story image')" />
                    </div>
                    <div class="text-box">
                        <p>@lang($story->description)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- photo gallery -->
    <section class="photo-gallery happy-stories bg-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-text">
                    <h2>@lang('photo gallery')</h2>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                @if (isset($story->gallery))
                    @foreach ( $story->gallery as $data )
                        <div class="col-lg-3 col-6">
                            <div class="img-box">
                                <img src="{{getFile(config('location.story.path').'thumb_'.@$data)}}" alt="@lang('gallery img')" class="img-fluid"/>
                                <div class="hover-content cursorDefault">
                                    <div class="text-box">
                                        <a href="{{getFile(config('location.story.path').@$data)}}" data-fancybox="gallery" class="mx-2 iconHoverBg">
                                            <i class="fas fa-search-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5 class="py-5 text-center">@lang('No Gallery Image Available.')</h5>
                @endif
            </div>
        </div>
    </section>
@endsection

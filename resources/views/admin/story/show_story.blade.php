@extends('admin.layouts.app')
@section('title')
    @lang('Story Details')
@endsection

@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow storyShow">

        <div class="card-body">
                <div class="row g-3 g-md-4">
                    <div class="col-md-6 form-group mt-2">
                        <label for="name">@lang('Name')</label>
                        <input type="text" name="name" value="{{ $story->name }}" class="form-control" readonly/>
                    </div>

                    <div class="col-md-6 form-group mt-2">
                        <label for="place">@lang('Place')</label>
                        <input type="text" name="place" value="{{ $story->place }}" class="form-control" readonly/>
                    </div>

                    <div class="col-md-12 form-group mt-2">
                        <label for="title">@lang('Story Title')</label>
                        <input type="text" name="title" value="{{ $story->title }}" class="form-control" readonly/>
                    </div>

                    <div class="col-md-12 form-group mt-2">
                        <label for="description">@lang('Description')</label>
                        <textarea name="description" cols="30" rows="10" class="form-control" readonly>{{ $story->description }}</textarea>
                    </div>

                    <div class="col-md-6 form-group mt-2">
                        <label for="privacy">@lang('Privacy')</label>
                        <input type="text" name="privacy" class="form-control" readonly
                               value="@if($story->privacy == 1) @lang('Public') @elseif($story->privacy == 2) @lang('Follower') @elseif($story->privacy == 3) @lang('Only Me') @endif"
                        />
                    </div>

                    <div class="col-md-6 form-group mt-2">
                        <label for="date">@lang('Date') </label>
                        <input type="text" name="date" value="{{ $story->date }}" class="form-control" readonly/>
                    </div>

                    <div class="col-12 form-group mt-3">
                        <label for="image">@lang('Image')</label>
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <img src="{{ getFile(config('location.story.path').$story->image) }}"
                                     class="p-3 bg-light"
                                     alt="@lang('preview image')"
                                     width="350px" height="250px"
                                >
                            </div>
                        </div>
                    </div>


                    <div class="col-12 form-group mt-4">
                        <label for="image">@lang('Gallery Images')</label>
                        <div class="row">
                            @if($story->gallery)
                                @for($i = 0; $i<count($story->gallery); $i++)
                                    <div class="col-sm-12 col-md-3 image-column">
                                        <img src="{{ getFile(config('location.story.path').$story->gallery[$i]) }}"
                                             class="p-3 bg-light"
                                             alt="@lang('preview image')"
                                             width="350px" height="250px"
                                        >
                                    </div>
                                @endfor
                            @endif
                        </div>
                    </div>

                </div>
        </div>
    </div>

@endsection

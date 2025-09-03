@extends($theme.'layouts.user')
@section('title',__('Create Story'))

@section('content')

    <section class="dashboard-section">
        <div class="container">
            <div class="row gy-5 g-lg-4">
                @include($theme.'user.sidebar')

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="dashboard-title">
                                    <h5>@lang('Create Story')</h5>
                                </div>

                                <form method="post" action="{{ route('user.story.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3 g-md-4 generate-btn-parent">
                                        <div class="col-md-6 form-group">
                                            <label for="name">@lang('Name')</label>
                                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="@lang('Enter Name')"/>
                                            @error('name')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="place">@lang('Place')</label>
                                            <input type="text" name="place" value="{{ old('place') }}" placeholder="@lang('Enter Place Name')" class="form-control"/>
                                            @error('place')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label for="title">@lang('Story Title')</label>
                                            <input type="text" name="title" value="{{ old('title') }}" placeholder="@lang('Enter Story Title')" class="form-control"/>
                                            @error('title')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label for="description">@lang('Description')</label>
                                            <textarea name="description" cols="30" rows="10" class="form-control">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                         </div>

                                        <div class="col-md-6 form-group">
                                            <label for="privacy">@lang('Privacy')</label>
                                            <select value="" name="privacy" class="form-select" aria-label="Privacy">
                                                <option disabled selected>@lang('Select One')</option>
                                                <option value="1">@lang('Public')</option>
                                                <option value="2">@lang('Follower')</option>
                                                <option value="3">@lang('Only Me')</option>
                                            </select>
                                            @error('privacy')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="date">@lang('Date')</label>
                                            <input type="date" name="date" value="{{ old('date') }}" placeholder="@lang('Select a Date')" class="form-control"/>
                                            @error('date')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 form-group">
                                            <label for="image">@lang('Upload Image')</label>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new " data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail bookingForm-thumbnail"
                                                            data-trigger="fileinput">
                                                        <img class="w-150px"
                                                                src="{{ getFile(config('location.default')) }}"
                                                                alt="@lang('story image')">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail wh-200-150"></div>

                                                    <div class="img-input-div">
                                                        <span class="btn btn-outline-success btn-file">
                                                            <span
                                                                class="fileinput-new font14"> @lang('Select Image')</span>
                                                            <span
                                                                class="fileinput-exists"> @lang('Change')</span>
                                                            <input type="file" name="image" accept="image/*">
                                                        </span>
                                                        <a href="#" class="btn btn-outline-danger fileinput-exists"
                                                            data-dismiss="fileinput"> @lang('Remove')</a>
                                                    </div>

                                                </div>
                                            </div>
                                            @if(config("location.story.size"))
                                                <span class="size text-muted mb-2">{{trans('Image size should be')}} {{config("location.story.size")}} {{trans('px')}}</span>
                                            @endif
                                            <br>
                                            @error('image')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <div class="col-lg-12 col-md-6 my-2">
                                                <div class="form-group">
                                                    <a href="javascript:void(0)" class="btn btn-green float-left mt-3 generate">
                                                        <i class="fa fa-plus-circle"></i> {{ __('Add Gallery Images') }}</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row addedField mt-3">

                                    </div>

                                    <div class="col-12 text-end mt-3">
                                        <button type="submit" class="btn-flower2 w-100">@lang('Create')</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                 </div>

            </div>
        </div>
    </section>

@endsection


@push('css-lib')
    <link rel="stylesheet" href="{{asset($themeTrue.'css/bootstrap-fileinput.css')}}">
@endpush

@push('extra-js')
    <script src="{{asset($themeTrue.'js/bootstrap-fileinput.js')}}"></script>
@endpush

@push('script')

    <script>
        "use strict";
        $(document).ready(function (e) {

            $(".generate").on('click', function () {
                var form = `<div class="col-sm-12 col-md-4 image-column mt-1 mb-4">
                                <div class="form-group">
                                    <div class="input-group justify-content-between">
                                        <div class="image-input position-relative z0">
                                            <label for="gallery" id="image-label"><i class="fas fa-upload"></i></label>
                                            <input type="file" name="gallery[]" id="gallery" placeholder="@lang('Choose Image')" class="image-preview" required>
                                            <img id="image_preview_container" class="preview-image"	src="{{ getFile(config('location.story.path')) }}" alt="@lang('Preview Image')">
                                        </div>
                                        @if(config("location.story.size"))
                                            <span class="text-muted mb-2">{{trans('Image size should be')}} {{config("location.story.size")}} {{trans('px')}}</span>
                                        @endif
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger delete_desc removeFile z9" type="button" title="@lang('Remove Image')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div> `;
                $(this).parents('.generate-btn-parent').siblings('.addedField').append(form)
            });


            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.input-group').parents('.image-column').remove();
            });

            $(document).on('change','.image-preview', function () {
                let reader = new FileReader();
                let _this = this;
                reader.onload = (e) => {
                    $(_this).siblings('.preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });


        });
    </script>
@endpush

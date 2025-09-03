@extends($theme.'layouts.user')
@section('title',__('Edit Story'))

@section('content')

    <section class="dashboard-section happy-stories bg-white">
        <div class="container">
            <div class="row gy-5 g-lg-4">
                @include($theme.'user.sidebar')

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="dashboard-title">
                                    <h5>@lang('Edit Story')</h5>
                                </div>

                                <form method="post" action="{{ route('user.story.update', $story->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row g-3 g-md-4 generate-btn-parent">
                                        <div class="col-md-6 form-group">
                                            <label for="name">@lang('Name')</label>
                                            <input type="text" name="name" value="{{ old('name', $story->name) }}" class="form-control" placeholder="@lang('Enter Name')"/>
                                            @error('name')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="place">@lang('Place')</label>
                                            <input type="text" name="place" value="{{ old('place', $story->place) }}" placeholder="@lang('Enter Place Name')" class="form-control"/>
                                            @error('place')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label for="title">@lang('Story Title')</label>
                                            <input type="text" name="title" value="{{ old('title', $story->title) }}" placeholder="@lang('Enter Story Title')" class="form-control"/>
                                            @error('title')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label for="description">@lang('Description')</label>
                                            <textarea name="description" cols="30" rows="10" class="form-control">{{ old('description', $story->description) }}</textarea>
                                            @error('description')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                         </div>

                                        <div class="col-md-6 form-group">
                                            <label for="privacy">@lang('Privacy')</label>
                                            <select value="" name="privacy" class="form-select" aria-label="Privacy">
                                                <option disabled>@lang('Select One')</option>
                                                <option value="1" {{$story->privacy == 1 ? 'selected' : ''}}>@lang('Public')</option>
                                                <option value="2" {{$story->privacy == 2 ? 'selected' : ''}}>@lang('Follower')</option>
                                                <option value="3" {{$story->privacy == 3 ? 'selected' : ''}}>@lang('Only Me')</option>
                                            </select>
                                            @error('privacy')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="date">@lang('Date')</label>
                                            <input type="date" name="date" value="{{ old('date', $story->date) }}" placeholder="@lang('Select a Date')" class="form-control"/>
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
                                                                src="{{ getFile(config('location.story.path').$story->image) }}"
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
                                        

                                        <label class="mt-5 mb-3 h6"> @lang('Existing Gallery Images :') </label>
                                        <div class="row addedField">
                                            @if(isset($story->gallery))
                                                @for($i = 0; $i<count($story->gallery); $i++)
                                                    <div class="col-md-4">
                                                        <div class="img-box">
                                                            <img src="{{ getFile(config('location.story.path').'thumb_'.$story->gallery[$i]) }}" alt="@lang('gallery img')" class="img-fluid storyDetailImageSize" />
                                                            <div class="hover-content cursorDefault">
                                                                <div class="text-box">
                                                                    <a href="{{ getFile(config('location.story.path').$story->gallery[$i]) }}" data-fancybox="gallery" class="mx-2 iconHoverBg">
                                                                        <i class="fas fa-search-plus"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)"
                                                                       class="iconHoverBg notiflix-confirm"
                                                                       data-route="{{ route('user.galleryImageDelete',[$story->id,$story->gallery[$i]]) }}"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#delete-modal"
                                                                            title="@lang('Delete Image')">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endfor
                                            @else
                                                <h5 class="pb-5 mt-2 text-center">@lang('No Gallery Image Available!')</h5>
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <a href="javascript:void(0)" class="btn btn-green generate">
                                                    <i class="fa fa-plus-circle"></i> {{ __('Add More New Gallery Images') }}</a>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row addedField mt-3">

                                    </div>

                                    <div class="col-12 text-end mt-3">
                                        <button type="submit" class="btn-flower2 w-100">@lang('Update')</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                 </div>

            </div>
        </div>
    </section>



    <!-- Delete Gallery Image -->
    <div id="delete-modal" class="modal fade modal-with-form" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content form-block">
                 <div class="modal-header">
                         <h5 class="modal-title">@lang('Delete Confirmation')</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <p>@lang('Are you sure to delete this?')</p>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn-flower2 btn1" data-bs-dismiss="modal">@lang('Close')</button>
                     <form action="" method="post" class="deleteRoute">
                         @csrf
                         @method('delete')
                         <button type="submit" class="btn-flower2 btn2">@lang('Yes')</button>
                     </form>
                 </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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

            $('.notiflix-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })


        });
    </script>
@endpush

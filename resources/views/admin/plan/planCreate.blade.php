@extends('admin.layouts.app')
@section('title')
    @lang('Create Package')
@endsection
@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 justify-content-end">
                <a href="{{route('admin.planList')}}" class="btn btn-sm  btn-primary mr-2">
                    <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                </a>
            </div>


            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @foreach($languages as $key => $language)
                    <li class="nav-item">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#lang-tab-{{ $key }}" role="tab" aria-controls="lang-tab-{{ $key }}"
                           aria-selected="{{ $loop->first ? 'true' : 'false' }}">@lang($language->name)</a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content mt-2" id="myTabContent">
                @foreach($languages as $key => $language)

                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-tab-{{ $key }}" role="tabpanel">
                        <form method="post" action="{{ route('admin.planStore', $language->id) }}" class="mt-4" enctype="multipart/form-data">
                            @csrf
                            <div class="row generate-btn-parent">
                                <div class="col-sm-12 col-md-6">
                                    <label for="name"> @lang('Package Name') </label>
                                    <input type="text" name="name[{{ $language->id }}]"
                                            class="form-control  @error('name'.'.'.$language->id) is-invalid @enderror"
                                            value="{{ old('name'.'.'.$language->id) }}" placeholder="@lang('Enter package name')">
                                    <div class="invalid-feedback">
                                        @error('name'.'.'.$language->id) @lang($message) @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>

                                @if ($loop->index == 0)
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Price')</label>
                                            <div class="input-group">
                                                <input type="number" name="price" class="form-control"
                                                value="{{ old('price') }}" placeholder="@lang('Enter package price')">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        {{ $basic->currency ?? 'USD' }}
                                                    </div>
                                                </div>
                                            </div>
                                            @error('price')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="icon">@lang('Icon')</label>
                                            <div class="input-group">
                                                <input type="text" name="icon"
                                                       class="form-control icon"
                                                       value="{{ old('icon') }}"
                                                       placeholder="@lang('Select Icon')">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary iconPicker" data-icon="fas fa-home" role="iconpicker"></button>
                                                </div>
                                            </div>
                                            @error('icon')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>@lang('Show Auto Profile Match')</label>
                                            <div class="custom-switch-btn">
                                                <input type='hidden' value='1' name='show_auto_profile_match'>
                                                <input type="checkbox" name="show_auto_profile_match" class="custom-switch-checkbox"
                                                    id="show_auto_profile_match"
                                                    value="0">
                                                <label class="custom-switch-checkbox-label" for="show_auto_profile_match">
                                                    <span class="custom-switch-checkbox-inner"></span>
                                                    <span class="custom-switch-checkbox-switch"></span>
                                                </label>
                                            </div>
                                            @error('show_auto_profile_match')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-6 mb-3">
                                        <label>@lang('Express Interest')</label>
                                        <input type="number" name="express_interest" class="form-control" value="{{ old('express_interest') }}" placeholder="@lang('Enter express interest number')">
                                        @error('express_interest')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                                        <label>@lang('Express Interest Status')</label>
                                        <div class="custom-switch-btn">
                                            <input type='hidden' value='1' name='express_interest_status'>
                                            <input type="checkbox" name="express_interest_status" class="custom-switch-checkbox"
                                                id="express_interest_status"
                                                value="0">
                                            <label class="custom-switch-checkbox-label" for="express_interest_status">
                                                <span class="custom-switch-checkbox-inner"></span>
                                                <span class="custom-switch-checkbox-switch"></span>
                                            </label>
                                        </div>
                                        @error('express_interest_status')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>


                                    <div class="col-sm-12 col-md-6">
                                        <label>@lang('Gallery Photo Upload')</label>
                                        <input type="number" name="gallery_photo_upload" class="form-control" value="{{ old('gallery_photo_upload') }}" placeholder="@lang('Enter gallery photo upload number')">
                                        @error('gallery_photo_upload')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>@lang('Gallery Photo Upload Status')</label>
                                            <div class="custom-switch-btn">
                                                <input type='hidden' value='1' name='gallery_photo_upload_status'>
                                                <input type="checkbox" name="gallery_photo_upload_status" class="custom-switch-checkbox"
                                                    id="gallery_photo_upload_status"
                                                    value="0">
                                                <label class="custom-switch-checkbox-label" for="gallery_photo_upload_status">
                                                    <span class="custom-switch-checkbox-inner"></span>
                                                    <span class="custom-switch-checkbox-switch"></span>
                                                </label>
                                            </div>
                                            @error('gallery_photo_upload_status')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-6">
                                        <label>@lang('Profile Info View')</label>
                                        <input type="number" name="contact_view_info" class="form-control" value="{{ old('contact_view_info') }}" placeholder="@lang('Enter profile info view number')">
                                        @error('contact_view_info')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>@lang('Profile Info View Status')</label>
                                            <div class="custom-switch-btn">
                                                <input type='hidden' value='1' name='contact_view_info_status'>
                                                <input type="checkbox" name="contact_view_info_status" class="custom-switch-checkbox"
                                                    id="contact_view_info_status"
                                                    value="0">
                                                <label class="custom-switch-checkbox-label" for="contact_view_info_status">
                                                    <span class="custom-switch-checkbox-inner"></span>
                                                    <span class="custom-switch-checkbox-switch"></span>
                                                </label>
                                            </div>
                                            @error('contact_view_info_status')
                                                <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="col-sm-6 col-md-6 col-lg-4 mt-4 mb-2">
                                        <label>@lang('Package Status')</label>
                                        <div class="custom-switch-btn">
                                            <input type='hidden' value='1' name='status'>
                                            <input type="checkbox" name="status" class="custom-switch-checkbox"
                                                id="status"
                                                value="0">
                                            <label class="custom-switch-checkbox-label" for="status">
                                                <span class="custom-switch-checkbox-inner"></span>
                                                <span class="custom-switch-checkbox-switch"></span>
                                            </label>
                                        </div>
                                        @error('status')
                                            <span class="text-danger">@lang($message)</span>
                                        @enderror
                                    </div>

                                @endif

                            </div>

                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save')</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


@push('style-lib')
    <link href="{{ asset('assets/admin/css/bootstrap-iconpicker.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
@endpush

@push('js')
    <script>
        "use strict";

        $(document).ready(function () {
            $('select[name=plan_id]').select2({
                selectOnClose: true
            });
        });
    </script>

    <script>

        "use strict";
        $(document).ready(function (e) {

            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.input-group').parent().remove();
            });


            $('.iconPicker').iconpicker({
                align: 'center', // Only in div tag
                arrowClass: 'btn-danger',
                arrowPrevIconClass: 'fas fa-angle-left',
                arrowNextIconClass: 'fas fa-angle-right',
                cols: 10,
                footer: true,
                header: true,
                icon: 'fas fa-bomb',
                iconset: 'fontawesome5',
                labelHeader: '{0} of {1} pages',
                labelFooter: '{0} - {1} of {2} icons',
                placement: 'bottom', // Only in button tag
                rows: 5,
                search: true,
                searchText: 'Search icon',
                selectedClass: 'btn-success',
                unselectedClass: ''
            }).on('change', function (e) {
                $(this).parent().siblings('.icon').val(`${e.icon}`);
            });


        });
    </script>

    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.Failure("{{trans($error)}}");
            @endforeach
        </script>
    @endif

@endpush

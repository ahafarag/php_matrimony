@extends($theme.'layouts.user')
@section('title',trans('Gallery'))

@section('content')

    <section class="dashboard-section happy-stories bg-white">
        <div class="container">
            <div class="row gy-5 g-lg-4">

                @include($theme.'user.sidebar')

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="dashboard-title">
                                    <h5>@lang('Gallery List')</h5>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="box galleryBox d-flex align-items-center justify-content-center">
                                    <div>
                                        <div class="icon-box">
                                            <i class="fal fa-image" aria-hidden="true"></i>
                                        </div>
                                        <h4>@lang($purchasedPlanItems->gallery_photo_upload ?? 0)</h4>
                                        <span class="d-block">@lang('Remaining')</span>
                                        <span>@lang('Gallery Image Upload')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form method="post" action="{{ route('user.gallery.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="image-input userGalleryImage">
                                        <label for="image-upload" id="image-label"><i
                                                class="fas fa-upload"></i></label>
                                        <input type="file" name="image" placeholder="@lang('Choose image')" id="image" required>
                                        <img class="w-100 preview-image" id="image_preview_container"
                                             src="{{getFile(config('location.default'))}}"
                                             alt="@lang('Upload Image')">
                                    </div>
                                    @error('image')
                                        <span class="text-danger">@lang($message)</span>
                                    @enderror
                                    <div class="text-center mt-3">
                                        @if(isset($purchasedPlanItems) && $purchasedPlanItems->gallery_photo_upload > 0)
                                            <button type="submit" class="btn-flower">
                                                <span>@lang('Image Upload')</span>
                                            </button>
                                        @else
                                            <a href="javascript:void(0)"
                                                class="btn-flower"
                                                data-bs-toggle="modal"
                                                data-bs-target="#gotoPlanModal"
                                            >
                                                <span>@lang('Image Upload')</span>
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>

                        </div>


                        <div class="row g-md-4 gy-5 mt-5">
                            <div class="col-md-12">
                                <div class="dashboard-title">
                                    <h5>@lang('Gallery Images')</h5>
                                </div>
                                <div class="row">
                                    @forelse ($galleryList->shuffle() as $data)
                                        <div class="col-md-4">
                                            <div class="img-box">
                                                <img src="{{getFile(config('location.gallery.path').'thumb_'.@$data->image)}}" alt="@lang('gallery img')" class="img-fluid storyDetailImageSize"/>
                                                <div class="hover-content cursorDefault">
                                                    <div class="text-box">
                                                        <a href="{{getFile(config('location.gallery.path').@$data->image)}}" data-fancybox="gallery" class="mx-2 iconHoverBg">
                                                            <i class="fas fa-search-plus"></i>
                                                        </a>
                                                        <a href="javascript:void(0)"
                                                           class="iconHoverBg"
                                                           data-route="{{ route('user.gallery.delete',$data->id) }}"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#delete-modal"
                                                           id="deleteImage">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <h4 class="py-5 text-center">@lang('No Gallery Image Available!')</h4>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Delete Modal -->
    <div id="delete-modal" class="modal fade modal-with-form" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content form-block">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Delete Gallery Image Confirmation')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are Your Sure To Delete This Image?')</p>
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


    <!-- Goto Purchase Plan Modal -->
    <div id="gotoPlanModal" class="modal fade modal-with-form" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content form-block">
                <div class="modal-body">
                    <div class="form-group">
                        <h4 class="text-green text-center py-3">@lang('Please Upgrade Your Package')</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-flower2 btn1" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{route('plan')}}">
                        <button type="submit" class="btn-flower2 btn2 planPurchaseButton">@lang('Purchase Package')</button>
                    </a>
                </div>
            </div>

        </div>
    </div>


@endsection


@push('script')
    <script>
        "use strict";
        $(document).on('click', '#image-label', function () {
            $('#image').trigger('click');
        });

        $(document).on('change', '#image', function () {
            var _this = $(this);
            var newimage = new FileReader();
            newimage.readAsDataURL(this.files[0]);
            newimage.onload = function (e) {
                $('#image_preview_container').attr('src', e.target.result);
            }
        });

        $(document).on('click', '#deleteImage', function () {
            var route = $(this).data('route');
            $('.deleteRoute').attr('action', route)
        });

    </script>
@endpush

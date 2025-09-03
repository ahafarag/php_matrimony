<div class="row happy-stories bg-white p-0">
    @forelse ($galleryList->shuffle() as $data)
        <div class="col-md-4">
            <div class="img-box">
                <img src="{{getFile(config('location.gallery.path').'thumb_'.@$data->image)}}" alt="@lang('gallery img')" class="img-fluid" />
                <div class="hover-content cursorDefault">
                    <div class="text-box">
                        <a href="{{getFile(config('location.gallery.path').@$data->image)}}" data-fancybox="gallery" class="mx-2 iconHoverBg">
                            <i class="fas fa-search-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <h4 class="py-5 text-center">@lang('No Gallery Image Available!')</h4>
    @endforelse
</div>

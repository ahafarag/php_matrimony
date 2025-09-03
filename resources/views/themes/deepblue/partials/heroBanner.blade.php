@if(isset($templates['hero'][0]) && $hero = $templates['hero'][0])
    @push('style')
        <style>
            .home-section {
                height: 100vh;
                background: url({{getFile(config('location.content.path').@$hero->templateMedia()->left_image)}});
                background-repeat: no-repeat;
                background-position: top left;
            }
            .home-section .overlay {
                background: url({{getFile(config('location.content.path').@$hero->templateMedia()->right_image)}});
                background-repeat: no-repeat;
                background-position: bottom right;
            }
        </style>
    @endpush

    <section class="home-section">
         <div class="overlay h-100">
            <div class="container h-100">
               <div class="row h-100 align-items-center justify-content-around">
                  <div class="col d-flex justify-content-center">
                     <div class="text-box w-75">
                        <h1>@lang(@$hero->description->title)</h1>
                        <p>@lang(@$hero->description->sub_title)</p>
                        <a href="{{@$hero->templateMedia()->button_link}}">
                            <button class="btn-flower">
                            @lang(@$hero['description']->button_name)
                        </button></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
@endif

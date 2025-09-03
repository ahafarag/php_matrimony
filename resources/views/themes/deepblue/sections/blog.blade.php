<!-- BLOG -->
@if(isset($templates['blog'][0]) && $blog = $templates['blog'][0])
    <section class="blog-section">
        <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text">
                    <h2>@lang(@$blog->description->title)</h2>
                    <p>@lang(@$blog->description->sub_title)</p>
                </div>
            </div>
        </div>
        <div class="row gy-5 g-md-5">
            @foreach($blogs->take(3)->sortDesc()->shuffle() as $blog)
                <div class="col-lg-4 col-md-6">
                    <div class="box">
                        <div class="img-box">
                            <img
                                class="img-fluid"
                                src="{{getFile(config('location.blog.path').'thumb_'.$blog->image)}}"
                                alt="@lang('blog image')"
                            />
                        </div>
                        <div class="text-box">
                            <h4>@lang(\Illuminate\Support\Str::limit(optional($blog->details)->title,28))</h4>
                            <p>@lang(\Illuminate\Support\Str::limit(optional($blog->details)->details,100))</p>
                            <a href="{{route('blogDetails',[slug(optional($blog->details)->title), $blog->id])}}" class="read-more">@lang('Read more...')</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        </div>
    </section>
@endif

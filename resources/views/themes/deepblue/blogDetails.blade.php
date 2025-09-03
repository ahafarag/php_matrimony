@extends($theme.'layouts.app')
@section('title',trans($title))

@section('content')

    <!-- BLOG Details -->
    <section class="blog-details">
        <div class="container">
           <div class="row gy-5 g-lg-5">
              <div class="col-lg-8">
                 <div class="blog-box">
                    <div class="img-box">
                       <img
                          class="img-fluid"
                          src="{{getFile(config('location.blog.path').$singleBlog->image)}}"
                          alt="@lang('blog img')"
                       />
                    </div>
                    <div class="text-box">
                       <div class="date-author d-flex justify-content-between">
                          <span>@lang('Posted by') @lang(optional($singleBlog->details)->author) @lang('on') {{dateTime($singleBlog->created_at,'d M, Y')}} </span>
                          <span class="badge bg-info">@lang($thisCategory->name)</span>
                       </div>
                       <h4>@lang(optional($singleBlog->details)->title)</h4>
                       <p>{!! trans(optional($singleBlog->details)->details) !!}</p>
                    </div>
                 </div>
              </div>

              <div class="col-lg-4">
                <div class="side-box">
                   <form action="{{ route('blogSearch') }}" method="get">
                       @csrf
                      <h4>@lang('Search')</h4>
                      <div class="input-group">
                         <input type="text" class="form-control" name="search" id="search" placeholder="@lang('search')"
                         />
                         <button type="submit"><i class="fal fa-search"></i></button>
                      </div>
                   </form>
                </div>

                <div class="side-box">
                   <h4>@lang('categories')</h4>
                   <ul class="links">
                       @foreach ($blogCategory as $category)
                       <li>
                           <a href="{{ route('CategoryWiseBlog', [slug(optional(@$category->details)->name), $category->id]) }}">@lang(optional(@$category->details)->name) ({{$category->blog_count}})</a>
                       </li>
                      @endforeach
                   </ul>
                </div>

             </div>
           </div>
        </div>
    </section>

     <!-- blog related post section -->
     @if (count($relatedBlogs) > 0)
        <section class="blog-section related-posts">
            <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-text mb-0">
                        <h2>@lang('Related Posts')</h2>
                    </div>
                </div>
            </div>
            <div class="row gy-5 g-md-5">
                @foreach ($relatedBlogs->take(3)->sortDesc()->shuffle() as $blog)
                    <div class="col-lg-4 col-md-6">
                        <div class="box">
                            <div class="img-box">
                            <img
                                class="img-fluid"
                                src="{{ getFile(config('location.blog.path'). @$blog->image) }}"
                                alt="@lang('related blog img')"
                            />
                            </div>
                            <div class="text-box">
                            <h4>@lang(\Illuminate\Support\Str::limit(optional($blog->details)->title,27))</h4>
                            <p>@lang(\Illuminate\Support\Str::limit(optional($blog->details)->details,100))</p>
                            <a href="{{route('blogDetails',[slug(@$blog->details->title), $blog->id])}}" class="read-more">@lang('Read more...')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            </div>
        </section>
     @endif
    <!-- /BLOG Details -->
@endsection

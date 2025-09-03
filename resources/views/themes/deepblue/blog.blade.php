@extends($theme.'layouts.app')
@section('title', trans($title))

@section('content')
    <!-- BLOG -->
    @if (count($allBlogs) > 0)
    <section class="blog-details">
        <div class="container">
           <div class="row gy-5 g-lg-5">
              <div class="col-lg-8">
                @forelse ($allBlogs as $blog)
                 <div class="blog-box mb-5">
                    <div class="img-box">
                       <img
                          class="img-fluid"
                          src="{{getFile(config('location.blog.path').$blog->image)}}"
                          alt="@lang('blog img')"
                       />
                    </div>
                    <div class="text-box">
                       <div class="date-author d-flex justify-content-between">
                          <span>@lang('Posted by') @lang(optional($blog->details)->author) @lang('on') {{dateTime($blog->created_at,'d M, Y')}} </span>
                          <span class="badge bg-info">@lang(optional(optional($blog->category)->details)->name)</span>
                       </div>
                       <h4>@lang(\Illuminate\Support\Str::limit(optional($blog->details)->title,58))</h4>
                       <p>@lang(\Illuminate\Support\Str::limit(optional($blog->details)->details,200))</p>
                        <a href="{{route('blogDetails',[slug(@$blog->details->title), $blog->id])}}">
                            <button class="btn-flower">
                                @lang('Read more...')
                            </button>
                        </a>
                    </div>
                 </div>
                @empty

                @endforelse

                <div class="row py-5 mt-5">
                    {{ $allBlogs->links() }}
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
    @else
        <div class="d-flex flex-column justify-content-center py-5">
            <h3 class="text-center mt-5 mb-5">@lang('No Post Available.')</h3>
            <a href="{{ route('blog') }}" class="text-center">
                <button class="btn-flower">
                    @lang('Back')
                </button>
            </a>
        </div>
    @endif

    <!-- /BLOG -->

@endsection

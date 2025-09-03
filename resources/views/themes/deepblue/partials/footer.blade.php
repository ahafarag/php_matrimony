<!-- FOOTER -->
<footer class="footer-section">
    <div class="container">
       <div class="row gy-5 g-md-5">
            <div class="col-lg-3 col-md-6">
                <div class="box box1">
                    <a class="navbar-brand" href="{{route('home')}}">
                        <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" alt="{{config('basic.site_title')}}">
                    </a>
                    @if(isset($contactUs['contact-us'][0]) && $contact = $contactUs['contact-us'][0])
                        <p>@lang(@$contact->description->address)</p>
                        <p>@lang('Email: ')@lang(@$contact->description->email_one)</p>
                        <p>@lang('Phone: ')@lang(@$contact->description->phone_one)</p>
                    @endif
                    @if(isset($contentDetails['social']))
                        <div class="social-links">
                            @foreach($contentDetails['social'] as $data)
                                <a href="{{@$data->content->contentMedia->description->link}}">
                                    <i class="{{@$data->content->contentMedia->description->icon}}"></i>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="box">
                    <h5>@lang('useful links')</h5>
                    <ul class="links">
                    <li><a href="{{route('home')}}">@lang('Home')</a></li>
                    <li><a href="{{route('about')}}">@lang('About')</a></li>
                    <li><a href="{{route('plan')}}">@lang('Package')</a></li>
                    <li><a href="{{route('blog')}}">@lang('Blog')</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="box">
                    <h5>@lang('quick search')</h5>
                    <ul class="links">
                        <li><a href="{{route('faq')}}">@lang('faq')</a></li>
                        <li><a href="{{route('contact')}}">@lang('contact')</a></li>
                        @isset($contentDetails['support'])
                            @foreach($contentDetails['support'] as $data)
                                <li><a href="{{route('getLink', [slug($data->description->title), $data->content_id])}}">@lang($data->description->title)</a></li>
                            @endforeach
                        @endisset
                    </ul>
                </div>
            </div>

            @if(isset($newsLetter['news-letter'][0]) && $newsLetter = $newsLetter['news-letter'][0])
                <div class="col-lg-3 col-md-6">
                    <div class="box">
                        <h5>@lang(@$newsLetter->description->title)</h5>
                        <p>@lang(@$newsLetter->description->sub_title)</p>
                        <form class="subscribe-form" action="{{route('subscribe')}}" method="post">
                            @csrf
                            <div class="input-group">
                                <input
                                    name="email" type="email" value="{{ old('email') }}" placeholder="@lang('Enter email')"
                                    class="form-control"
                                />
                                <button type="submit"><i class="fal fa-paper-plane"></i></button>
                            </div>
                            @error('email')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </form>
                    </div>
                </div>
            @endif
       </div>

       <div class="footer-bottom">
          <div class="row">
             <div class="col-md-6">
                <p class="copyright">
                    @lang('Copyright') &copy; {{date('Y')}} <a href="{{route('home')}}">@lang($basic->site_title)</a> @lang('All Rights Reserved.')
                </p>
             </div>

             <div class="col-md-6 language">
                @foreach($languages as $language)
                    <a href="{{route('language',[$language->short_name])}}">
                        <span class="flag-icon flag-icon-{{strtolower($language->short_name)}}"></span> {{$language->name}}</a>
                @endforeach
             </div>
          </div>
       </div>
    </div>
    <span></span>
    @if(isset($footerImage['footer'][0]) && $footer = $footerImage['footer'][0])
        <img
        src="{{getFile(config('location.content.path').@$footer->templateMedia()->left_image)}}"
        alt="@lang('Footer image')"
        class="flower"
        {{-- data-aos="zoom-in"
        data-aos-duration="800"
        data-aos-anchor-placement="center-bottom" --}}
        />
    @endif

</footer>

<!-- /FOOTER -->



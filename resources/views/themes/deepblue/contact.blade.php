@extends($theme.'layouts.app')
@section('title',trans($title))

@section('content')
    <!-- contact info -->
    <section class="contact-info">
        <div class="container">
            <div class="row g-3 g-md-5">
                <div class="col-lg-4 col-md-6">
                    <div class="box">
                    <div class="icon-box">
                        <i class="fal fa-map-marker-alt"></i>
                    </div>
                    <div class="text-box">
                        <h4>@lang('Address')</h4>
                        <p>@lang(@$contact->description->address)</p>
                    </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="box">
                    <div class="icon-box">
                        <i class="fal fa-envelope"></i>
                    </div>
                    <div class="text-box">
                        <h4>@lang('Email us')</h4>
                        <p>@lang(@$contact->description->email_one) <br />@lang(@$contact->description->email_two)</p>
                    </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mx-auto">
                    <div class="box">
                    <div class="icon-box">
                        <i class="fal fa-phone-alt"></i>
                    </div>
                    <div class="text-box">
                        <h4>@lang('Call Now')</h4>
                        <p>
                            @lang(@$contact->description->phone_one)<br />
                            @lang(@$contact->description->phone_two)
                        </p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- contact form -->
    <section class="contact-form">
        <div class="container">
            <div
                class="row align-items-center justify-content-between gy-5 g-lg-5"
            >
                <div class="col-lg-6">
                    <div class="text-box">
                    <h2>@lang('get in touch')</h2>
                    <img src="{{getFile(config('location.content.path').@$contact->templateMedia()->image)}}" alt="@lang('contact image')" class="img-fluid" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <form action="{{route('contact.send')}}" method="POST">
                        @csrf
                        <div class="row g-3 g-md-4">
                            <div class="col-12">
                                <input
                                    type="text"
                                    name="name" value="{{old('name')}}"
                                    class="form-control"
                                    placeholder="@lang('Your name')"
                                />
                                @error('name')
                                    <span class="text-danger">@lang($message)</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <input
                                    type="email"
                                    name="email" value="{{old('email')}}"
                                    class="form-control"
                                    placeholder="@lang('Email Address')"
                                />
                                @error('email')
                                    <span class="text-danger">@lang($message)</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <input
                                    type="text" name="subject"
                                    value="{{old('subject')}}" placeholder="@lang('Subject')"
                                    class="form-control"
                                />
                                @error('subject')
                                    <span class="text-danger">@lang($message)</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <textarea
                                    class="form-control"
                                    cols="30"
                                    rows="10"
                                    name="message" placeholder="@lang('Message')"
                                >{{old('message')}}</textarea>

                                @error('message')
                                    <span class="text-danger">@lang($message)</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn-flower">@lang('submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

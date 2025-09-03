<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en" @if(session()->get('rtl') == 1) dir="rtl" @endif >

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @include('partials.seo')

    <link rel="stylesheet" href="{{asset($themeTrue.'assets/bootstrap/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset($themeTrue.'assets/plugins/owlcarousel/animate.css')}}" />
    <link rel="stylesheet" href="{{asset($themeTrue.'assets/plugins/owlcarousel/owl.carousel.min.css')}}" />
    <link rel="stylesheet" href="{{asset($themeTrue.'assets/plugins/owlcarousel/owl.theme.default.min.css')}}" />
    <link rel="stylesheet" href="{{asset($themeTrue.'assets/plugins/aos/aos.css')}}" />
    <link rel="stylesheet" href="{{asset($themeTrue.'assets/plugins/fancybox/jquery.fancybox.min.css')}}" />
    <link rel="stylesheet" href="{{asset($themeTrue.'css/flag-icon.min.css')}}" />
    <script src="{{asset($themeTrue.'assets/fontawesome/fontawesomepro.js')}}"></script>

    @stack('css-lib')

    <link rel="stylesheet" href="{{asset($themeTrue.'css/style.css')}}" />

    @stack('style')

</head>


<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid" id="pushNotificationArea">
            <a class="navbar-brand" href="{{route('home')}}">
                <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" alt="{{config('basic.site_title')}}">
            </a>
            <button class="navbar-toggler p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fal fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('home')}}">@lang('Home')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('about')}}">@lang('About')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('story')}}">@lang('Story')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('plan')}}">@lang('Package')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('members')}}">@lang('Members')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('blog')}}">@lang('Blog')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('contact')}}">@lang('Contact')</a>
                    </li>
                </ul>
            </div>
            <span class="navbar-text">
                @guest
                    <div class="notification-panel pe-3">
                        <button class="dropdown-toggle">
                            <i class="fal fa-user-circle"></i>
                        </button>
                        <ul class="notification-dropdown userprofile">
                            <div class="dropdown-box">
                                <li>
                                    <a class="dropdown-item align-items-center px-3" href="{{route('login')}}">
                                        <i class="far fa-sign-in"></i>
                                        <p>@lang('Login')</p>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item align-items-center px-3" href="{{route('register')}}">
                                        <i class="far fa-user-plus"></i>
                                        <p>@lang('Register')</p>
                                    </a>
                                </li>
                            </div>
                        </ul>
                    </div>
                @else
                    <div class="notification-panel pe-3">
                        <button class="dropdown-toggle">
                            <i class="fal fa-user-circle"></i>
                        </button>
                        <ul class="notification-dropdown userprofile">
                            <div class="dropdown-box">
                                <li>
                                    <a class="dropdown-item align-items-center px-3" href="{{route('user.home')}}">
                                        <i class="far fa-tachometer-alt-fast"></i>
                                        <p>@lang('Dashboard')</p>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item align-items-center px-3" href="{{route('user.profile')}}">
                                        <i class="far fa-user-cog"></i>
                                        <p>@lang('My Profile')</p>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item align-items-center px-3" href="{{route('user.twostep.security')}}">
                                        <i class="fas fa-user-lock"></i>
                                        <p>@lang('2FA Security')</p>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item align-items-center px-3" href="{{route('logout')}}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="far fa-power-off"></i>
                                        <p>@lang('Logout')</p>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </div>
                        </ul>
                    </div>
                @endguest

                <!-- notification panel -->
                @auth
                    @include($theme.'partials.pushNotify')
                @endauth

                @if(!request()->routeIs('members') && !request()->routeIs('user.search.member'))
                    <button data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fal fa-search"></i>
                    </button>
                @endif
                
            </span>
        </div>
    </nav>


    <!-- search modal -->
    <div class="modal fade search-modal" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <form action="{{ route('user.search.member') }}" method="GET">
                        <div class="row g-4">
                            <div class="col-lg-2">
                                <input type="number" name="age_from" id="age_from" value="{{old('age_from',request()->age_from)}}" class="form-control" min="1" step="1" placeholder="@lang('age from')"/>
                                @error('age_from')
                                <span class="text-danger">@lang($message)</span>
                                @enderror
                            </div>
                            <div class="col-lg-2">
                                <input type="number" name="age_to" id="age_to" value="{{old('age_to',request()->age_to)}}" class="form-control" min="1" step="1" placeholder="@lang('age to')"/>
                                @error('age_to')
                                <span class="text-danger">@lang($message)</span>
                                @enderror
                            </div>
                            @php
                                $religion = \App\Models\Religion::latest()->get();
                                $maritalStatus = \App\Models\MaritalStatusDetails::latest()->get();
                            @endphp
                            <div class="col-lg-2">
                                <select name="religion" class="form-select" aria-label="religion">
                                    <option value="" selected>@lang('Select Religion')</option>
                                    @foreach ($religion as $data)
                                        <option value="{{$data->id}}" {{old('religion',request()->religion) == $data->id ? 'selected' : ''}}>{{$data->name}}</option>
                                    @endforeach
                                </select>
                                @error('religion')
                                <span class="text-danger">@lang($message)</span>
                                @enderror
                            </div>
                            <div class="col-lg-2">
                                <select name="marital_status" id="marital_status" class="form-select" aria-label="Maritial status">
                                    <option value="" selected>@lang('Maritial Status')</option>
                                    @foreach($maritalStatus as $data)
                                        <option value="{{$data->marital_status_id}}" {{ old('marital_status', request()->marital_status) == $data->marital_status_id ? 'selected' : ''  }}>@lang($data->name)</option>
                                    @endforeach
                                </select>
                                @error('marital_status')
                                <span class="text-danger">@lang($message)</span>
                                @enderror
                            </div>
                            <div class="col-lg-2">
                                <select class="form-select" name="gender" id="gender" aria-label="gender">
                                    <option value="" selected>@lang('Select Gender')</option>
                                    <option value="Male" {{ old('gender', request()->gender) == 'Male' ? 'selected' : ''}}>@lang('Male')</option>
                                    <option value="Female" {{ old('gender', request()->gender) == 'Female' ? 'selected' : ''}}>@lang('Female')</option>
                                </select>
                                @error('gender')
                                <span class="text-danger">@lang($message)</span>
                                @enderror
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn-flower">@lang('Search')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- pre loader -->
    <div id="preloader">
        <img src="{{asset($themeTrue.'images/love.gif')}}" alt="@lang('loader')" class="loader" />
    </div>

    <!-- arrow up -->
    <a href="#" class="scroll-up">
        <i class="fal fa-chevron-double-up"></i>
    </a>



    @include($theme.'partials.banner')

    @yield('content')

    @include($theme.'partials.footer')


    @stack('extra-content')



    <script src="{{asset($themeTrue.'assets/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset($themeTrue.'assets/bootstrap/masonry.pkgd.min.js')}}"></script>
    <script src="{{asset($themeTrue.'assets/jquery/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset($themeTrue.'assets/plugins/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset($themeTrue.'assets/plugins/counterup/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset($themeTrue.'assets/plugins/counterup/jquery.counterup.min.js')}}"></script>
    <script src="{{asset($themeTrue.'assets/plugins/aos/aos.js')}}"></script>
    <script src="{{asset($themeTrue.'assets/plugins/fancybox/jquery.fancybox.min.js')}}"></script>

    @stack('extra-js')
    <script src="{{asset('assets/global/js/notiflix-aio-2.7.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/pusher.min.js')}}"></script>
    <script src="{{asset('assets/global/js/vue.min.js')}}"></script>
    <script src="{{asset('assets/global/js/axios.min.js')}}"></script>

    <script src="{{asset($themeTrue.'js/script.js')}}"></script>



    @auth
    <script>
        'use strict';
        let pushNotificationArea = new Vue({
            el: "#pushNotificationArea",
            data: {
                items: [],
            },
            mounted() {
                this.getNotifications();
                this.pushNewItem();
            },
            methods: {
                getNotifications() {
                    let app = this;
                    axios.get("{{ route('user.push.notification.show') }}")
                        .then(function (res) {
                            app.items = res.data;
                        })
                },
                readAt(id, link) {
                    let app = this;
                    let url = "{{ route('user.push.notification.readAt', 0) }}";
                    url = url.replace(/.$/, id);
                    axios.get(url)
                        .then(function (res) {
                            if (res.status) {
                                app.getNotifications();
                                if (link != '#') {
                                    window.location.href = link
                                }
                            }
                        })
                },
                readAll() {
                    let app = this;
                    let url = "{{ route('user.push.notification.readAll') }}";
                    axios.get(url)
                        .then(function (res) {
                            if (res.status) {
                                app.items = [];
                            }
                        })
                },
                pushNewItem() {
                    let app = this;
                    // Pusher.logToConsole = true;
                    let pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                        encrypted: true,
                        cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
                    });
                    let channel = pusher.subscribe('user-notification.' + "{{ Auth::id() }}");
                    channel.bind('App\\Events\\UserNotification', function (data) {
                        app.items.unshift(data.message);
                    });
                    channel.bind('App\\Events\\UpdateUserNotification', function (data) {
                        app.getNotifications();
                    });
                }
            }
        });
    </script>
    @endauth

    @stack('script')


    @include($theme.'partials.notification')

    @include('plugins')

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

    <script>
        $(document).ready(function () {
            $(".language").find("select").change(function () {
                window.location.href = "{{route('language')}}/" + $(this).val()
            })
        })
    </script>

</body>

</html>

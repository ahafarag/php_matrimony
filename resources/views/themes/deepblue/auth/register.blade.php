@extends($theme.'layouts.app')
@section('title',trans('Register'))

@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="row g-3 g-md-4">

                            <div class="col-md-6 form-group">
                                <input class="form-control" type="text" name="firstname" value="{{old('firstname')}}" placeholder="@lang('First Name')">
                                @error('firstname')
                                <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <input class="form-control" type="text" name="lastname" value="{{old('lastname')}}"  placeholder="@lang('Last Name')">
                                @error('lastname')
                                <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <input class="form-control" type="text" name="username" value="{{old('username')}}"  placeholder="@lang('Username')">
                                @error('username')
                                <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <input class="form-control" type="text" name="email" value="{{old('email')}}"  placeholder="@lang('Email Address')">
                                @error('email')
                                <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group">
                                    @php
                                        $country_code = (string) @getIpInfo()['code'] ?: null;
                                        $myCollection = collect(config('country'))->map(function($row) {
                                            return collect($row);
                                        });
                                        $countries = $myCollection->sortBy('code');
                                    @endphp

                                    <div class="input-group">
                                        <div class="input-group-prepend w-50">
                                            <select name="phone_code" class="form-control country_code dialCode-change">
                                                @foreach(config('country') as $value)
                                                    <option value="{{$value['phone_code']}}"
                                                            data-name="{{$value['name']}}"
                                                            data-code="{{$value['code']}}"
                                                        {{$country_code == $value['code'] ? 'selected' : ''}}
                                                    > {{$value['name']}} ({{$value['phone_code']}})

                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="text" name="phone" class="form-control dialcode-set"
                                            value="{{old('phone')}}"
                                            placeholder="@lang('Your Phone Number')">
                                    </div>


                                    @error('phone')
                                        <span class="text-danger mt-1">@lang($message)</span>
                                    @enderror

                                    <input type="hidden" name="country_code" value="{{old('country_code')}}" class="text-dark">
                            </div>


                            <div class="col-md-6 form-group">
                                <input class="form-control" type="password" name="password" placeholder="@lang('Password')">
                                @error('password')
                                    <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <input class="form-control" type="password" name="password_confirmation" placeholder="@lang('Confirm Password')">
                            </div>


                            @if(basicControl()->reCaptcha_status_registration)
                                <div class="col-md-12 form-group">
                                    {!! NoCaptcha::renderJs(session()->get('trans')) !!}
                                    {!! NoCaptcha::display() !!}
                                    @error('g-recaptcha-response')
                                        <span class="text-danger mt-1">@lang($message)</span>
                                    @enderror
                                </div>
                            @endif


                            <div class="col-12">
                                <div class="links">
                                    <div class="form-check">
                                       <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"/>
                                       <label class="form-check-label" for="flexCheckDefault">
                                          @lang('By signing up you agree to our ')
                                          <a href="">@lang('T&C.')</a>
                                       </label>
                                    </div>
                                 </div>
                            </div>

                        </div>

                        <button class="btn-flower">@lang('sign up')</button>

                        <div class="bottom">@lang('Already have an account?')<br />
                            <a href="{{ route('login') }}">@lang('Sign In')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        "use strict";
        $(document).ready(function () {
            setDialCode();
            $(document).on('change', '.dialCode-change', function () {
                setDialCode();
            });
            function setDialCode() {
                let currency = $('.dialCode-change').val();
                $('.dialcode-set').val(currency);
            }
        });

    </script>
@endpush

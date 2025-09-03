@extends($theme.'layouts.app')
@section('title',trans('Reset Password'))

@section('content')

    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="{{route('password.update')}}" method="post">
                        @csrf

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                {{ trans(session('status')) }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @error('token')
                            <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                {{ trans($message) }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @enderror


                        <div class="row g-3 g-md-4">

                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">

                            <div class="col-12">
                                <input class="form-control" type="password" name="password" placeholder="@lang('New Password')">
                                @error('password')
                                    <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <input class="form-control" type="password" name="password_confirmation" placeholder="@lang('Confirm Password')">
                            </div>
                        </div>

                        <button type="submit" class="btn-flower mt-4">@lang('Submit')</button>

                        <div class="bottom">@lang("Don't have an account?") <br />
                            <a href="{{ route('register') }}">@lang('Create account')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

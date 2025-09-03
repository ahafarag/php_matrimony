@extends($theme.'layouts.app')
@section('title',trans('Forget Password'))


@section('content')
    <!-- Forget Password section -->
    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="{{ route('password.email') }}" method="post">
                        @csrf
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                {{ trans(session('status')) }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row g-3 g-md-4">
                            <div class="col-12">
                                <input class="form-control" type="email" name="email" value="{{old('email')}}" placeholder="@lang('Enter your email address to reset your password')">

                                @error('email')
                                    <span class="text-danger mt-1">{{ trans($message) }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn-flower mt-4">@lang('Send Password Reset Link')</button>

                        <div class="bottom">@lang("Don't have any account? Sign Up") <br />
                            <a href="{{ route('register') }}">@lang('Create account')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection


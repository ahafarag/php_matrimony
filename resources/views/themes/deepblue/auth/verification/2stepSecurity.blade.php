@extends($theme.'layouts.app')
@section('title',$page_title)

@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="{{route('user.twoFA-Verify')}}" method="post">
                        @csrf
                        <div class="row g-3 g-md-4">
                            <div class="col-12">
                                <input class="form-control" type="text" name="code" value="{{old('code')}}" placeholder="@lang('Code')" autocomplete="off">

                                @error('code')
                                    <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                                @error('error')
                                    <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn-flower mt-4">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

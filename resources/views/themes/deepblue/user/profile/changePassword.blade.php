@extends($theme.'layouts.user')
@section('title',trans('Change Password'))

@section('content')

    <section class="dashboard-section">
        <div class="container">
            <div class="row gy-5 g-lg-4">
                @include($theme.'user.sidebar')

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="dashboard-title">
                                    <h5>@lang('Change Password')</h5>
                                </div>

                                <form method="post" action="{{ route('user.updatePassword') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3 g-md-4 generate-btn-parent">
                                        <div class="col-md-12 form-group">
                                            <label for="current_password">@lang('Current Password')</label>
                                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="@lang('Enter Current Password')" autocomplete="off"/>
                                            @if($errors->has('current_password'))
                                                <div class="error text-danger">@lang($errors->first('current_password')) </div>
                                            @endif
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label for="password">@lang('New Password')</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="@lang('Enter New Password')" autocomplete="off"/>
                                            @if($errors->has('password'))
                                                <div class="error text-danger">@lang($errors->first('password')) </div>
                                            @endif
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label for="password_confirmation">@lang('Confirm Password')</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="@lang('Enter Confirm Password')" autocomplete="off"/>
                                            @if($errors->has('password_confirmation'))
                                                <div class="error text-danger">@lang($errors->first('password_confirmation')) </div>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="col-12 text-end mt-3">
                                        <button type="submit" class="btn-flower2 w-100">@lang('Update Password')</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

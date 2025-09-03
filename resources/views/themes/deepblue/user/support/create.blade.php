@extends($theme.'layouts.user')
@section('title',__($page_title))

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
                                    <h5>@lang('Create Ticket')</h5>
                                    <a href="{{ url()->previous() }}" class="add-new btn-flower2 text-center">@lang('Back')</a>
                                </div>

                                <form method="post" action="{{route('user.ticket.store')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3 g-md-4 generate-btn-parent">
                                        <div class="col-md-12 form-group">
                                            <label for="subject">@lang('Subject')</label>
                                            <input type="text" name="subject" id="subject" value="{{old('subject')}}" class="form-control" placeholder="@lang('Enter Subject')"/>
                                            @error('subject')
                                                <div class="text-danger">@lang($message) </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label for="message">@lang('Message')</label>
                                            <textarea class="form-control ticket-box" name="message" rows="5" id="message" placeholder="@lang('Enter Message')">{{old('message')}}</textarea>
                                            @error('message')
                                                <div class="text-danger">@lang($message) </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label for="formFile">@lang('Upload File')</label>
                                            <input class="form-control" type="file" name="attachments[]" id="formFile" multiple>
                                            @error('attachments')
                                                <span class="text-danger">{{trans($message)}}</span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-12 text-end mt-3">
                                        <button type="submit" class="btn-flower2 w-100">@lang('Submit')</button>
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

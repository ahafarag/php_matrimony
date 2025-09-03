@extends('admin.layouts.app')

@section('title')
    @lang('Create Caste')
@endsection

@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 justify-content-end">
                <a href="{{route('admin.casteList')}}" class="btn btn-sm  btn-primary mr-2">
                    <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                </a>
            </div>

            <div class="mt-2">
                <form method="post" action="{{ route('admin.casteStore') }}" class="mt-4">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-4">
                            <label for="religion_id"> @lang('Select Religion') </label>
                            <select name="religion_id" class="form-control @error('religion_id') is-invalid @enderror">
                                <option value="" disabled selected>@lang('Select One')</option>
                                @foreach ($religionList as $item)
                                    <option value="{{ $item->id }}">@lang($item->name)</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback mt-3">
                                @error('religion_id') @lang($message) @enderror
                            </div>
                            <div class="valid-feedback"></div>
                        </div>

                        <div class="col-sm-12 col-md-12 mb-3">
                            <label for="name"> @lang('Caste Name') </label>
                            <input type="text" name="name"
                                   class="form-control  @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}">
                            <div class="invalid-feedback">
                                @error('name') @lang($message) @enderror
                            </div>
                            <div class="valid-feedback"></div>
                        </div>
                    </div>

                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save')</button>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        "use strict";
        $(document).ready(function (e) {
            $('select').select2({
                selectOnClose: true
            });
        });
    </script>

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
@endpush

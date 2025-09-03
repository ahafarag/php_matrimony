@extends('admin.layouts.app')

@section('title')
    @lang('Edit Country')
@endsection

@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 justify-content-end">
                <a href="{{route('admin.countryList')}}" class="btn btn-sm  btn-primary mr-2">
                    <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                </a>
            </div>


            <div class="mt-2">
                <form method="post" action="{{ route('admin.countryUpdate',[$id]) }}" class="mt-4" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <label for="name"> @lang('Country Name') </label>
                            <input type="text" name="name"
                                   class="form-control  @error('name') is-invalid @enderror"
                                   value="<?php echo old('name', isset($countryList) ? @$countryList[0]->name : '') ?>">
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

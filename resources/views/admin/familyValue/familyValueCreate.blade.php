@extends('admin.layouts.app')

@section('title')
    @lang('Create Family Value')
@endsection

@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 justify-content-end">
                <a href="{{route('admin.familyValueList')}}" class="btn btn-sm  btn-primary mr-2">
                    <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                </a>
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @foreach($languages as $key => $language)
                    <li class="nav-item">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#lang-tab-{{ $key }}" role="tab" aria-controls="lang-tab-{{ $key }}"
                           aria-selected="{{ $loop->first ? 'true' : 'false' }}">@lang($language->name)</a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content mt-2" id="myTabContent">
                @foreach($languages as $key => $language)

                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-tab-{{ $key }}" role="tabpanel">
                        <form method="post" action="{{ route('admin.familyValueStore', $language->id) }}" class="mt-4" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-3">
                                    <label for="name"> @lang('Name') </label>
                                    <input type="text" name="name[{{ $language->id }}]"
                                            class="form-control  @error('name'.'.'.$language->id) is-invalid @enderror"
                                            value="{{ old('name'.'.'.$language->id) }}">
                                    <div class="invalid-feedback">
                                        @error('name'.'.'.$language->id) @lang($message) @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>
                            </div>

                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save')</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote.min.css')}}">
@endpush
@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote.min.js')}}"></script>
@endpush


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

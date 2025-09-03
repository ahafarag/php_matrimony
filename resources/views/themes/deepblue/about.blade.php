@extends($theme.'layouts.app')
@section('title',trans('About Us'))

@section('content')
    @include($theme.'sections.about-us')
    @include($theme.'sections.plan')
    @include($theme.'sections.testimonial')
@endsection

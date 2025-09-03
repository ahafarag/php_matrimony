@extends($theme.'layouts.app')
@section('title',trans('Home'))

@section('content')
    @include($theme.'partials.heroBanner')
    @include($theme.'sections.feature')
    @include($theme.'sections.about-us')
    @include($theme.'sections.story')
    @include($theme.'sections.premium-member')
    @include($theme.'sections.plan')
    @include($theme.'sections.testimonial')
    @include($theme.'sections.counter')
    @include($theme.'sections.blog')
@endsection

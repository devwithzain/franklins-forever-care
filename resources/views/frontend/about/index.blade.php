@extends('layouts.frontend')

@section('title', $title ?? 'About')

@section('content')
   @include('frontend.about.hero')
   @include('frontend.about.about')
   @include('frontend.about.partners')
   @include('frontend.about.vission')
   @include('frontend.about.why')
   @include('frontend.about.marquee')
   @include('frontend.about.testimonials')
   @include('frontend.about.team')
@endsection
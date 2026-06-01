@extends('layouts.frontend')

@section('title', $title ?? 'Home')

@section('content')
   @include('frontend.home.hero')
   @include('frontend.home.how')
   @include('frontend.home.marquee')
   @include('frontend.home.services')
   @include('frontend.home.stats')
   @include('frontend.home.about')
   @include('frontend.home.partners')
   @include('frontend.home.why')
   @include('frontend.home.testimonials')
   @include('frontend.home.blogs')
   @include('frontend.home.newsletter')
   @include('frontend.home.faqs')
   @include('frontend.home.contact')
@endsection
@extends('layouts.frontend')

@section('title', $title ?? 'Terms & Conditions')

@section('content')
   @include('frontend.terms.hero')
   @include('frontend.terms.terms')
@endsection
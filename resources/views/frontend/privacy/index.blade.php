@extends('layouts.frontend')

@section('title', $title ?? 'Privacy Policy')

@section('content')
   @include('frontend.privacy.hero')
   @include('frontend.privacy.privacy')
@endsection
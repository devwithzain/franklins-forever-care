@extends('layouts.frontend')

@section('title', $title ?? 'Services')

@section('content')
   @include('frontend.services.hero')
   @include('frontend.services.services')
@endsection
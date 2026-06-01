@extends('layouts.frontend')

@section('title', $title ?? 'Services')

@section('content')
   @include('frontend.service-detail.hero')
   @include('frontend.service-detail.service-detail')
@endsection
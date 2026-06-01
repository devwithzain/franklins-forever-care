@extends('layouts.frontend')

@section('title', $title ?? 'Thank You')

@section('content')
   @include('frontend.thankyou.hero')
   @include('frontend.thankyou.success')
@endsection
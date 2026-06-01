@extends('layouts.frontend')

@section('title', $title ?? 'Career')

@section('content')
   @include('frontend.career.hero')
   @include('frontend.career.career')
@endsection
@extends('layouts.frontend')

@section('title', $title ?? 'Packages')

@section('content')
   @include('frontend.packages.hero')
   @include('frontend.packages.packages')
@endsection
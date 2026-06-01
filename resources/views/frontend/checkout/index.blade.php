@extends('layouts.frontend')

@section('title', $title ?? 'Checkout')

@section('content')
   @include('frontend.checkout.hero')
   @include('frontend.checkout.checkout')
@endsection
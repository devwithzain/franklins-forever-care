@extends('layouts.frontend')

@section('title', $title ?? 'Contact')

@section('content')
   @include('frontend.contact.hero')
   @include('frontend.contact.contact')
@endsection
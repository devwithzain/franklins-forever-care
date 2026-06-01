@extends('layouts.frontend')

@section('title', $title ?? 'Blogs')

@section('content')
   @include('frontend.blogs.hero')
   @include('frontend.blogs.blogs')
@endsection
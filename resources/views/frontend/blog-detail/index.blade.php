@extends('layouts.frontend')

@section('title', $title ?? 'Blogs')

@section('content')
   @include('frontend.blog-detail.hero')
   @include('frontend.blog-detail.blog-detail')
@endsection
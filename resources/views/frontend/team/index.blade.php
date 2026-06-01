@extends('layouts.frontend')

@section('title', "Our Team")

@section('content')
   @include('frontend.team.hero')
   @include('frontend.team.team-list', ['employees' => $employees])
@endsection

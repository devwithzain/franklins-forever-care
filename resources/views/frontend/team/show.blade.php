@extends('layouts.frontend')

@section('title', $employee->user->name . ' - Team Member')

@section('content')
   @include('frontend.team.show-hero', ['employee' => $employee])
   @include('frontend.team.show-detail', ['employee' => $employee])
@endsection

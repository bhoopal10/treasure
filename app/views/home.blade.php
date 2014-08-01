@extends('layout.main')
@section('content')
@if(Auth::check())
@include('layout.instruction')
@else
@include('layout.instruction')
@endif
@stop

@extends('layouts.box-app')

@section('box-title')
    {{ __('Dashboard') }}
@endsection

@section('box-content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <h2>{{ __('resources.resources') }}</h2>
    <ul>
        <li><a href="{{ url('/files') }}">{{ __('resources.files') }}</a></li>
        <li><a href="{{ url('/posts') }}">{{ __('resources.posts') }}</a></li>
        <li><a href="{{ url('/places') }}">{{ __('resources.places') }}</a></li>
    </ul>
@endsection

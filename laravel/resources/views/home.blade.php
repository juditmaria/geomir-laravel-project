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
    <h2>{{ __('Resources') }}</h2>
    <ul>
        <li><a href="{{ url('/files') }}">{{ __('Files') }}</a></li>
        <li><a href="{{ url('/posts') }}">{{ __('Posts') }}</a></li>
        <li><a href="{{ url('/places') }}">{{ __('Places') }}</a></li>
    </ul>
@endsection

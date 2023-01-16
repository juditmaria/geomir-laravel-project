@extends('layouts.box-app')

@section('box-title')
    {{ __('actions.add') . " " . __('resources.file') }}
@endsection

@section('box-content')
    <form id="create-file" method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="upload">{{ __('resources.file') }}:</label>
            <input type="file" class="form-control" name="upload"/>
        </div>
        <button id="submit" type="submit" class="btn btn-primary">{{ __('actions.create') }}</button>
        <button type="reset" class="btn btn-secondary">{{ __('actions.reset') }}</button>
    </form>
@endsection

@push('scripts')
    @vite('resources/js/files/create.js')
@endpush
@extends('layouts.box-app')

@section('box-title')
    {{ __('actions.edit') . " " . __('resources.file') . " " . $file->id }}
@endsection

@section('box-content')
    <img class="img-fluid" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview"/>
    <form method="POST" action="{{ route('files.update', $file) }}" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="form-group">
            <label for="upload">{{ __('resources.file') }}:</label>
            <input type="file" class="form-control" name="upload"/>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('actions.update') }}</button>
        <button type="reset" class="btn btn-secondary">{{ __('actions.reset') }}</button>
    </form>
@endsection
@extends('layouts.box-app')

@section('box-title')
    {{ __('actions.add') . " " . __('resources.place') }}
@endsection

@section('box-content')
    <form id="create-place" method="post" action="{{ route('places.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">{{ __('fields.name') }}</label>
            <input type="text" id="name" name="name" class="form-control" />
        </div>
        <div class="form-group">
            <label for="description">{{ __('fields.description') }}</label>
            <textarea id="description" name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="upload">{{ __('fields.file') }}</label>
            <input type="file" id="upload" name="upload" class="form-control" />
        </div>
        <div class="form-group">            
                <label for="latitude">{{ __('fields.latitude') }}</label>
                <input type="text" id="latitude" name="latitude" class="form-control"
                    value="41.2310371"/>
        </div>
        <div class="form-group">            
            <label for="longitude">{{ __('fields.longitude') }}</label>
            <input type="text" id="longitude" name="longitude" class="form-control"
                    value="1.7282036"/>
        </div>
        <div class="form-group">
            <label for="visibility">{{ __('fields.visibility') }}</label>
            <select id="visibility" name="visibility" class="form-control">
                @foreach(App\Models\Visibility::all() as $visibility)
                <option value="{{ $visibility->id }}">
                    {{ __($visibility->name) }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('actions.create') }}</button>
        <button type="reset" class="btn btn-secondary">{{ __('actions.reset') }}</button>
    </form>
@endsection

@push('scripts')
    @vite('resources/js/places/create.js')
@endpush
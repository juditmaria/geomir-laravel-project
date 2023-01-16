@extends('layouts.box-app')

@section('box-title')
    {{ __('actions.add') . " " . __('resources.post') }}
@endsection

@section('box-content')
    <form id="create-post" method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="body">{{ __('fields.body') }}</label>
            <textarea id="body" name="body" class="form-control"></textarea>
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
    @vite('resources/js/posts/create.js')
@endpush
@extends('layouts.box-app')

@section('box-title')
    {{ __('actions.edit') . " " . __('resources.post') . " " . $post->id }}
@endsection

@section('box-content')
    <img class="img-fluid" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview"/>
    <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="form-group">
            <label for="body">{{ __('fields.body') }}</label>
            <textarea id="body" name="body" class="form-control">{{ $post->body }}</textarea>
        </div>
        <div class="form-group">
            <label for="upload">{{ __('fields.file') }}</label>
            <input type="file" id="upload" name="upload" class="form-control" />
        </div>
        <div class="form-group">            
                <label for="latitude">{{ __('fields.latitude') }}</label>
                <input type="text" id="latitude" name="latitude" class="form-control"
                    value="{{ $post->latitude }}"/>
        </div>
        <div class="form-group">            
                <label for="longitude">{{ __('fields.longitude') }}</label>
                <input type="text" id="longitude" name="longitude" class="form-control"
                    value="{{ $post->longitude }}"/>
        </div>
        <div class="form-group">
            <label for="visibility">{{ __('fields.visibility') }}</label>
            <select id="visibility" name="visibility" class="form-control">
                @foreach(App\Models\Visibility::all() as $visibility)
                    @if($visibility->id == $post->visibility_id)
                        <option value="{{ $visibility->id }}" selected>
                            {{ __($visibility->name) }}
                        </option>
                    @else
                        <option value="{{ $visibility->id }}">
                            {{ __($visibility->name) }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('actions.update') }}</button>
        <button type="reset" class="btn btn-secondary">{{ __('actions.reset') }}</button>
    </form>
@endsection
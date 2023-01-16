@extends('layouts.box-app')

@section('box-title')
    {{ __('resources.places') }}
@endsection

@section('box-content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td scope="col">{{ __('fields.id') }}</td>
                    <td scope="col">{{ __('fields.name') }}</td>
                    <td scope="col">{{ __('fields.description') }}</td>
                    <td scope="col">{{ __('fields.file') }}</td>
                    <td scope="col">{{ __('fields.latitude') }}</td>
                    <td scope="col">{{ __('fields.longitude') }}</td>
                    <td scope="col">{{ __('fields.visibility') }}</td>
                    <td scope="col">{{ __('fields.author') }}</td>
                    <td scope="col">{{ __('resources.favorites') }}</td>
                    <td scope="col"></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($places as $place)
                <tr>
                    <td>{{ $place->id }}</td>
                    <td>{{ $place->name }}</td>
                    <td>{{ substr($place->description,0,10) . "..." }}</td>
                    <td>{{ $place->file_id }}</td>
                    <td>{{ $place->latitude }}</td>
                    <td>{{ $place->longitude }}</td>
                    <td>{{ $place->visibility->name }}</td>
                    <td>{{ $place->author->name }}</td>
                    <td>{{ $place->favorites_count }} @include('partials.buttons-favorites')</td>
                    <td>
                        <a title="{{ __('actions.view') }}" href="{{ route('places.show', $place) }}">👁️</a>
                        <a title="{{ __('actions.edit') }}" href="{{ route('places.edit', $place) }}">📝</a>
                        <a title="{{ __('actions.delete') }}" href="{{ route('places.show', [$place, 'delete' => 1]) }}">🗑️</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a class="btn btn-primary" href="{{ route('places.create') }}" role="button">
        ➕ {{ __('actions.add') . " " . __('resources.place') }}
    </a>
@endsection
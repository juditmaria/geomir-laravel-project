@extends('layouts.box-app')

@section('box-title')
    {{ __('resources.place') . " " . $place->id }}
@endsection

@section('box-content')
    <img class="img-fluid" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview"/>
    <table class="table">
            <tr>
                <td><strong>{{ __('fields.id') }}</strong></td>
                <td>{{ $place->id }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.name') }}</strong></td>
                <td>{{ $place->name }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.description') }}</strong></td>
                <td>{{ $place->description }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.latitude') }}</strong></td>
                <td>{{ $place->latitude }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.longitude') }}</strong></td>
                <td>{{ $place->longitude }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.visibility') }}</strong></td>
                <td>{{ $place->visibility->name }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.author') }}</strong></td>
                <td>{{ $place->author->name }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.created_at') }}</strong></td>
                <td>{{ $place->created_at }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.updated_at') }}</strong></td>
                <td>{{ $place->updated_at }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Buttons -->
    <div class="container" style="margin-bottom:20px">
        <a class="btn btn-warning" href="{{ route('places.edit', $place) }}" role="button">📝 {{ __('actions.edit') }}</a>
        <form id="form" method="POST" action="{{ route('places.destroy', $place) }}" style="display: inline-block;">
            @csrf
            @method("DELETE")
            <button id="destroy" type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">🗑️ {{ __('actions.delete') }}</button>
        </form>
        <a class="btn" href="{{ route('places.index') }}" role="button">⬅️ {{ __('actions.back') }}</a>
    </div>

    <!-- Favorites buttons -->
    <div class="container" style="margin-bottom:20px">
        <p>{{ __(':number favorites', ['number' => $numFavorites]) }}</p>
        @include('partials.buttons-favorites')
    </div>

    <!-- Modal -->
    @include('partials.delete-modal', [
        'resource' => __('resources.place'), 
        'id'       => $place->id
    ])

@endsection

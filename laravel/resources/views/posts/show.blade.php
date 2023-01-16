@extends('layouts.box-app')

@section('box-title')
    {{ __('resources.post') . " " . $post->id }}
@endsection

@section('box-content')
    <img class="img-fluid" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview"/>
    <table class="table">
            <tr>
                <td><strong>{{ __('fields.id') }}</strong></td>
                <td>{{ $post->id }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.body') }}</strong></td>
                <td>{{ $post->body }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.latitude') }}</strong></td>
                <td>{{ $post->latitude }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.longitude') }}</strong></td>
                <td>{{ $post->longitude }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.visibility') }}</strong></td>
                <td>{{ $post->visibility->name }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.author') }}</strong></td>
                <td>{{ $author->name }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.created_at') }}</strong></td>
                <td>{{ $post->created_at }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.updated_at') }}</strong></td>
                <td>{{ $post->updated_at }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Buttons -->
    <div class="container" style="margin-bottom:20px">
        <a class="btn btn-warning" href="{{ route('posts.edit', $post) }}" role="button">📝 {{ __('actions.edit') }}</a>
        <form id="form" method="POST" action="{{ route('posts.destroy', $post) }}" style="display: inline-block;">
            @csrf
            @method("DELETE")
            <button id="destroy" type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">🗑️ {{ __('actions.delete') }}</button>
        </form>
        <a class="btn" href="{{ route('posts.index') }}" role="button">⬅️ {{ __('actions.back') }}</a>
    </div>

    <!-- Likes buttons -->
    <div class="container" style="margin-bottom:20px">
        <p>{{ __(':number likes', ['number' => $numLikes]) }}</p>
        @include('partials.buttons-likes')
    </div>

    <!-- Modal -->
    @include('partials.delete-modal', [
        'resource' => __('resources.post'), 
        'id'       => $post->id
    ])

@endsection

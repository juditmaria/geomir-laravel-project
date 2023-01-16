@extends('layouts.box-app')

@section('box-title')
    {{ __('resources.posts') }}
@endsection

@section('box-content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td scope="col">{{ __('fields.id') }}</td>
                    <td scope="col">{{ __('fields.body') }}</td>
                    <td scope="col">{{ __('fields.file') }}</td>
                    <td scope="col">{{ __('fields.latitude') }}</td>
                    <td scope="col">{{ __('fields.longitude') }}</td>
                    <td scope="col">{{ __('fields.visibility') }}</td>
                    <td scope="col">{{ __('fields.author') }}</td>
                    <td scope="col">{{ __('resources.likes') }}</td>
                    <td scope="col"></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ substr($post->body,0,10) . "..." }}</td>
                    <td>{{ $post->file_id }}</td>
                    <td>{{ $post->latitude }}</td>
                    <td>{{ $post->longitude }}</td>
                    <td>{{ $post->visibility->name }}</td>
                    <td>{{ $post->author->name }}</td>
                    <td>{{ $post->likes_count }} @include('partials.buttons-likes')</td>
                    <td>
                        <a title="{{ __('actions.view') }}" href="{{ route('posts.show', $post) }}">👁️</a>
                        <a title="{{ __('actions.edit') }}" href="{{ route('posts.edit', $post) }}">📝</a>
                        <a title="{{ __('actions.delete') }}" href="{{ route('posts.show', [$post, 'delete' => 1]) }}">🗑️</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a class="btn btn-primary" href="{{ route('posts.create') }}" role="button">
        ➕ {{ __('actions.add') . " " . __('resources.post') }}
    </a>
@endsection
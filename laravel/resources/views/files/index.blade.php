@extends('layouts.box-app')

@section('box-title')
    {{ __('resources.files') }}
@endsection

@section('box-content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td scope="col">{{ __('fields.id') }}</td>
                    <td scope="col">{{ __('fields.filepath') }}</td>
                    <td scope="col">{{ __('fields.filesize') }}</td>
                    <td scope="col">{{ __('fields.created_at') }}</td>
                    <td scope="col">{{ __('fields.updated_at') }}</td>
                    <td scope="col"></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                <tr>
                    <td>{{ $file->id }}</td>
                    <td style="max-width: 150px;">{{ $file->filepath }}</td>
                    <td>{{ $file->filesize }}</td>
                    <td>{{ $file->created_at }}</td>
                    <td>{{ $file->updated_at }}</td>
                    <td>
                        <a title="{{ __('actions.view') }}" href="{{ route('files.show', $file) }}">👁️</a>
                        <a title="{{ __('actions.edit') }}" href="{{ route('files.edit', $file) }}">📝</a>
                        <a title="{{ __('actions.delete') }}" href="{{ route('files.show', [$file, 'delete' => 1]) }}">🗑️</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a class="btn btn-primary" href="{{ route('files.create') }}" role="button">
        ➕ {{ __('actions.add') . " " . __('resources.file') }}
    </a>
@endsection
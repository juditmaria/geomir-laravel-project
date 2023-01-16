@extends('layouts.box-app')

@section('box-title')
    {{ __('resources.file') . " " . $file->id }}
@endsection

@section('box-content')
    <img class="img-fluid" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview"/>
    <table class="table">
            <tr>
                <td><strong>{{ __('fields.id') }}</strong></td>
                <td>{{ $file->id }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.filepath') }}</strong></td>
                <td>{{ $file->filepath }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.filesize') }}</strong></td>
                <td>{{ $file->filesize }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.created_at') }}</strong></td>
                <td>{{ $file->created_at }}</td>
            </tr>
            <tr>
                <td><strong>{{ __('fields.updated_at') }}</strong></td>
                <td>{{ $file->updated_at }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Buttons -->
    <div class="container" style="margin-bottom:20px">
        <a class="btn btn-warning" href="{{ route('files.edit', $file) }}" role="button">📝 {{ __('actions.edit') }}</a>
        <form id="form" method="POST" action="{{ route('files.destroy', $file) }}" style="display: inline-block;">
            @csrf
            @method("DELETE")
            <button id="destroy" type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">🗑️ {{ __('actions.delete') }}</button>
        </form>
        <a class="btn" href="{{ route('files.index') }}" role="button">⬅️ {{ __('actions.back') }}</a>
    </div>

    <!-- Modal -->
    @include('partials.delete-modal', [
        'resource' => __('resources.file'), 
        'id'       => $file->id
    ])

@endsection

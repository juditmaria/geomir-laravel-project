<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Are you sure?') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('You are gonna delete :resource :id.', ['resource' => $resource, 'id' => $id]) }}</p>
                <p>{{ __('This action cannot be undone!') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button id="confirm" type="button" class="btn btn-primary">{{ __('Confirm') }}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @vite('resources/js/delete-modal.js')
@endpush
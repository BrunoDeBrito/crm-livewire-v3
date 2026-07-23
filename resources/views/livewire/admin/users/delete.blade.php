<div>
    <x-modal
        title="Delete user"
        subtitle="Confirm the deletion of this User: {{ $user?->name }}."
        wire:model="modal"
        separator
        class="modal-lg"
    >
        <x-input
            label="Write `DART VADER` to confirm the deletion of User"
            wire:model.defer="confirmation_confirmation"
        />

        <x-slot:actions>
            <x-button icon="o-x-circle" title="Cancel" wire:click="$set('modal', false)"/>
            <x-button
                icon="o-archive-box-x-mark"
                title="Confirm"
                wire:click="destroy"
                class="bg-red-500 hover:bg-red-700"
            />
        </x-slot:actions>

        @error('confirmation')
        <div class="mt-2">
            <x-alert icon="o-exclamation-triangle" class="alert-warning">
                <span>{{ $message }}</span>
            </x-alert>
        </div>
        @enderror
    </x-modal>
</div>

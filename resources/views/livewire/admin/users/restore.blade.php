<div>
    <x-modal
        title="Restore user"
        subtitle="Confirm the restoring access for this User: {{ $user?->name }}."
        wire:model="modal"
        separator
        class="modal-lg"
    >
        <x-input
            label="Write `YODA` to confirm the restoring of User"
            wire:model.defer="confirmation_confirmation"
        />

        <x-slot:actions>
            <x-button
                icon="o-x-circle"
                title="Cancel"
                wire:click="$set('modal', false)"
                class="btn btn-outline btn-ghost"
            />
            <x-button
                icon="o-arrow-up-circle"
                title="Confirm"
                wire:click="restore"
                class="btn btn-outline btn-success"
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

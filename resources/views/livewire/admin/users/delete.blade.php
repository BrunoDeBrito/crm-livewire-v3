<div>
    <x-button wire:click="$set('modal', true)">Delete</x-button>

    @if($this->modal)
        <x-modal wire:model="modal">
            <x-slot name="title">Delete User</x-slot>
            <x-slot name="content">
                Are you sure you want to delete this user? This action cannot be undone.
            </x-slot>
            <x-slot name="footer">
                <x-button wire:click="$set('modal', false)">Cancel</x-button>
                <x-button wire:click="deleteUser" class="bg-red-500 hover:bg-red-700">Delete</x-button>
            </x-slot>
        </x-modal>
    @endif
</div>

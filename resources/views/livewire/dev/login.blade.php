<div class="flex items-center p-2 space-x-4 bg-sky-800 justify-end">
    <x-select
        wire:model="selectedUser"
        :options="$this->users"
        placeholder="Select a user"
        icon="o-user"
        class="select-sm select-info"
    />

    <x-button
        wire:click="login"
        icon="o-arrow-top-right-on-square"
        class="btn-sm"
    >
        Login
    </x-button>
</div>

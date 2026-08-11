<div>
    <x-select
        label="Master user"
        wire:model="selectedUser"
        :options="$this->users"
        icon="o-user"
    />
</div>

<div>
    <x-header title="Users" separator/>

    <div class="flex justify-between items-center mb-4">
        <div class="w-2/3">
            <x-input
                icon="o-magnifying-glass"
                placeholder="Search by email and name"
                wire:model.live="search"
            />
        </div>
        <div>
            <x-select>
                <option value="1">1</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </x-select>
        </div>
    </div>

    <x-table :headers="$this->headers" :rows="$this->users" striped>
        @scope('cell_permissions', $user)
            @foreach($user->permissions as $permission)
                <x-badge :value="$permission->key" class="badge-primary" />
            @endforeach
        @endscope

        @scope('actions', $user)
            <x-button
                icon="o-trash"
                wire:click="delete({{ $user->id }})"
                spinner
                class="btn-sm btn-outline-primary"
            />
        @endscope
    </x-table>
</div>

<div>
    <x-header title="Users" separator/>

    <div class="flex justify-between items-center mb-4">
        <div class="w-2/3">
            <x-input
                label="Search by email or name"
                icon="o-magnifying-glass"
                placeholder="Search by email or name"
                wire:model.live="search"
            />
        </div>

        <div>
            <x-choices
                label="Filter by permissions"
                placeholder="Filter by permissions"
                wire:model.live="search_permissions"
                :options="$permissionsToSearch"
                option-label="key"
                search-function="filterPermissions"
                searchable
                no-result-text="Nothing here"
            />
        </div>

        <div>
            <x-checkbox
                class="checkbox-primary"
                label="Show deleted users"
                wire:model.live="search_trash"
                right tight
            />
        </div>
    </div>

    <x-table :headers="$this->headers" :rows="$this->users" striped>
        @scope('header_id', $header)
            <div
                wire:click="sortBy('id', '{{ $header['sortDirection'] === 'asc' ? 'desc' : 'asc' }}')"
                class="cursor-pointer"
            >
                {{ $header['label'] }} @if($header['sortColumnBy'] === 'id')
                    <x-icon :name="$header['sortDirection'] === 'asc' ? 'o-chevron-down' : 'o-chevron-up'" class="h-4 w-4" />
                @endif
            </div>
        @endscope

        @scope('header_name', $header)
            <div
                wire:click="sortBy('name', '{{ $header['sortDirection'] === 'asc' ? 'desc' : 'asc' }}')"
                class="cursor-pointer"
            >
                {{ $header['label'] }} @if($header['sortColumnBy'] === 'name')
                    <x-icon :name="$header['sortDirection'] === 'asc' ? 'o-chevron-down' : 'o-chevron-up'" class="h-4 w-4" />
                @endif
            </div>
        @endscope

        @scope('header_email', $header)
            <div
                wire:click="sortBy('email', '{{ $header['sortDirection'] === 'asc' ? 'desc' : 'asc' }}')"
                class="cursor-pointer"
            >
                {{ $header['label'] }} @if($header['sortColumnBy'] === 'email')
                    <x-icon :name="$header['sortDirection'] === 'asc' ? 'o-chevron-down' : 'o-chevron-up'" class="h-4 w-4" />
                @endif
            </div>
        @endscope

        @scope('cell_permissions', $user)
            @foreach($user->permissions as $permission)
                <x-badge :value="$permission->key" class="badge-primary"/>
            @endforeach
        @endscope

        @scope('cell_actions', $user)
            @unless($user->trashed())
            <x-button
                icon="o-trash"
                wire:click="delete({{ $user->id }})"
                spinner
                class="btn-sm btn-outline btn-error"
            />
            @else
                <x-button
                    icon="o-arrow-path-rounded-square"
                    wire:click="restore({{ $user->id }})"
                    spinner
                    class="btn-sm btn-outline btn-success"
                />
            @endunless
        @endscope
    </x-table>
</div>

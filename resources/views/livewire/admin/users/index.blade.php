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
            <x-select
                wire:model.live="perPage"
                label="Per page"
                :options="
                [
                    ['id' => 5,   'name' => 5],
                    ['id' => 15,  'name' => 15],
                    ['id' => 25,  'name' => 25],
                    ['id' => 50,  'name' => 50],
                    ['id' => 100, 'name' => 100],
                ]"
            />
        </div>

        <div>
            <x-checkbox
                class="checkbox-primary"
                label="Show deleted"
                wire:model.live="search_trash"
                right tight
            />
        </div>
    </div>

    <x-table
        :headers="$this->headers"
        :rows="$this->users->getCollection()"
        striped
        with-pagination
    >
        @scope('header_id', $header)
            <x-table.th :$header name="id"/>
        @endscope

        @scope('header_name', $header)
            <x-table.th :$header name="name"/>
        @endscope

        @scope('header_email', $header)
            <x-table.th :$header name="email"/>
        @endscope

        @scope('cell_permissions', $user)
            @foreach($user->permissions as $permission)
                <x-badge :value="$permission->key" class="badge-primary"/>
            @endforeach
        @endscope

        @scope('cell_actions', $user)
            @unless($user->trashed())
                @unless($user->is(auth()->user()))
                    <x-button
                        id="delete-user-{{ $user->id }}"
                        wire:key="delete-user-{{ $user->id }}"
                        icon="o-trash"
                        wire:click="destroy('{{ $user->id }}')"
                        spinner
                        class="btn-sm btn-outline btn-error"
                    />
                @endunless
            @else
                <x-button
                    icon="o-arrow-path-rounded-square"
                    wire:click="restore('{{ $user->id }}')"
                    spinner
                    class="btn-sm btn-outline btn-success"
                />
            @endunless
        @endscope
    </x-table>

    {{ $this->users->links(data: ['scrollTo' => false]) }}

    <livewire:admin.users.delete />
    <livewire:admin.users.restore />
    <livewire:admin.users.show />

</div>

<div>
    <x-header title="Customers" separator/>

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
    </div>

    <x-table
        :headers="$this->headers"
        :rows="$this->customers->getCollection()"
        striped
    />

    {{ $this->customers->links(data: ['scrollTo' => false]) }}
</div>

<div>

    <x-modal wire:model="modal" :title="$user?->name" separator="">
        @if($user)
            <x-input readonly label="Name" :value="$user->name"/>
            <x-input readonly label="Email" :value="$user->email"/>
            <x-input readonly label="Created At" :value="$user->created_at->format('d/m/Y H:i')"/>
            <x-input readonly label="Updated At" :value="$user->updated_at->format('d/m/Y H:i')"/>
            <x-input readonly label="Deleted At" :value="$user->deleted_at?->format('d/m/Y H:i')"/>
            <x-input readonly label="Deleted By" :value="$user->deletedBy?->name"/>
        @endif

        <x-slot:actions>

            <x-button
                @click="$wire.modal = false"
                label="Close"
                color="secondary"
                squared
            />

        </x-slot:actions>

    </x-modal>

</div>

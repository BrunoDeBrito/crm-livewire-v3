<x-card title="Password Recovery" shadow class="mx-auto w-[500px]">
    <x-form wire:submit="startPasswordRecovery">
        <x-input label="Email" wire:model="email"/>

        <x-slot:actions>
            <div class="w-full flex items-center justify-between">
                <a wire:navigate href="{{ route("login") }}" class="link link-primary">
                    Never mind, get back to login page
                </a>
                <div>
                    <x-button label="Login" class="btn-primary" type="submit" spinner="submit"/>
                </div>
            </div>
        </x-slot:actions>

        @if($message)
            <x-alert icon="o-exclamation-triangle" class="alert-success">
                <span>You will receive an email the password recovery link.</span>
            </x-alert>
        @endif
    </x-form>
</x-card>

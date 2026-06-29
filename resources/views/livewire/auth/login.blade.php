<x-card title="Login" shadow class="mx-auto w-[500px]">
    <x-form wire:submit="tryToLogin">
        <x-input label="Email" wire:model="email"/>
        <x-input label="Password" wire:model="password" type="password"/>
        <div class="w-full text-right text-sm">
            <a wire:navigate href="{{ route("auth.password.recovery") }}" class="link link-primary">
                I want to create an account
            </a>
        </div>

        <x-slot:actions>
            <div class="w-full flex items-center justify-between">
                <a wire:navigate href="{{ route("auth.register") }}" class="link link-primary">
                    I want to create an account
                </a>
                <div>
                    <x-button label="Reset" type="reset"/>
                    <x-button label="Login" class="btn-primary" type="submit" spinner="submit"/>
                </div>
            </div>
        </x-slot:actions>

        @error('invalidCredentials')
        <x-alert icon="o-exclamation-triangle" class="alert-warning">
            <span>{{ $message }}</span>
        </x-alert>
        @enderror

        @error('rateLimiter')
        <x-alert icon="o-exclamation-triangle" class="alert-warning">
            <span>{{ $message }}</span>
        </x-alert>
        @enderror
    </x-form>
</x-card>


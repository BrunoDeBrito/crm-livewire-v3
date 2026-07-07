<x-card title="Password Reset" shadow class="mx-auto w-[500px]">
    <x-form wire:submit="updatePassword">
        <x-input label="Email" value="{{ $this->obfuscatedEmail }}" readonly/>
        <x-input label="Email Confirmation" wire:model="email_confirmation" type="email"/>
        <x-input label="Password" type="password" wire:model="password"/>
        <x-input label="Confirm Password" type="password" wire:model="password_confirmation"/>

        <x-slot:actions>
            <div class="w-full flex items-center justify-between">
                <a wire:navigate href="{{ route("login") }}" class="link link-primary">
                    Never mind, get back to login page
                </a>
                <div>
                    <x-button label="Reset Password" class="btn-primary" type="submit" spinner="submit"/>
                </div>
            </div>
        </x-slot:actions>

        @if($message = session()->get('status'))
            <x-alert icon="o-exclamation-triangle" class="alert-success">
                <span>{{ $message }}</span>
            </x-alert>
        @endif
    </x-form>
</x-card>

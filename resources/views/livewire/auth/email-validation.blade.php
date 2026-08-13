<x-card
    title="Email Validation"
    subtitle="We Send a New Code to Your Email"
    shadow class="mx-auto w-[500px]" separator
>
    <x-form wire:submit="handle">
        <x-input label="Code" wire:model="code"/>

        <x-slot:actions>
            <div class="w-full flex items-center justify-between">
                <a wire:click="sendNewCode" class="link link-primary">
                    Send a new code
                </a>
                <div>
                    <x-button label="Reset" type="reset"/>
                    <x-button label="Check Code" class="btn-primary" type="submit" spinner="submit"/>
                </div>
            </div>
        </x-slot:actions>

        @if($sendNewCodeMessage)
            <x-alert icon="o-envelope" class="alert-info">
                <span>{{ $sendNewCodeMessage }}</span>
            </x-alert>
        @endif

    </x-form>
</x-card>


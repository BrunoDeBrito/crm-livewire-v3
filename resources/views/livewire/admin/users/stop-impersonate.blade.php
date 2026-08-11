<div class="bg-yellow-200 px-4 py-2 text-sm text-yellow-900 hover:font-bold hover:bg-yellow-300 cursor-pointer" wire:click="stop">
    {{ __("You are impersonating :name, click here to stop the impersonation.", ['name' => $user->name]) }}
</div>

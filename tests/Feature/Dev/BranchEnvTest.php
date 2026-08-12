<?php

use App\Livewire\Dev\BranchEnv;
use Livewire\Livewire;

it('should a current branch in the page', function () {
    Process::fake([
        'git branch --show-current' => Process::result('feature/CRM-12'),
    ]);

    Livewire::test(BranchEnv::class)
        ->assertSet('branch', 'feature/CRM-12')
        ->assertSee('feature/CRM-12');

    Process::assertRan('git branch --show-current');
});

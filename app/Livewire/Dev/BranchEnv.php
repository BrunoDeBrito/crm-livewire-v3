<?php

namespace App\Livewire\Dev;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Process;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @class BranchEnv
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 8/11/26 21:26
 * @version 1.0.0
 *
 */
class BranchEnv extends Component
{
    public function render(): View
    {
        return view('livewire.dev.branch-env');
    }

    #[Computed]
    public function branch(): string
    {
        $process = Process::run('git branch --show-current');

        return trim($process->output());
    }
}

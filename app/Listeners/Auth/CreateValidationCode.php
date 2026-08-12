<?php

namespace App\Listeners\Auth;

use App\Models\User;
use App\Notifications\ValidationCodeNotification;
use Illuminate\Auth\Events\Registered;

/**
 * @class CreateValidationCode
 *
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 *
 * @since 8/12/26 14:50
 *
 * @version 1.0.0
 */
class CreateValidationCode
{
    public function handle(Registered $event): void
    {
        /** @var User $user */
        $user = $event->user;

        $user->validation_code = random_int(100000, 999999);

        $user->save();

        $user->notify(new ValidationCodeNotification());
    }
}

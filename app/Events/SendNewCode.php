<?php

namespace App\Events;

use App\Models\User;
use App\Notifications\ValidationCodeNotification;
use Illuminate\Broadcasting\{InteractsWithSockets, PrivateChannel};
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * @class SendNewCode
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 8/12/26 18:02
 * @version 1.0.0
 *
 */
class SendNewCode
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public User $user)
    {
        $user = auth()->user();
        $user->update([
            'validation_code' => rand(100000, 999999),
        ]);

        $user->notify(new ValidationCodeNotification());
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}

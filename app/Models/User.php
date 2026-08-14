<?php

namespace App\Models;

use App\Traits\{HasPermissions, HasSearch};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{SoftDeletes};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @class User
 *
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 *
 * @since 6/18/26 23:08
 *
 * @version 1.0.0
 */
class User extends Authenticatable implements Auditable
{
    use AuditableTrait;
    use HasApiTokens;
    use HasFactory;
    use HasPermissions;
    use Notifiable;
    use SoftDeletes;
    use HasSearch;

    protected $fillable = [
        'name',
        'email',
        'password',
        'validation_code',
        'restored_at',
        'restored_by',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function restoredBy(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'restored_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'deleted_by');
    }

}

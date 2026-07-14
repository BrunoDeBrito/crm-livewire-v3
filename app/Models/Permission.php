<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @class Permission
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 7/8/26 22:31
 * @version 1.0.0
 *
 */
class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['key', ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}

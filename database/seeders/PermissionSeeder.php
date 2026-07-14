<?php

namespace Database\Seeders;

use App\Enums\Can;
use App\Models\{Permission};
use Illuminate\Database\Seeder;

/**
 * @class PermissionSeeder
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 7/9/26 15:52
 * @version 1.0.0
 *
 */
class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::create(['key' => Can::BE_AN_ADMIN]);
    }
}

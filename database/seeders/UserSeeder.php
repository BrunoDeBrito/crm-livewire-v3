<?php

namespace Database\Seeders;

use App\Enums\Can;
use App\Models\{User};
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            'name'  => 'Admin do CRM',
            'email' => 'admin@crm.com',
        ];

        User::factory()
            ->withPermission(Can::BE_AN_ADMIN)
            ->create($users);

        User::factory()->count(5)->create();
        User::factory()->count(2)->deleted()->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
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
            ->withPermission('be an admin')
            ->create($users);
    }
}

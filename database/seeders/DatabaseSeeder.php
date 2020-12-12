<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use Database\Seeders\seeds\RolesPermissions\RolesPermissions;
use Database\Seeders\seeds\UsersAdmin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesPermissions::class,
            UsersAdmin::class,
        ]);

        User::factory(20)->create();

        User::all()->each(function ($user) {
            if (!$user->hasRole('admin')) {
                $user->assignRole('user');
            }
        });
    }
}

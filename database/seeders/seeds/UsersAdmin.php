<?php


namespace Database\Seeders\seeds;


use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersAdmin extends Seeder
{
    public function run()
    {
        $userAdmin = User::firstOrCreate(
            ['email' => 'darkfred78@gmail.com'],
            [
                'name' => 'Fred',
                'password' => Hash::make('Artobj21')
            ]
        );
        $userAdmin->assignRole('admin');

        $user = User::firstOrCreate(
            ['email' => 'test123@gmail.com'],
            [
                'name' => 'test',
                'password' => Hash::make('Artobj21')
            ]
        );
        $user->assignRole('user');

    }
}

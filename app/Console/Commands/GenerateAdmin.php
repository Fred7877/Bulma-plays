<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GenerateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create my profil admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::firstOrCreate(
            ['email' => env('ADMIN_PROFIL_IDENTIFIANT')],
            [
                'name' => 'Fred',
                'password' => Hash::make(env('ADMIN_PROFIL_PASSWORD'))
            ]
        );

        $user->assignRole('admin');

        return 0;
    }
}

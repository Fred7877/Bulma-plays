<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Platform;
use App\Models\ReleaseDate;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use MarcReichel\IGDBLaravel\Models\Game as GamesIGDB;
use MarcReichel\IGDBLaravel\Models\Platform as PlatformIGDB;
use MarcReichel\IGDBLaravel\Models\ReleaseDate as ReleaseDateIGDB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create roles';

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
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $permissionAdmin = Permission::firstOrCreate(['name' => 'enter backend']);

        $roleAdmin->givePermissionTo($permissionAdmin);
        $permissionAdmin->assignRole($roleAdmin);

        $roleUser = Role::firstOrCreate(['name' => 'user']);
        $permissionUser = Permission::firstOrCreate(['name' => 'add comments and replies']);

        $roleUser->givePermissionTo($permissionUser);
        $permissionUser->assignRole($roleUser);

        return 0;
    }
}

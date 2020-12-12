<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GenerateRoles extends Command
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

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;

class ListRolesPermissions extends Command
{
    protected $signature = 'roles:permisos';
    protected $description = 'Lista todos los roles con sus permisos';

    public function handle()
    {
        $roles = Role::with('permissions')->get();

        foreach ($roles as $role) {

            $this->info('ROL: ' . $role->name);

            if ($role->permissions->count()) {

                foreach ($role->permissions as $permission) {
                    $this->line('   - ' . $permission->name);
                }

            } else {

                $this->line('   (sin permisos)');

            }

            $this->line('-----------------------------------');
        }

        return Command::SUCCESS;
    }
}

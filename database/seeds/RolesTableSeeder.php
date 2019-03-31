<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $roles = [
            'super_admin'
        ];

        foreach ($roles as $role) {
            if (Role::whereName($role)
                    ->count() === 0) {
                $newRole = Role::create([
                    'name' => $role
                ]);

                if ($role === 'super_admin') {
                    $newRole->givePermissionTo(\Spatie\Permission\Models\Permission::all());
                }
            }
        }
    }
}

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
            'Super Admin',
            'Sales',
            'Finance',
        ];

        foreach ($roles as $role) {
            if (Role::whereName($role)
                    ->count() === 0) {
                $newRole = Role::create([
                    'name' => $role
                ]);

                if ($role === 'Super Admin') {
                    $newRole->givePermissionTo(\Spatie\Permission\Models\Permission::all());
                } elseIf ($role === 'Sales') {
                    $newRole->givePermissionTo(\Spatie\Permission\Models\Permission::where('name',
                        'like', "%product%")
                                                                                   ->orWhere('name',
                                                                                       "like",
                                                                                       "%client%")
                                                                                   ->orWhere('name',
                                                                                       "like",
                                                                                       "%contact%")
                                                                                   ->orWhere('name',
                                                                                       "like",
                                                                                       "%project%")
                                                                                   ->get());
                } elseIf ($role === 'Finance') {
                    $newRole->givePermissionTo(\Spatie\Permission\Models\Permission::where('name',
                        'like', "%invoice%")
                                                                                   ->orWhere('name',
                                                                                       "like",
                                                                                       "%invoice%")
                                                                                   ->get());
                }
            }
        }
    }
}

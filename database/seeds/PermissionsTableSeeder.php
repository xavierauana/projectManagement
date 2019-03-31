<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $actions = [
            'browse',
            'read',
            'edit',
            'create',
            'delete'
        ];
        $entities = [
            'project',
            'project_option',
            'client',
            'contact',
        ];


        $permissions = [];

        foreach ($entities as $entity) {
            foreach ($actions as $action) {
                $permissions[] = $action . "_" . $entity;
            }
        }

        foreach ($permissions as $permission) {
            if (Permission::whereName($permission)
                          ->count() === 0) {
                Permission::create([
                    'name' => $permission
                ]);
            }
        }
    }
}

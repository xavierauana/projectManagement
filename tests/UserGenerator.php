<?php
/**
 * Author: Xavier Au
 * Date: 2019-03-15
 * Time: 21:40
 */

namespace Tests;


use App\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserGenerator
{

    private $roles = [];
    private $permissions = [];

    public function addRole(string $role): UserGenerator {
        $this->roles[] = $role;

        return $this;
    }

    public function addPermission(string $permission): UserGenerator {
        $this->permissions[] = $permission;

        return $this;
    }

    public function generate(array $params = []): User {
        $user = factory(User::class)->create($params);
        $permissions = collect($this->permissions)->map(function (
            string $permissionName
        ) {
            return Permission::create(['name' => $permissionName]);
        });

        if (count($this->roles)) {
            $roles = collect($this->roles)
                ->map(function (string $roleName) {
                    return Role::create(['name' => $roleName]);
                });
        } else {
            $roles = collect(['default'])
                ->map(function (string $roleName) {
                    return Role::create(['name' => $roleName]);
                });
        }

        $roles->each(function (Role $role) use ($permissions) {
            $role->givePermissionTo($permissions);
        })
              ->each(function (Role $role) use ($user) {
                  $user->assignRole($role);
              });

        return $user->refresh();
    }
}
<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $users = [
            [
                'first_name'              => 'Xavier',
                'last_name'               => 'Au',
                'email'                   => 'xavier.au@anacreation.com',
                'require_change_password' => false,
                'password'                => 'aukaiyuen',
                'role'                    => 'Super Admin'
            ],
            [
                'first_name'              => 'Sales',
                'last_name'               => 'Agent',
                'email'                   => 'sales.agent@anacreation.com',
                'require_change_password' => false,
                'password'                => '123456',
                'role'                    => 'Sales'
            ],
            [
                'first_name'              => 'Finance',
                'last_name'               => 'Accountant',
                'email'                   => 'finance.accountant@anacreation.com',
                'require_change_password' => false,
                'password'                => '123456',
                'role'                    => 'Finance'
            ],
        ];

        foreach ($users as $user) {
            $role = Role::where('name', 'like', "%" . $user['role'] . "%")
                        ->first();
            unset($user['role']);
            $newUser = new User($user);
            $newUser->password = bcrypt($user['password']);
            $newUser->save();
            $newUser->assignRole($role);
        }
    }
}

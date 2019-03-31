<?php

use App\User;
use Illuminate\Database\Seeder;

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
                'first_name' => 'Xavier',
                'last_name'  => 'Au',
                'email'      => 'xavier.au@anacreation.com',
                'password'   => 'aukaiyuen',
            ]
        ];

        foreach ($users as $user) {
            $newUser = new User($user);
            $newUser->password = bcrypt($user['password']);
            $newUser->save();
            $newUser->assignRole(\Spatie\Permission\Models\Role::whereName('super_admin')
                                                               ->first());
        }
    }
}

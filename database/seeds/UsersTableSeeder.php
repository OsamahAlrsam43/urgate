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
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@alnkel.com',
            'password' => bcrypt('secret'),
            'type' => 'Super Admin'
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@alnkel.com',
            'password' => bcrypt('secret'),
            'type' => 'User'
        ]);
    }
}

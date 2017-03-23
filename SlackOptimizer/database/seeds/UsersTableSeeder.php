<?php

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
        DB::table('users')->delete();

        $users = array(
            ['name' => 'Milos Milosevic', 'email' => 'milos.milosevic@labs.devana.rs', 'password'
            => bcrypt('12345678'), 'remember_token' => 'xoxp-13094425427-63185365809-76343184178-d4a67e6c16']
        );

        DB::table('users')->insert($users);
    }
}

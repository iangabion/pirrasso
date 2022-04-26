<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if (DB::table('users')->where('email', 'admin@admin.com')->count() == 0) {
            DB::table('users')->insert([
                'name'     => 'Demo Admin',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);
             DB::table('users')->insert([
                'name'     => 'Taneo',
                'email'    => 'demo@demo.com',
                'password' => bcrypt('demo'),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => NULL,
                'password' => Hash::make('admin'),
                'status' => 1,
                'remember_token' => NULL,
                'created_at' => \Carbon\Carbon::now()->toDateTime(),
                'updated_at' => \Carbon\Carbon::now()->toDateTime(),
            ),
        ));


    }
}

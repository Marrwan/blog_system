<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => "Admin1",
            'role_id' => "1",
            'email' => "Admin@admin.com",
            'password' =>  bcrypt("Admin"),
            'about' => "I am a Girly Girl",
            'username' => "admin"
        ]);
        DB::table('users')->insert([
            'name' => "author1",
            'role_id' => "2",
            'email' => "author@author.com",
            'password' =>  bcrypt("author"),
            'about' => "I am a Boyly Girl",
            'username' => "author"
        ]);
    }
}

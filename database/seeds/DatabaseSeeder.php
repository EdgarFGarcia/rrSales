<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

    	$user = DB::table('users')->insert([
    		"username" => "admin",
    		"password" => bcrypt('password'),
    		"fullname" => "Admin Admin",
    		"mobile_number" => "012345678901"
    	]);

    }
}

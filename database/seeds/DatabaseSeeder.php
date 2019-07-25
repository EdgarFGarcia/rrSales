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

    	$user = DB::table('users')->insertGetId([
    		"username" => "admin",
    		"password" => "$2y$10$Tpz.GKin4Y2SwKqzVmGBRuNLIaVL4Sfwz1f1fFhs0ZoCvi7LQX4EC",
    		"fullname" => "Admin Admin",
    		"mobile_number" => "012345678901"
    	]);

    }
}

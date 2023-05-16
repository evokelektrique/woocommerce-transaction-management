<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert([
            'name' => env("ADMIN_USER_NAME"),
            'email' => env("ADMIN_USER_EMAIL"),
            'password' => Hash::make(env("ADMIN_USER_PASSWORD")),
        ]);
    }
}

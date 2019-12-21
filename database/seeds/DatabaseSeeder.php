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
        //Semear dados essenciais ao software: Tipos de utilizador e utilizador super user
        $this->call(PermissoesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

    }
}

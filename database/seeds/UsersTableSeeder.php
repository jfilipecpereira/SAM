<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inserir o SuperUser
        DB::table('users')->insert([
            'nome' => 'teste',
            'id_aluno' => null,
            'email' => 'teste@teste.pt',
            'password' => bcrypt('teste'),
            'permissao' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // Inserir Direção
        DB::table('users')->insert([
            'nome' => 'direcao',
            'id_aluno' => null,
            'email' => 'testedir@teste.pt',
            'password' => bcrypt('teste'),
            'permissao' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

    }
}

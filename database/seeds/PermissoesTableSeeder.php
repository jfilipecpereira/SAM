<?php

use App\Permissoes;
use Illuminate\Database\Seeder;

class PermissoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inserir os tipos de utilizadores
        $permissoes = [
            ['id' => 1, 'nome' => 'Super User', 'titulo_pagina' => 'iSAM | Administração'],
            ['id' => 2, 'nome' => 'Direção', 'titulo_pagina' => 'iSAM | Direção'],
            ['id' => 3, 'nome' => 'Secretaria', 'titulo_pagina' => 'iSAM | Secretaria'],
            ['id' => 4, 'nome' => 'Aluno', 'titulo_pagina' => 'iSAM | Dashboard']];

        foreach($permissoes as $permissao){
            Permissoes::create($permissao);
        }
    }
}

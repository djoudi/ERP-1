<?php


class TabelaContatosSeeder extends Seeder {

    public function run()
    {
        DB::table('contatos')->truncate();

        Contato::create([
            'id'             => 1,
            'nome'           => "Ricardo Rodrigues Barbosa",
            'numeroDocumento'=> "69370052101",
            'descricao'      => "Sócio-proprietário da Top Claro"
        ]);

        Contato::create([
            'id'             => 2,
            'nome'           => "Edygar de Lima Oliveira",
            'numeroDocumento'=> "69370052100",
            'descricao'      => "Desenvolvedor do sistema"
        ]);

        Contato::create([
            'numeroDocumento'=> "69370052103",
            'id'             => 3,
            'nome'           => "Bruno da Silva Oliveira",
            'descricao'      => "Administrador da empresa"
        ]);

        Contato::create([
            'id'             => 4,
            'nome'           => "Gil Gráfica",
            'numeroDocumento'=> "00285505000140",
            'pessoaJuridica' => true,
        ]);

        Contato::create([
            'id'             => 5,
            'nome'           => "Top Claro",
            'numeroDocumento'=> "00285505000140",
            'pessoaJuridica' => true,
        ]);

    }

}

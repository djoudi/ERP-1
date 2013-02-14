<?php


class TabelaEnderecosSeeder extends Seeder {

    public function run()
    {
        DB::table('enderecos')->truncate();


        Contato::find(2)->enderecos()->save(
            new Endereco([
                'identificacao' => "casa",
                'numero' => "164",
                'logradouro' => "Rua C",
                'bairro' => "Setor Leste Vila Nova",
                'complemento' => "Qd F2, Lt 16",
                'localidade' => "Goiânia",
                'uf' => "GO",
                'cep' => "74633260",
            ]));

    }
}



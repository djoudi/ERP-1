<?php


class TabelaTelefonesSeeder extends Seeder {

    public function run()
    {
        DB::table('contatos_telefones')->truncate();
        DB::table('telefones')->truncate();

        Contato::find(1)->telefones()->save(
            new Telefone([
                'identificacao'     => "Trabalho",
                'numero'            => "6292941854",
            ]));

        Contato::find(2)->telefones()->save(
            new Telefone([
                'identificacao'     => "Trabalho",
                'numero'            => "6282306673",
            ]));

        Contato::find(3)->telefones()->save(
            new Telefone([
                'identificacao'     => "Trabalho",
                'numero'            => "6292398275",
            ]));

        Contato::find(3)->telefones()->save(
            new Telefone([
                'identificacao'     => "Trabalho",
                'numero'            => "6232130024",
            ]));
    }

}



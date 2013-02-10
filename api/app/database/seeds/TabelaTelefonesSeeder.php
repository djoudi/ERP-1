<?php


class TabelaTelefonesSeeder extends Seeder {

    public function run()
    {
        DB::table('contatos_telefones')->truncate();
        DB::table('telefones')->truncate();

        Contato::find(1)->telefones()->save(
            new Telefone([
                'identificacao'     => "Trabalho",
                'numero'            => "(62) 9294-1854",
            ]));

        Contato::find(2)->telefones()->save(
            new Telefone([
                'identificacao'     => "Trabalho",
                'numero'            => "(62) 8230-6673",
            ]));

        Contato::find(3)->telefones()->save(
            new Telefone([
                'identificacao'     => "Trabalho",
                'numero'            => "(62) 9239-8275",
            ]));

        Contato::find(3)->telefones()->save(
            new Telefone([
                'identificacao'     => "Trabalho",
                'numero'            => "(62) 3213-0024",
            ]));
    }

}



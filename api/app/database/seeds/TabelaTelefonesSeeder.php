<?php


class TabelaTelefonesSeeder extends Seeder {

    public function run()
    {
        DB::table('telefones')->truncate();
        $contatos = Contato::all();

        Telefone::create([
            'contato'           => $contatos[0]->id,
            'identificacao'     => "Trabalho",
            'numero'            => "(62) 9294-1854",
        ]);

        Telefone::create([
            'contato'           => $contatos[1]->id,
            'identificacao'     => "Trabalho",
            'numero'            => "(62) 8230-6673",
        ]);

        Telefone::create([
            'contato'           => $contatos[2]->id,
            'identificacao'     => "Trabalho",
            'numero'            => "(62) 9239-8275",
        ]);

        Telefone::create([
            'contato'           => $contatos[2]->id,
            'identificacao'     => "Trabalho",
            'numero'            => "(62) 3213-0024",
        ]);
    }

}



<?php


class TabelaEmailsSeeder extends Seeder {

    public function run()
    {
        DB::table('emails')->truncate();
        $contatos = Contato::all();


        Email::create([
            'contato'           => $contatos[0]->id,
            'identificacao'     => "Trabalho",
            'email'             => "ricardo@topclaro.com.br"
        ]);

        Email::create([
            'contato'           => $contatos[1]->id,
            'identificacao'     => "Trabalho",
            'email'             => "edygardelima@gmail.com"
        ]);

        Email::create([
            'contato'           => $contatos[2]->id,
            'identificacao'     => "Trabalho",
            'email'             => "bruno@gilgrafica.com.br"
        ]);

        Email::create([
            'contato'           => $contatos[2]->id,
            'identificacao'     => "Trabalho",
            'email'             => "gilgrafica@gilgrafica.com.br"
        ]);

        Email::create([
            'contato'           => $contatos[3]->id,
            'identificacao'     => "Trabalho",
            'email'             => "contato@topclaro.com.br"
        ]);
    }

}



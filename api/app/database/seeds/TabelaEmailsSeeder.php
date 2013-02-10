<?php


class TabelaEmailsSeeder extends Seeder {

    public function run()
    {
        DB::table('contatos_emails')->truncate();
        DB::table('emails')->truncate();


        Contato::find(1)->emails()->save(
            new Email([
                'id'                => 1,  
                'identificacao'     => "Trabalho",
                'email'             => "ricardo@topclaro.com.br"
            ]));


        Contato::find(2)->emails()->save(
            new Email([
                'id'                => 2,   
                'identificacao'     => "Trabalho",
                'email'             => "edygardelima@gmail.com"
            ]));

        Contato::find(3)->emails()->save(
            new Email([
                'id'                => 3,   
                'identificacao'     => "Trabalho",
                'email'             => "bruno@gilgrafica.com.br"
            ]));

        Contato::find(3)->emails()->save(
            new Email([
                'id'                => 4,   
                'identificacao'     => "Trabalho",
                'email'             => "gilgrafica@gilgrafica.com.br"
            ]));

        Contato::find(4)->emails()->save(
            new Email([
                'id'                => 5,   
                'identificacao'     => "Trabalho",
                'email'             => "contato@topclaro.com.br"
            ]));

    }

}



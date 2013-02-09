<?php


class TabelaContatosSeeder extends Seeder {

    public function run()
    {
        DB::table('contatos')->truncate();
        $contatos = Contato::all();

        Contato::create([
            'consultor'        => $contatos[0]->id,
            'contato'          => $contatos[3]->id,
            'numeroCliente'    => 1234,
            'administrador'    => $contatos[2]->id,
            'senhaAtendimento' => 0028,
            'usuarioGestor'    => "gilgrafica",
            'senhaGestor'      => "4321",
            'inicioContrato'   => new DateTime(),
            'periodo'          => 360
        ]);

        Contato::create([
            'consultor'        => $contatos[1]->id,
            'contato'          => $contatos[4]->id,
            'numeroCliente'    => 5678,
            'administrador'    => $contatos[2]->id,
            'senhaAtendimento' => 1400,
            'usuarioGestor'    => "topclaro",
            'senhaGestor'      => "1029",
            'inicioContrato'   => new DateTime(),
            'periodo'          => 360
        ]);

    }

}

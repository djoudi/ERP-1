<?php

class Endereco extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'enderecos';


	public function contatos()
    {
        return $this->belongsTo('Contato', 'contato');
    }
}
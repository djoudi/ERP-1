<?php

class Telefone extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'telefones';


	public function contatos()
	{		
        return $this->belongsTo('Contato', 'contato');
	}
}
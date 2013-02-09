<?php

class Telefone extends Eloquent {
     public $timestamps = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'telefones';


	public function contato()
	{
		return $this->belongsTo('contato', 'contato');
	}
}
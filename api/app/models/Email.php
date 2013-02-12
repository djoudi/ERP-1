<?php

class Email extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'emails';




	public function contatos()
    {
        return $this->belongsTo('Contato', 'contato');
    }
}
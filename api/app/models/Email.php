<?php

class Email extends Eloquent {
     public $timestamps = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'emails';




	public function contatos()
    {
		return $this->belongsToMany('Contato', 'emails_contatos');
    }
}
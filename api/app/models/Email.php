<?php

class Email extends Eloquent {
     public $timestamps = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'emails';




	public function contato()
    {
        return $this->belongsTo('Contato', 'contato');
    }
}
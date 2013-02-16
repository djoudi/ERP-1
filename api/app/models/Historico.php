<?php

class Historico extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'historicos';


	public function cliente()
	{
        return $this->belongsTo('Cliente', 'cliente');
	}
}
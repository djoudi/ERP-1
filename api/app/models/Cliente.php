<?php

class Cliente extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'clientes';

	public function empresa()
	{
		return $this->hasOne("empresa");
	}

	public function consultor()
	{
		return $this->hasOne("consultor");
	}

	public function administrador()
	{
		return $this->hasOne("administrador");
	}

}
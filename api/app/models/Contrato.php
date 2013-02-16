<?php

class Contrato extends Eloquent
{
	protected $table = 'contratos';

	public function empresa()
	{
		return $this->belongsTo("Contato", "empresa");
	}

	public function consultor()
	{
		return $this->belongsTo("Contato","consultor");
	}

	public function administrador()
	{
		return $this->belongsTo("Contato","administrador");
	}

	public function historicos()
	{
		return $this->hasMany("Historico","cliente");
	}
}


 
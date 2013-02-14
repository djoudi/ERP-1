<?php

class Contato extends Eloquent
{	
	protected $table = 'contatos';
	

	public function emails()
	{
		return $this->hasMany('Email', 'contato');
	}

	public function telefones()
	{
		return $this->hasMany('Telefone', 'contato');
	}

	public function enderecos()
	{
		return $this->hasMany('Endereco', 'contato');
	}

	public function contratos()
	{
		return $this->hasMany("Contrato", "empresa");
	}
}

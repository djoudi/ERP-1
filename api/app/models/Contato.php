<?php

class Contato extends Eloquent {
	
	public $timestamps = false;
	protected $table = 'contatos';



	 public function emails()
     {
          return $this->hasMany('Email', 'contato');
     }

	 public function telefones()
     {
          return $this->hasMany('Telefone', 'contato');
     }

}
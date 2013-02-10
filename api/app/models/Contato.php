<?php

class Contato extends Eloquent {
	
	public $timestamps = false;
	protected $table = 'contatos';



	 public function emails()
     {
          return $this->belongsToMany('Email', 'contatos_emails');
     }

      public function telefones()
     {
          return $this->belongsToMany('Telefone', 'contatos_telefones');
     }

}
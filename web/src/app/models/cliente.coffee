define [
	'jquery'		
	'underscore'		
	'backbone'
], ($,_,Backbone)->

	class Cliente extends Backbone.Model
		idAttribute: "cliente_id"
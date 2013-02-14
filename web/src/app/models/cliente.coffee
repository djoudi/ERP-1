define [
	'jquery'		
	'underscore'		
	'backbone',
	'models/contato'
], ($,_,Backbone, Contato)->
	class Cliente extends Backbone.Model
define [
	'jquery'		
	'underscore'		
	'backbone'
], ($,_,Backbone)->
	class ClientesRouter extends Backbone.SubRoute
		routes:
			''       : "listar"
			'/listar' : "listar"

		listar: ->
			console.log	 "abrir listagem"

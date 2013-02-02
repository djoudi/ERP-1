define [
	'jquery'		
	'underscore'		
	'backbone'
], ($,_,Backbone)->
	class ClientesRouter extends Backbone.SubRoute
		routes:
			''     : "theAlert"
			'list' : "theAlert"

		list: ->
			console.log	 "abrir listagem"

define [
	'jquery'		
	'underscore'		
	'backbone'
	'models/clientes'
], ($,_,Backbone, Clientes)->
	class ClientesRouter extends Backbone.SubRoute
		routes:
			''       : "listar"
			'/'      : "listar"
			'listar' : "listar"

		listar: ->
			# Inserir View de Listagem na Tela
			clientes = new Clientes()
			clientes.fetch
				success: ->
					console.log	 clientes

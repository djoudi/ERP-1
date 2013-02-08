define [
	'jquery'		
	'underscore'		
	'backbone'
	'settings'
	'models/cliente'
], ($,_,Backbone,Settings,Cliente)->

	class Clientes extends Backbone.Collection
		model: Cliente
		url: Settings["API_URL"]+"/clientes"
		
		comparator: (model) ->
			model.get "name"
			
		parse: (response)->
			return response.data

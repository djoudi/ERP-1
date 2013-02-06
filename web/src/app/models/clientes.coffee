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
		parse: (response)->
			return response.data

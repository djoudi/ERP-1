define [
	'underscore'		
	'backbone'
	'settings'
	'models/endereco'
], (_,Backbone, Settings, Endereco)->

	class Enderecos extends Backbone.Collection
		initialize: (items, options)->
			@contato = options.contato if options.contato?
		url: ()->
			base = if @contato? then "#{@contato.url()}" else Settings.api.url
			base +="/telefones"


		model: Endereco

	Enderecos
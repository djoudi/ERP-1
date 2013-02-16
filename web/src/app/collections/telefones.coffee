define [
	'underscore'		
	'backbone'
	'settings'
	'models/telefone'
], (_,Backbone, Settings, Telefone)->

	###
	#	Collection do Telefone
	###
	class Telefones extends Backbone.Collection
		model: Telefone
		initialize: (items, options)->
			@contato = options.contato if options.contato?
		url: ()->
			base = if @contato? then "#{@contato.url()}" else Settings.api.url
			base +="/telefones"





	Telefones.format = 
		fromRaw: (rawData)->
			rawData = _(rawData).map Telefone.format.fromRaw

		toRaw: (formattedData)->
			_(formattedData).map Telefone.format.toRaw

	Telefones::formatToRaw = ->
		Telefones.format.toRaw @toJSON()

	Telefones::formatFromRaw = ->
		Telefones.format.fromRaw @toJSON()

	Telefones
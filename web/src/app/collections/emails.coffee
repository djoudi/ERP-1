define [
	'backbone'
	'settings'
	'models/email'
], (Backbone, Settings, Email)->

	class Emails    extends Backbone.Collection
		model: Email

		initialize: (items, options)->
			@contato = options.contato if options.contato?

		url: ()->
			base = if @contato? then "#{@contato.url()}" else Settings.api.url
			base +="/telefones"

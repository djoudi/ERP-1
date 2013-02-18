define [
	'backbone'
	'settings'
	'pageable'
	'models/telefone'
	'models/email'
	'models/endereco'
	'collections/telefones'
	'collections/emails'
	'collections/enderecos'
	'backbone-forms-bootstrap'

], (Backbone, Settings, PageableCollection, Telefone, Email, Endereco, Telefones, Emails, Enderecos)->


	class Contato extends Backbone.Model	
		urlRoot: "#{Settings.api.url}/contatos"
		idAttribute: "id"
		parse: (response)->
			if (response.data)?
				response = response.data

			@set "telefones", new Telefones([], contato: @)
			@set "enderecos", new Enderecos([], contato: @)
			@set "emails",	  new Emails([], contato: @)

			if response.telefones?
				@get("telefones").reset(response.telefones)
				delete response.telefones

			if response.enderecos?
				@get("enderecos").reset(response.enderecos)
				delete response.enderecos

			if response.emails?
				@get("emails").reset(response.emails)
				delete response.emails
			response

		

		save: (attrs, options)->
			super(attrs, options)
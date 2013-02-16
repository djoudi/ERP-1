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

		idAttribute: "id"

		schema:
			nome:
				type: "Text"
				title: "Nome"

			pessoaJurica:
				title:	"Espécie"
				type: 	"Radio"
				options:	[
						val: true
						label: "Pessoa Jurídica"
					,
						val: false
						label: "Pessoa Física"
				]
			numeroDocumeno:
				type:	"Number"
				title:	"CPF/CNPJ"


			telefones:
				type: 		"List"
				itemType: 	"InlineNestedModel"
				model:		Telefone

			emails:
				type: 		"List"
				itemType: 	"InlineNestedModel"
				model:		Email

			enderecos:
				type: 		"List"
				itemType: 	"InlineNestedModel"
				model:		Endereco

			descricao:
				type:	"TextArea"
				title:	"Anotações"


		parse: (response)->
			if (response.data)?
				response = response.data

			@telefones = new Telefones([], contato: @)
			@enderecos = new Enderecos([], contato: @)
			@emails = new Emails([], contato: @)

			if response.telefones? && response.telefones.length
				@telefones.reset(response.telefones)

			if response.enderecos? && response.enderecos.length
				@enderecos.reset(response.enderecos)

			if response.emails? && response.emails.length
				@emails.reset(response.emails)
			response

		

		save: (attrs, options)->
			super(attrs, options)
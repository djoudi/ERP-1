define [
	'jquery'		
	'underscore'		
	'backbone'
	'models/contato'
	'models/telefone'
	'models/email'
	'models/endereco'
	'collections/contatos'
	'text!templates/contatos/editor.html'
	'backbone-forms-list'
	'backbone-forms-inline-nestedmodels'
], ($, _, Backbone, Contato, Telefone, Email, Endereco, Contatos, ContatosEditorTemplate)->


	UFs = [ 'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO' ]


	class ContatoEditorView extends Backbone.View
		className: 'editor modal fade'

		events:
			'click [data-action="save"]': 'save'

		template: _.template ContatosEditorTemplate

		initialize: (options)->
			@model = new Contato() if !@model? 

			@form = new Backbone.Form
				model: @model
				###
				#	Campos do Formulário
				###
				schema: 
					nome:
						type: "Text"
						title: "Nome / Razão Social"

					pessoaJuridica:
						title:	"Espécie"
						help:	"Determina o tipo do cadastro"
						type: 	"Select"
						options: [
								val: true
								label: "Pessoa Jurídica"
							,
								val: false
								label: "Pessoa Física"
						]
					numeroDocumento:
						type:	"Text"
						title:	"CPF/CNPJ"

					telefones:
						type: 		"List"
						itemType: 	"InlineNestedModel"
						template:	"listField"
						model:	Telefone
						subSchema:
							identificacao:
								type: 	"Select"
								title:	"Identificação"
								options: [
									"Empresarial"
									"Residencial"
									"Profissional"
									"Pessoal"
								]


							numero:
								type: 	"Text"
								dataType: "tel"
								title:	"Número"

							operadora:
								type: 	"Select"
								title:	"Operadora"
								options: [
									'Claro'
									'Tim'
									'Vivo'
									'Oi'
									'GVT'
									'Nextel'
									'NET Virtual'
								]

					emails:
						type: 		"List"
						itemType: 	"InlineNestedModel"
						template:	"listField"
						model:		Email
						subSchema:
							identificacao:
								type: "Select"
								title: "Identificação"
								options: [
									"Profissional"
									"Pessoal"
								]


							email:
								type: 	"Text"
								dataType: "email"
								title: "E-mail"

					enderecos:
						type: 		"List"
						itemType: 	"InlineNestedModel"
						template:	"listField"
						model:		Endereco
						subSchema:
							identificacao:
								type: "Select"
								title: "Identificação"
								options: [
									"Empresarial"
									"Residencial"
									"Celular"
								]


							cep:
								type: "Text"
								title: "CEP"

							numero:
								type: "Text"
								title: "Número"

							logradouro:
								type: "Text"
								title: "Logradouro"

							localidade:
								type: "Text"
								title: "Localidade"

							uf:
								type: "Select"
								title: "UF"
								options: UFs

					descricao:
						type:	"TextArea"
						template:"listField"
						title:	"Anotações"
				
				###
				#	Fieldsets que agrupa	ordena os campos
				###
				fieldsets: [
						legend:	'<i class="icon-user"></i> Dados Gerais'
						fields: [ "nome", "pessoaJuridica", "numeroDocumento" ]
					,
						legend:		'<i class="icon-phone"></i> Telefone(s)'
						fields: 	['telefones']
					,
						legend:		'<i class="icon-envelope"></i> E-mail(s)'
						fields: 	['emails']
					,
						legend:		'<i class="icon-pushpin"></i> Endereco(s)'
						fields:		['enderecos']
					,
						legend:		'<i class="icon-edit"></i> Anotaçoes'
						fields: 	['descricao']
				]


		render: ->
			@$el.html @template contato:@model.toJSON()
			@$el.modal
				backdrop: true

			@$('.modal-body').html @form.render().el


			@

		save: ->
			console.log @form.commit()
			console.log @model
			@model.save()

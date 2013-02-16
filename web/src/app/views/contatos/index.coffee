define [
	'jquery'		
	'underscore'		
	'backbone'
	'collections/contatos'
	'text!templates/contatos/index.html'
	'text!templates/contatos/index-item.html'
], ($, _, Backbone, Contatos, ContatosIndexTemplate, ContatosIndexItemTemplate)->


	class ContatoIndexView extends Backbone.View
		tagName: "tr"
		isSelected: no
		template: _.template ContatosIndexItemTemplate
		events:
			'click td' : 'select'

		render: ->
			@$el.html @template
				contato   : @model.toJSON()          
				emails    : @model.emails.toJSON()   
				enderecos : @model.enderecos.toJSON()
				telefones : @model.telefones.formatFromRaw()

			@input = @$("input")

			@

		toggleSelection: (toState = !@isSelected)->
			@input.prop "checked",  @isSelected = !@isSelected
			@$el.toggleClass "selected", @isSelected

			if @isSelected
				@trigger "selected", @ 
			else 
				@trigger "unselected", @ 
			
			@trigger "change:selection", @ 

		select: ->
			@toggleSelection true

		unselect: ->
			@toggleSelection false


	class ContatosIndexView extends Backbone.View
		template: _.template ContatosIndexTemplate
		initialize: (options)->
			super(options)
			@collection = new Contatos([]) if !@collections?
			@selected = {}

			@collection.on "add",	@addOne, @
			@collection.on "reset", @addAll, @
			@collection.on "all",	@render, @

			@collection.fetch()

		getSelected: ->
			@selected

		addOne: (contato) ->
			contatoView = new ContatoIndexView model:contato
			contatoView.on 'selected', (contato)=>
				@selected[contato.model.id] = contato

			contatoView.on 'unselected', (contato)=>
				delete @selected[contato.model.id]

			@$(".contatos").append  contatoView.render().el

		addAll: ->
			@collection.each @addOne, @

		render: ->
			@$el.html @template()
			@addAll()
			@


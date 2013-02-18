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
				emails    : @model.get("emails").toJSON()   
				enderecos : @model.get("enderecos").toJSON()
				telefones : @model.get("telefones").formatFromRaw()

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
		events:
			'click [data-action="edit"]' : "edit"
			'click [data-action="remove"]' : "remove"

		initialize: (options)->
			super(options)
			@collection = new Contatos([]) if !@collections?
			@selected = new Backbone.Collection

			@collection.on "add",	@addOne, @
			@collection.on "reset", @addAll, @
			@collection.on "all",	@render, @

			@selected.on "all", ()=>
				@editButton.toggleClass("disabled", !Boolean(@selected.length))
				@removeButton.toggleClass("disabled", !Boolean(@selected.length))

			@collection.fetch()

		getSelected: ->
			@selected

		edit: ->
			return if !@selected.length
			@trigger "edit", @selected.first()

		remove: ->
			return if !@selected.length
			@trigger "remove", @selected.first()


		addOne: (contato) ->
			contatoView = new ContatoIndexView model:contato
			contatoView.on 'selected', (contato)=>
				@selected.add contato.model

			contatoView.on 'unselected', (contato)=>
				@selected.remove contato.model

			@$(".contatos").append  contatoView.render().el

		addAll: ->
			@collection.each @addOne, @

		render: ->
			@$el.html @template()
			@addAll()

			@editButton = @$("[data-action='edit']")
			@removeButton =  @$("[data-action='remove']")

			@


define [
	'jquery'		
	'underscore'		
	'backbone'
	'models/contato'
	'collections/contatos'
	'text!templates/contatos/editor.html'
    'backbone-forms-list'
	'backbone-forms-inline-nestedmodels'
], ($, _, Backbone, Contato, Contatos, ContatosEditorTemplate)->
	

	class ContatoEditorView extends Backbone.View
		className: 'modal fade'

		template: _.template ContatosEditorTemplate

		initialize: (options)->
			@model = new Contato() if !@model? 
			@form = new Backbone.Form model: @model


		render: ->
			@$el.html @template contato:@model.toJSON()
			@$el.modal
				keyboard: true
				backdrop: true
			@$('.modal-body').html @form.render().el
			@


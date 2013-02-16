define [
	'jquery'		
	'underscore'		
	'backbone'
	'bootstrap'
	'text!templates/skeleton.html'
], ($, _, Backbone, Bootstrap, AppViewTemplate)->

	class AppView extends Backbone.View
		template: _.template(AppViewTemplate)
		title: "Carregando..."
		view: null
		rendered: false
		setView: (@view)->
			@render()

		setTitle: (@title)->
			@render()

		render: ()->
			if !@rendered
				@$el.html @template 
					title: @title
				@rendered = true

			if @view?
				@$("#view").html @view.render().$el

			@$(".main_container > header > .heading").text(@title)

			document.title = "#{@title} - Top Claro"
			@

	new AppView()
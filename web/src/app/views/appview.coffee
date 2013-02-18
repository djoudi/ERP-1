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
		setView: (@title, @view)->
			@render()

		render: ()->
			if !@rendered
				@$el.html @template 
					title: @title
				@rendered = true

			if @view?
				@$("#view").html @view.render().$el

			document.title = "#{@title} - Top Claro"
			@$("#view-title").html @title
			@

	new AppView()
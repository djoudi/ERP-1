define [
	'jquery'		
	'underscore'		
	'backbone'
	'modules/core/router'
	'bootstrap'
	'text!templates/pages/skeleton.html'
], ($, _, Backbone, Router, Bootstrap, SkeletonTemplate)->

	class Core extends Backbone.View
		template: _.template(SkeletonTemplate)
		defaults:
			"view": null
			"sessao": false

		initialize: ()->
			@router = new Router();
			Backbone.history.start();
			Backbone.Events.on "load_view", (PageView)=>
				@currentView = PageView
				

		render: ->
			@$el.html @template()
			@
		setPageView: (PageView)->

			@view.$el.detach();


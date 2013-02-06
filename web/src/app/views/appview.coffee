define [
	'jquery'		
	'underscore'		
	'backbone'
	'bootstrap'
	'text!templates/skeleton.html'
], ($, _, Backbone, Bootstrap, AppViewTemplate)->

	class AppView extends Backbone.View
		template: _.template(AppViewTemplate)
		render: ()->
			@$el.html @template()
			@
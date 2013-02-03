requirejs.config
	shim:
		jquery:
			exports: '$'

		underscore:
			exports: '_'

		backbone:
			deps: ['underscore', 'jquery'],
			exports: 'Backbone'

		bootstrap:
			deps: ['jquery'],
			exports: 'Bootstrap'

	paths:
		jquery: 	'vendors/jquery'
		backbone: 	'vendors/backbone'
		bootstrap: 	'vendors/bootstrap'
		underscore: 'vendors/underscore'
		subroute: 	'vendors/backbone.subroute'


require ['jquery', 'modules/core/core'], ($, Core)->
		$('body').html((new Core()).render().$el)
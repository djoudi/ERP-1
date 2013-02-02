requirejs.config
	shim:
		jquery:
			exports: '$'

		underscore:
			exports: '_'

		backbone:
			deps: ['underscore', 'jquery'],
			exports: 'Backbone'

	paths:
		jquery: 	'vendors/jquery'
		backbone: 	'vendors/backbone'
		underscore: 'vendors/underscore'
		subroute: 	'vendors/backbone.subroute'


require ["main"] 
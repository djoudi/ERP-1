requirejs.config
	shim:
		jquery:
			exports: 'jQuery'

		sprintf:
			exports: 'sprintf'

		underscore:
			exports: '_'

		backbone:
			deps: ['underscore', 'jquery'],
			exports: 'Backbone'

		bootstrap:
			deps: ['jquery'],
			exports: 'Bootstrap'

	paths:
		jquery: 			'../assets/js/libs/jquery'
		backbone: 			'../assets/js/libs/backbone'
		backgrid:			'../assets/js/libs/backgrid.min'
		pageable:			'../assets/js/libs/backbone-pageable.min'
		associations:		'../assets/js/libs/backbone.associations.min'
		relational:			'../assets/js/libs/backbone.relational.min'
		bootstrap: 			'../assets/js/libs/bootstrap'
		underscore: 		'../assets/js/libs/underscore'
		subroute: 			'../assets/js/libs/backbone.subroute'
		sprintf: 			'../assets/js/libs/sprintf'
		text:				'../assets/js/libs/text'


require [
	'controllers/core'
	'subroute'
	'text'
],
(CoreController)->
	new CoreController()
